<?php

namespace App\Http\Controllers;

use App\Events\AccountConnected;
use App\Helpers\Functions;
use App\Models\Account;
use App\Models\Agreement;
use App\Models\Institution;
use App\Models\Requisition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RequisitionController extends Controller
{
    //

    public function redirect(Request $request, $reference_id)
    {
        try
        {
            $requisition = Requisition::where('reference_id', $reference_id)->get()->first();
            $agreement = $requisition->agreement;
            $institution = $agreement->institution;

            /** @var \App\Models\User */
            $user = Auth::user();

            $return_array = [];

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
            ])->get(
                'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id . '/'
            );

            if ($response->successful())
            {
                $data = $response->json();
                $accounts = $data['accounts'];

                foreach ($accounts as $account_id)
                {
                    $account_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
                    ])->get(
                        'https://ob.nordigen.com/api/v2/accounts/' . $account_id . '/details/'
                    );

                    if ($account_response->successful())
                    {
                        $account_data = $account_response->json();

                        $account = Account::updateOrCreate(
                            [
                                'account_id' => $account_id,
                                'user_id' => $user->id,
                                'institution_id' => $institution->id
                            ],
                            [
                                'requisition_id' => $requisition->id,
                                'currency' => isset($account_data["account"]['currency']) ? $account_data["account"]['currency'] : null,
                                'bic' => isset($account_data["account"]['bic']) ? $account_data["account"]['bic'] : null,
                                'iban' => isset($account_data["account"]['iban']) ? $account_data["account"]['iban'] : null,
                                'bban' => isset($account_data["account"]['bban']) ? $account_data["account"]['bban'] : null,
                                'msisdn' => isset($account_data["account"]['msisdn']) ? $account_data["account"]['msisdn'] : null,
                                'account_name' => isset($account_data["account"]['name']) ? $account_data["account"]['name'] : null,
                                'display_name' => isset($account_data["account"]['displayName']) ? $account_data["account"]['displayName'] : null,
                                'owner_name' => isset($account_data["account"]['ownerName']) ? $account_data["account"]['ownerName'] : null,
                                'address' => isset($account_data["account"]['ownerAddressUnstructured']) ? $account_data["account"]['ownerAddressUnstructured'] : null,
                                'type' => isset($account_data["account"]['cashAccountType']) ? $account_data["account"]['cashAccountType'] : null,
                                'type_string' => isset($account_data["account"]['cashAccountType']) ? $this->getAccountTypeString($account_data["account"]['cashAccountType']) : null,
                                'status' => isset($account_data["account"]['status']) ? $account_data["account"]['status'] : null,
                                'usage' => isset($account_data["account"]['usage']) ? $account_data["account"]['usage'] : null,
                                'linked_accounts' => isset($account_data["account"]['linkedAccounts']) ? $account_data["account"]['linkedAccounts'] : null,
                                'resource_id' => isset($account_data["account"]['resourceId']) ? $account_data["account"]['resourceId'] : null,
                                'product_name' => isset($account_data["account"]['product']) ? $account_data["account"]['product'] : null,
                                'details' => isset($account_data["account"]['details']) ? $account_data["account"]['details'] : null,
                                'credit_score' => isset($account_data["account"]["scoring"]) ? $account_data["account"]['scoring']['value'] : null,
                            ]
                        );

                        $account_status_response = Http::withHeaders([
                            'accept' => 'application/json',
                            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
                        ])->get(
                            'https://ob.nordigen.com/api/v2/accounts/'.$account->account_id.'/'
                        );
                    
                        if($account_status_response->successful()){
                            $account_status_data = $account_status_response->json();
                            $account_status = $account_status_data['status'];
                            $account->account_status = $account_status;
                            $account->save();
                        }

                        $return_array[] = $account;

                        if(Functions::can_fetch_transaction($user)){
                            event(new AccountConnected($user, $account));
                        }

                        $user->update_error_code("account_error_code", null);
                    }
                    else
                    {
                        $user->update_error_code("account_error_code", $account_response->status());
                    }
                }

                $user->update_error_code("requisition_fetch_error_code", null);
            }
            else{
                $user->update_error_code("requisition_fetch_error_code", $response->status());
            }

            return view('auth.account_preview', ['accounts' => $return_array]);
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    public function reconnect(Request $request, $reference_id)
    {
        try
        {
            $requisition = Requisition::where('reference_id', $reference_id)->get()->first();
            $agreement = $requisition->agreement;
            $institution = $agreement->institution;

            /** @var \App\Models\User */
            $user = Auth::user();

            $return_array = [];

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
            ])->get(
                'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id . '/'
            );

            if ($response->successful())
            {
                $data = $response->json();
                $accounts = $data['accounts'];

                foreach ($accounts as $account_id)
                {
                    $account_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
                    ])->get(
                        'https://ob.nordigen.com/api/v2/accounts/' . $account_id . '/details/'
                    );

                    if ($account_response->successful())
                    {
                        $account_data = $account_response->json();
                        $array1 = [];
                        $array2 = [];
                        $account_count = Account::where('account_id',$account_id)->where('institution_id', $institution->id)->where('user_id', $user->id)->count();
                        if($account_count > 0){
                            $array1 = [
                                'account_id' => $account_id,
                                'user_id' => $user->id,
                                'institution_id' => $institution->id
                            ];
                            $array2 = [
                                'requisition_id' => $requisition->id,
                                'currency' => isset($account_data["account"]['currency']) ? $account_data["account"]['currency'] : null,
                                'bic' => isset($account_data["account"]['bic']) ? $account_data["account"]['bic'] : null,
                                'iban' => isset($account_data["account"]['iban']) ? $account_data["account"]['iban'] : null,
                                'bban' => isset($account_data["account"]['bban']) ? $account_data["account"]['bban'] : null,
                                'msisdn' => isset($account_data["account"]['msisdn']) ? $account_data["account"]['msisdn'] : null,
                                'account_name' => isset($account_data["account"]['name']) ? $account_data["account"]['name'] : null,
                                'display_name' => isset($account_data["account"]['displayName']) ? $account_data["account"]['displayName'] : null,
                                'owner_name' => isset($account_data["account"]['ownerName']) ? $account_data["account"]['ownerName'] : null,
                                'address' => isset($account_data["account"]['ownerAddressUnstructured']) ? $account_data["account"]['ownerAddressUnstructured'] : null,
                                'type' => isset($account_data["account"]['cashAccountType']) ? $account_data["account"]['cashAccountType'] : null,
                                'type_string' => isset($account_data["account"]['cashAccountType']) ? $this->getAccountTypeString($account_data["account"]['cashAccountType']) : null,
                                'status' => isset($account_data["account"]['status']) ? $account_data["account"]['status'] : null,
                                'usage' => isset($account_data["account"]['usage']) ? $account_data["account"]['usage'] : null,
                                'linked_accounts' => isset($account_data["account"]['linkedAccounts']) ? $account_data["account"]['linkedAccounts'] : null,
                                'resource_id' => isset($account_data["account"]['resourceId']) ? $account_data["account"]['resourceId'] : null,
                                'product_name' => isset($account_data["account"]['product']) ? $account_data["account"]['product'] : null,
                                'details' => isset($account_data["account"]['details']) ? $account_data["account"]['details'] : null,
                            ];
                        }
                        else{
                            if(isset($account_data["account"]['iban'])){
                                $array1 = [
                                    'iban' => $account_data["account"]['iban'],
                                    'user_id' => $user->id,
                                    'institution_id' => $institution->id
                                ];
                                $array2 = [
                                    'account_id' => $account_id,
                                    'requisition_id' => $requisition->id,
                                    'currency' => isset($account_data["account"]['currency']) ? $account_data["account"]['currency'] : null,
                                    'bic' => isset($account_data["account"]['bic']) ? $account_data["account"]['bic'] : null,
                                    'bban' => isset($account_data["account"]['bban']) ? $account_data["account"]['bban'] : null,
                                    'msisdn' => isset($account_data["account"]['msisdn']) ? $account_data["account"]['msisdn'] : null,
                                    'account_name' => isset($account_data["account"]['name']) ? $account_data["account"]['name'] : null,
                                    'display_name' => isset($account_data["account"]['displayName']) ? $account_data["account"]['displayName'] : null,
                                    'owner_name' => isset($account_data["account"]['ownerName']) ? $account_data["account"]['ownerName'] : null,
                                    'address' => isset($account_data["account"]['ownerAddressUnstructured']) ? $account_data["account"]['ownerAddressUnstructured'] : null,
                                    'type' => isset($account_data["account"]['cashAccountType']) ? $account_data["account"]['cashAccountType'] : null,
                                    'type_string' => isset($account_data["account"]['cashAccountType']) ? $this->getAccountTypeString($account_data["account"]['cashAccountType']) : null,
                                    'status' => isset($account_data["account"]['status']) ? $account_data["account"]['status'] : null,
                                    'usage' => isset($account_data["account"]['usage']) ? $account_data["account"]['usage'] : null,
                                    'linked_accounts' => isset($account_data["account"]['linkedAccounts']) ? $account_data["account"]['linkedAccounts'] : null,
                                    'resource_id' => isset($account_data["account"]['resourceId']) ? $account_data["account"]['resourceId'] : null,
                                    'product_name' => isset($account_data["account"]['product']) ? $account_data["account"]['product'] : null,
                                    'details' => isset($account_data["account"]['details']) ? $account_data["account"]['details'] : null,
                                ];
                            }
                            else if(isset($account_data["account"]['bban'])){
                                $array1 = [
                                    'bban' => $account_data["account"]['bban'],
                                    'user_id' => $user->id,
                                    'institution_id' => $institution->id
                                ];
                                $array2 = [
                                    'account_id' => $account_id,
                                    'requisition_id' => $requisition->id,
                                    'currency' => isset($account_data["account"]['currency']) ? $account_data["account"]['currency'] : null,
                                    'bic' => isset($account_data["account"]['bic']) ? $account_data["account"]['bic'] : null,
                                    'iban' => isset($account_data["account"]['iban']) ? $account_data["account"]['iban'] : null,
                                    'msisdn' => isset($account_data["account"]['msisdn']) ? $account_data["account"]['msisdn'] : null,
                                    'account_name' => isset($account_data["account"]['name']) ? $account_data["account"]['name'] : null,
                                    'display_name' => isset($account_data["account"]['displayName']) ? $account_data["account"]['displayName'] : null,
                                    'owner_name' => isset($account_data["account"]['ownerName']) ? $account_data["account"]['ownerName'] : null,
                                    'address' => isset($account_data["account"]['ownerAddressUnstructured']) ? $account_data["account"]['ownerAddressUnstructured'] : null,
                                    'type' => isset($account_data["account"]['cashAccountType']) ? $account_data["account"]['cashAccountType'] : null,
                                    'type_string' => isset($account_data["account"]['cashAccountType']) ? $this->getAccountTypeString($account_data["account"]['cashAccountType']) : null,
                                    'status' => isset($account_data["account"]['status']) ? $account_data["account"]['status'] : null,
                                    'usage' => isset($account_data["account"]['usage']) ? $account_data["account"]['usage'] : null,
                                    'linked_accounts' => isset($account_data["account"]['linkedAccounts']) ? $account_data["account"]['linkedAccounts'] : null,
                                    'resource_id' => isset($account_data["account"]['resourceId']) ? $account_data["account"]['resourceId'] : null,
                                    'product_name' => isset($account_data["account"]['product']) ? $account_data["account"]['product'] : null,
                                    'details' => isset($account_data["account"]['details']) ? $account_data["account"]['details'] : null,
                                ];
                            }
                            else if(isset($account_data["account"]['resourceId'])){
                                $array1 = [
                                    'resource_id' => $account_data["account"]['resourceId'],
                                    'user_id' => $user->id,
                                    'institution_id' => $institution->id
                                ];
                                $array2 = [
                                    'account_id' => $account_id,
                                    'requisition_id' => $requisition->id,
                                    'currency' => isset($account_data["account"]['currency']) ? $account_data["account"]['currency'] : null,
                                    'bic' => isset($account_data["account"]['bic']) ? $account_data["account"]['bic'] : null,
                                    'iban' => isset($account_data["account"]['iban']) ? $account_data["account"]['iban'] : null,
                                    'bban' => isset($account_data["account"]['bban']) ? $account_data["account"]['bban'] : null,
                                    'msisdn' => isset($account_data["account"]['msisdn']) ? $account_data["account"]['msisdn'] : null,
                                    'account_name' => isset($account_data["account"]['name']) ? $account_data["account"]['name'] : null,
                                    'display_name' => isset($account_data["account"]['displayName']) ? $account_data["account"]['displayName'] : null,
                                    'owner_name' => isset($account_data["account"]['ownerName']) ? $account_data["account"]['ownerName'] : null,
                                    'address' => isset($account_data["account"]['ownerAddressUnstructured']) ? $account_data["account"]['ownerAddressUnstructured'] : null,
                                    'type' => isset($account_data["account"]['cashAccountType']) ? $account_data["account"]['cashAccountType'] : null,
                                    'type_string' => isset($account_data["account"]['cashAccountType']) ? $this->getAccountTypeString($account_data["account"]['cashAccountType']) : null,
                                    'status' => isset($account_data["account"]['status']) ? $account_data["account"]['status'] : null,
                                    'usage' => isset($account_data["account"]['usage']) ? $account_data["account"]['usage'] : null,
                                    'linked_accounts' => isset($account_data["account"]['linkedAccounts']) ? $account_data["account"]['linkedAccounts'] : null,
                                    'product_name' => isset($account_data["account"]['product']) ? $account_data["account"]['product'] : null,
                                    'details' => isset($account_data["account"]['details']) ? $account_data["account"]['details'] : null,
                                ];
                            }
                        }
                        

                        $account = Account::updateOrCreate(
                            $array1,
                            $array2
                        );

                        $account_status_response = Http::withHeaders([
                            'accept' => 'application/json',
                            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
                        ])->get(
                            'https://ob.nordigen.com/api/v2/accounts/'.$account->account_id.'/'
                        );
                    
                        if($account_status_response->successful()){
                            $account_status_data = $account_status_response->json();
                            $account_status = $account_status_data['status'];
                            $account->account_status = $account_status;
                            $account->save();
                        }

                        $return_array[] = $account;

                        if(Functions::can_fetch_transaction($user)){
                            event(new AccountConnected($user, $account));
                        }

                        $user->update_error_code("account_error_code", null);
                    }
                    else
                    {
                        $user->update_error_code("account_error_code", $account_response->status());
                    }
                }

                $user->update_error_code("requisition_fetch_error_code", null);
            }
            else{
                $user->update_error_code("requisition_fetch_error_code", $response->status());
            }

            return view('auth.account_preview', ['accounts' => $return_array]);
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    public function overview(Request $request, $reference_id){
        $requisition = Requisition::where('reference_id', $reference_id)->get()->first();
        $accounts = $requisition->accounts;
        return view('auth.account_overview', ['accounts' => $accounts]);
    }

    private function getAccountTypeString($type)
    {
        switch ($type)
        {
            case 'CACC':
                return "Current";
            case 'CASH':
                return "CashPayment";
            case 'CHAR':
                return "Charges";
            case 'CISH':
                return "CashIncome";
            case 'COMM':
                return "Commission";
            case 'CPAC':
                return "ClearingParticipantSettlementAccount";
            case 'LLSV':
                return "LimitedLiquiditySavingsAccount";
            case 'LOAN':
                return "Loan";
            case 'MGLD':
                return "Marginal Lending";
            case 'MOMA':
                return "Money Market";
            case 'NREX':
                return "NonResidentExternal";
            case 'ODFT':
                return "Overdraft";
            case 'ONDP':
                return "OverNightDeposit";
            case 'OTHR':
                return "OtherAccount";
            case 'SACC':
                return "Settlement";
            case 'SLRY':
                return "Salary";
            case 'SVGS':
                return "Savings";
            case 'TAXE':
                return "Tax";
            case 'TRAN':
                return "TransactingAccount";
            case 'TRAS':
                return "Cash Trading";
            default:
                return "";
        }
    }

    public function destroy(Request $request, Requisition $requisition)
    {
        try
        {
            /** @var \App\Models\User */
            $user = Auth::user();

            $requisition_delete_response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
            ])->delete(
                'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id
            );

            if($requisition_delete_response->successful()){
                $requisition->delete();
                $user->update_error_code("requisition_delete_error_code", null);
                return redirect(route('my.accounts'))->with('success','Access to the Bank Accounts has been Removed.');
            }
            else{
                $user->update_error_code("requisition_delete_error_code", $requisition_delete_response->status());
                $error_json = $requisition_delete_response->json();
                Log::error($error_json);
                return redirect(route('my.accounts'))->with('danger','Error Raised while Removing Bank Account Access. Please try again later');
            }
            
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    public function reconnect_account(Request $request, $requisition_id)
    {
        $old_requisition = Requisition::find($requisition_id);
        $old_agreement = $old_requisition->agreement;
        $institution = $old_agreement->institution;
        $iid = $institution->institution_id;
        $user = Auth::user();
        $flash_message = "";
        // $iid = "SANDBOXFINANCE_SFIN0000";
        $new_agreement = $this->createAgreement($old_agreement, $iid, $user);
        if ($new_agreement != false)
        {
            $reference_id = uniqid("" . $user->id, true);
            $new_requisition = $this->createLink($reference_id, $iid, $new_agreement['id'], $user);
            if ($new_requisition != false)
            {
                $link = $this->redirectToLink($old_agreement, $new_agreement, $institution, $old_requisition, $new_requisition, $reference_id, $user);
                if($link != false){
                    header("Location: ".$link);
                    exit();
                }
                else{
                    $flash_message = "There was an error while reconnecting your account.";
                }
            }
            else
            {
                $flash_message = "There was an error while reconnecting your account.";
            }
        }
        else
        {
            $flash_message = "There was an error while reconnecting your account.";
        }

        // if($flash_message != ""){
        //     Session::flash('warning', $flash_message);
        // }

        return redirect()->back()->with('warning', $flash_message);
    }

    private function createAgreement($oa, $iid, $user)
    {
        $access_scope = [];

        if ($oa->balances_scope == 1)
        {
            $access_scope[] = 'balances';
        }
        if ($oa->details_scope == 1)
        {
            $access_scope[] = 'details';
        }
        if ($oa->transactions_scope == 1)
        {
            $access_scope[] = 'transactions';
        }

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/agreements/enduser/',
            [
                'institution_id' => $iid,
                'max_historical_days' => $oa->max_historical_days,
                'access_valid_for_days' => $oa->access_valid_for_days,
                'access_scope' => $access_scope
            ]
        );

        if ($response->successful())
        {
            $data = $response->json();
            $user->update_error_code("agreement_error_code", null);
            return $data;
        }
        else
        {
            $user->update_error_code("agreement_error_code", $response->status());
            return false;
        }
    }

    private function createLink($ref_id, $iid, $aid, $user)
    {

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
        ])->post(
            'https://ob.nordigen.com/api/v2/requisitions/',
            [
                'redirect' => env('APP_URL') ."/reconnect/status/" . $ref_id, // env('APP_URL') . 
                'institution_id' => $iid,
                'reference' => "" . $ref_id,
                'agreement' => $aid,
                'user_language' => 'EN',
            ]
        );

        if ($response->successful())
        {
            $data = $response->json();

            $user->update_error_code("requisition_create_error_code", null);
            return $data;
        }
        else
        {
            $user->update_error_code("requisition_create_error_code", $response->status());
            return false;
        }
    }

    private function redirectToLink($old_agree, $new_agree, $institution, $old_req, $new_req, $ref, $user)
    {
        try{
            $balances_access_scope = 0;
            $details_access_scope = 0;
            $transactions_access_scope = 0;
            if ($old_agree->balances_scope == 1)
            {
                $balances_access_scope = 1;
            }
            if ($old_agree->details_scope == 1)
            {
                $details_access_scope = 1;
            }
            if ($old_agree->transactions_scope == 1)
            {
                $transactions_access_scope = 1;
            }

            $agreement = new Agreement([
                'user_id' => $user->id,
                'agreement_id' => $new_agree['id'],
                'agreement_date' => $new_agree['created'],
                'balances_scope' => $balances_access_scope,
                'details_scope' => $details_access_scope,
                'transactions_scope' => $transactions_access_scope,
                'max_historical_days' => $old_agree->max_historical_days,
                'access_valid_for_days' => $old_agree->access_valid_for_days,
                'accepted' => $new_agree['accepted'],
                'institution_id' => $institution->id,
                'ip_address' => request()->ip(),
            ]);
            $agreement->save();

            $requisition = new Requisition([
                'agreement_id' => $agreement->id,
                'requisition_id' => $new_req['id'],
                'language' => 'EN',
                'status' => $new_req['status'],
                'status_long' => $this->getRequisitionStatusLong($new_req['status']),
                'status_description' => $this->getRequisitionStatusDescription($new_req['status']),
                'reference_id' => $ref,
                'link' => $new_req['link'],
            ]);
            $requisition->save();

            return $new_req['link'];
        }
        catch(Exception $e){
            Log::debug($e->getMessage());
            return false;
        }
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
