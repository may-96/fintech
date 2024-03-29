<?php

namespace App\Http\Livewire;

use App\Helpers\Functions;
use App\Models\Agreement;
use App\Models\Country;
use App\Models\Institution;
use App\Models\Requisition;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;

use Livewire\Component;
use phpDocumentor\Reflection\Location as ReflectionLocation;

class RequestLinkView extends Component
{
    public $data;
    public $user;
    public $curr_uri;

    public $countries = [];
    public $country_name;
    public $country_code;
    public $country_selected = false;

    public $banks = [];
    public $bank_name;
    public $bank_id;
    public $bank_ttd;
    public $bank_bic;
    public $bank_logo;
    public $bank_selected = false;

    public $status_message;
    public $sandbox_id = "SANDBOXFINANCE_SFIN0000";

    public $max_historical_days = 90;
    public $access_valid_for_days = 90;
    public $balances_access_scope = true;
    public $transactions_access_scope = true;
    public $details_access_scope = true;
    public $access_scope = [];
    public $agreement_error_message = "";

    public $agreement_id = "";
    public $agreement_created = "";
    public $agreement_accepted = "";

    public $create_link = false;

    public $reference_id;
    public $requisition_id;
    public $requisition_status;
    public $requisition_link;

    public $link_generated = false;
    public $ip_based = false;
    
    public function mount($data, $ip){
        $this->data = $data;
        $this->curr_uri = Request::path() . "#form_area";
        if(Auth::check()){
            $this->user = Auth::user();
        }
        else{
            session()->put('intended',$this->curr_uri);
            $this->user = null;
        }

        if(Functions::not_empty($this->user) && Functions::not_empty($ip)){
            try{
                $position = Location::get($ip);
                if(Functions::not_empty($position)){
                    $this->country_code = $position->countryCode;
                    $this->country_name = $position->countryName;
                    $this->country_selected = true;
                    $this->updateCountry();
                    $this->ip_based = true;
                }
            }
            catch(Exception $e){

            }
        }
        
        $this->countries = Country::all();


    }

    public function render()
    {
        return view('livewire.request-link-view');
    }

    public function updateCountry()
    {
        $country_code = strtolower($this->country_code);
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->get(
            'https://ob.nordigen.com/api/v2/institutions/',
            ['country' => $country_code,]
        );

        if ($response->successful())
        {
            $data = $response->json();
            if ($response->successful())
            {
                $this->banks = $data;
                $this->country_selected = true;
                $this->bank_selected = false;
                $this->create_link = false;
                $this->link_generated = false;
            }
            else
            {
                $this->status_message = "Error raised while fetching the banks for the selected country. ";
                $this->banks = [];
                $this->country_selected = false;
                $this->bank_selected = false;
                $this->create_link = false;
                $this->link_generated = false;
            }

            $this->user->update_error_code("institution_error_code", null);
        }
        else
        {
            $this->user->update_error_code("institution_error_code", $response->status());
            
        }
    }

    public function updateBank()
    {
        $this->bank_selected = true;
        $this->createAgreement();
        $this->createLink();
        // $this->create_link = false;
        // $this->link_generated = false;
    }

    public function createAgreement()
    {
        $this->create_link = false;
        $this->link_generated = false;
        
        $this->max_historical_days = $this->bank_ttd;

        $this->agreement_error_message = "";
        if ($this->access_valid_for_days < 30)
        {
            $this->agreement_error_message = "Please Enter Access Valid for Days greater than or equal to 30";
            return;
        }
        if ((int) $this->max_historical_days < 30)
        {
            $this->agreement_error_message = "Please Enter Max Data Historical Days greater than or equal to 30";
            return;
        }
        if ((int) $this->max_historical_days > (int) $this->bank_ttd)
        {
            $this->agreement_error_message = "Please Enter Max Data Historical Days less than or equal to " . $this->bank_ttd;
            return;
        }

        $this->access_scope = [];

        if ($this->balances_access_scope)
        {
            $this->access_scope[] = 'balances';
        }
        if ($this->details_access_scope)
        {
            $this->access_scope[] = 'details';
        }
        if ($this->transactions_access_scope)
        {
            $this->access_scope[] = 'transactions';
        }

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/agreements/enduser/',
            [
                'institution_id' => $this->bank_id,
                'max_historical_days' => $this->max_historical_days,
                // 'institution_id' => $this->sandbox_id,
                // 'max_historical_days' => 90,
                'access_valid_for_days' => $this->access_valid_for_days,
                'access_scope' => $this->access_scope
            ]
        );

        if ($response->successful())
        {
            $data = $response->json();

            $this->agreement_id = $data['id'];
            $this->agreement_created = $data['created'];
            $this->agreement_accepted = $data['accepted'];

            $this->create_link = true;
            $this->link_generated = false;

            $this->user->update_error_code("agreement_error_code", null);
        }
        else{
            $this->user->update_error_code("agreement_error_code", $response->status());
        }
    }

    public function createLink()
    {
        $this->link_generated = false;
        $this->reference_id = uniqid("" . $this->user->id, true);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/requisitions/',
            [
                'redirect' => env('APP_URL') . "/connect/status/" . $this->reference_id,
                'institution_id' => $this->bank_id,
                // 'institution_id' => $this->sandbox_id,
                'reference' => "" . $this->reference_id,
                'agreement' => $this->agreement_id,
                'user_language' => 'EN',
            ]
        );

        if($response->successful()){
            $data = $response->json();

            $this->requisition_id = $data['id'];
            $this->requisition_status = $data['status'];
            $this->requisition_link = $data['link'];

            $this->link_generated = true;

            $this->user->update_error_code("requisition_create_error_code", null);
        }
        else{
            $this->user->update_error_code("requisition_create_error_code", $response->status());
        }
    }

    public function redirectToLink()
    {

        $institution = Institution::firstOrCreate(
            [
                'institution_id' => $this->bank_id,
                // 'institution_id' => $this->sandbox_id
            ],
            [
                'name' => $this->bank_name,
                'bic' => $this->bank_bic,
                'transaction_total_days' => $this->bank_ttd,
                'logo' => $this->bank_logo
            ]
        );

        $agreement = new Agreement([
            'user_id' => $this->user->id,
            'agreement_id' => $this->agreement_id,
            'agreement_date' => $this->agreement_created,
            'balances_scope' => $this->balances_access_scope,
            'details_scope' => $this->details_access_scope,
            'transactions_scope' => $this->transactions_access_scope,
            'max_historical_days' => $this->max_historical_days,
            // 'max_historical_days' => 90,
            'access_valid_for_days' => $this->access_valid_for_days,
            'accepted' => $this->agreement_accepted,
            'institution_id' => $institution->id,
            'ip_address' => request()->ip(),
        ]);
        $agreement->save();

        $requisition = new Requisition([
            'agreement_id' => $agreement->id,
            'requisition_id' => $this->requisition_id,
            'language' => 'EN',
            'status' => $this->requisition_status,
            'status_long' => $this->getRequisitionStatusLong($this->requisition_status),
            'status_description' => $this->getRequisitionStatusDescription($this->requisition_status),
            'reference_id' => $this->reference_id,
            'link' => $this->requisition_link,
        ]);
        $requisition->save();

        session()->put('intended_report_share_redirect', $this->curr_uri);
        $this->emit('processConnectLink');
    }

    private function getRequisitionStatusLong($status)
    {
        switch ($status)
        {
            case 'CR':
                return "CREATED";
            case 'LN':
                return "LINKED";
            case 'EX':
                return "EXPIRED";
            case 'RJ':
                return "REJECTED";
            case 'UA':
                return "UNDERGOING_AUTHENTICATION";
            case 'GA':
                return "GRANTING_ACCESS";
            case 'SA':
                return "SELECTING_ACCOUNTS";
            case 'SU':
                return "SUSPENDED";
            case 'GC':
                return "GIVING_CONSENT";
            default:
                return "";
        }
    }

    private function getRequisitionStatusDescription($status)
    {
        switch ($status)
        {
            case 'CR':
                return "Requisition has been successfully created";
            case 'LN':
                return "Account has been successfully linked to requisition";
            case 'EX':
                return "Access to account has expired as set in End User Agreement";
            case 'RJ':
                return "SSN verification has failed";
            case 'UA':
                return "End-user is redirected to the financial institution for authentication";
            case 'GA':
                return "End-user is granting access to their account information";
            case 'SA':
                return "End-user is selecting accounts";
            case 'SU':
                return "Requisition is suspended due to numerous consecutive errors that happened while accessing its accounts";
            case 'GC':
                return "End-user is giving consent at Nordigen's consent screen";
            default:
                return "";
        }
    }
}
