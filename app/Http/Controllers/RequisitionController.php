<?php

namespace App\Http\Controllers;

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
            $user = Auth::user();

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
            ])->get(
                'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id . '/'
            );
            $data = $response->json();

            $accounts = $data['accounts'];
            $return_array = [];
            foreach ($accounts as $account_id)
            {
                $account_response = Http::withHeaders([
                    'accept' => 'application/json',
                    'Authorization' => 'Bearer ' . Crypt::decryptString(Session::get('access_token')),
                ])->get(
                    'https://ob.nordigen.com/api/v2/accounts/' . $account_id . '/details/'
                );
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

                $return_array[] = $account;
            }

            return view('auth.account_preview', ['accounts' => $return_array]);
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
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
}
