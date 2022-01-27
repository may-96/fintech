<?php

namespace App\Helpers;

use App\Models\Balance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Functions
{

    public static function is_empty($var){
        return empty($var) || is_null($var);
    }

    public static function not_empty($var){
        return !Functions::is_empty($var);
    }

    public static function filtered_request_data(Request $request){
        $data = $request->all();
        foreach ($data as $i => $d){
            if ($d === "null" || $d === ""){
                $data[$i] = null;
            }
        }
        return $data;
    }

    public static function add_or_update_transactions($t, $account, $status){
        $custom_uid = Functions::get_transaction_custom_uid($t);
        $transaction = Transaction::updateOrCreate(
            [
                'account_id' => $account->id,
                'custom_uid' => $custom_uid,
                'transaction_amount' => $t["transactionAmount"]["amount"],
                'fixed_date' => (isset($t["valueDate"]) ? $t["valueDate"] : $t["bookingDate"]),
            ],
            [
                "year" => isset($t["valueDate"]) ? Carbon::parse($t["valueDate"])->format("Y") : Carbon::parse($t["bookingDate"])->format("Y"),
                "transaction_id" => isset($t["transactionId"]) ? $t["transactionId"] : null,
                "transaction_currency" => isset($t["transactionAmount"]["currency"]) ? $t["transactionAmount"]["currency"] : null,
                "booking_date" => isset($t["bookingDate"]) ? $t["bookingDate"] : null,
                "value_date" => isset($t["valueDate"]) ? $t["valueDate"] : null,
                "remit_info_unstructured" => isset($t["remittanceInformationUnstructured"]) ? $t["remittanceInformationUnstructured"] : null,
                "debator_name" => isset($t["debtorName"]) ? $t["debtorName"] : null,
                "debtor_account" => isset($t["debtorAccount"]["iban"]) ? $t["debtorAccount"]["iban"] : (isset($t["debtorAccount"]["bban"]) ? $t["debtorAccount"]["bban"] : (isset($t["debtorAccount"]["resourceId"]) ? $t["debtorAccount"]["resourceId"] : null)),
                "creditor_name" => isset($t["creditorName"]) ? $t["creditorName"] : null,
                "creditor_account" => isset($t["creditorAccount"]["iban"]) ? $t["creditorAccount"]["iban"] : (isset($t["creditorAccount"]["bban"]) ? $t["creditorAccount"]["bban"] : (isset($t["creditorAccount"]["resourceId"]) ? $t["creditorAccount"]["resourceId"] : null)),
                "additional_information" => isset($t["additionalInformation"]) ? $t["additionalInformation"] : null,
                "entry_reference" => isset($t["entryReference"]) ? $t["entryReference"] : null,
                "category" => isset($t["categorisation"]) ? $t["categorisation"]["categoryTitle"] : null,
                "merchant_name" => isset($t["cleaning"]) ? $t["cleaning"]["merchantName"] : null,
                "transaction_type" => isset($t["cleaning"]) ? $t["cleaning"]["transactionType"] : null,
                "purpose_code" => isset($t["purposeCode"]) ? $t["purposeCode"] : null,
                "bank_transaction_code" => isset($t["bankTransactionCode"]) ? $t["bankTransactionCode"] : null,
                "status" => $status,
            ]
        );
    }

    public static function get_transaction_custom_uid($transaction){
        if(isset($transaction["transactionId"])){
            return $transaction["transactionId"];
        }
        else if(isset($transaction["entryReference"])){
            return $transaction["entryReference"];
        }
        else if(isset($transaction["bankTransactionCode"])){
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) ."-". $transaction["bankTransactionCode"];
        }
        else if(isset($transaction['remittanceInformationUnstructured'])){
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) ."-". $transaction["remittanceInformationUnstructured"];
        }
        else{
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) ."-".$transaction["transactionAmount"]["currency"]."".$transaction["transactionAmount"]["amount"];
        }
    }

    public static function update_account_balance($account, $balance){
        $balances_array = $balance["balances"];
        foreach($balances_array as $ba){
            $btype = $ba["balanceType"];
            if($btype == "closingBooked" || $btype == "expected"){
                $balance_obj = Balance::updateOrCreate(
                    [
                        'account_id' => $account->id,
                        'currency' => $ba["balanceAmount"]["currency"],
                        'type' => $btype,
                    ],
                    [
                        'amount' => $ba["balanceAmount"]["amount"],
                    ]
                );
            }
        }
    }

    public static function can_fetch_transaction($user){
        $lft = $user->last_transaction_fetch_time;
        if($lft != null && Carbon::now() > Carbon::parse($lft)->addMinutes(config('app.settings.transaction_fetch_wait_time'))){
            return true;
        }
        else if($lft == null){
            return true;
        }
        else{
            return false;
        }
    }
}
