<?php

namespace App\Http\Controllers;

use App\Events\AccountConnected;
use App\Helpers\Functions;
use App\Models\Account;
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
}
