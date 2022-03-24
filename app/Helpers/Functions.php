<?php

namespace App\Helpers;

use App\Models\Balance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Events\SendNotification;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Token;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class Functions
{

    public static $month_array = [
        '1' => 'Jan',
        '2' => 'Feb',
        '3' => 'Mar',
        '4' => 'Apr',
        '5' => 'May',
        '6' => 'Jun',
        '7' => 'Jul',
        '8' => 'Aug',
        '9' => 'Sep',
        '10' => 'Oct',
        '11' => 'Nov',
        '12' => 'Dec'
    ];

    public static function is_empty($var)
    {
        return empty($var) || is_null($var);
    }

    public static function not_empty($var)
    {
        return !Functions::is_empty($var);
    }

    public static function filtered_request_data(Request $request)
    {
        $data = $request->all();
        foreach ($data as $i => $d)
        {
            if ($d === "null" || $d === "")
            {
                $data[$i] = null;
            }
        }
        return $data;
    }

    public static function add_or_update_transactions($t, $account, $status)
    {
        Log::debug($t);
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
                'end_to_end_id' => isset($t["endToEndId"]) ? $t["endToEndId"] : null,
                
                "additional_information_structured" => isset($t["additionalInformationStructured"]) ? json_encode($t["additionalInformationStructured"]) : null,
                "balance_after_transaction" => isset($t["balanceAfterTransaction"]) ? json_encode($t["balanceAfterTransaction"]) : null,
                "check_id" => isset($t["checkId"]) ? $t["checkId"] : null,
                "creditor_agent" => isset($t["creditorAgent"]) ? $t["creditorAgent"] : null,
                "creditor_id" => isset($t["creditorId"]) ? $t["creditorId"] : null,
                "currency_exchange" => isset($t["currencyExchange"]) ? $t["currencyExchange"] : null,
                "debtor_agent" => isset($t["debtorAgent"]) ? $t["debtorAgent"] : null,
                "mandate_id" => isset($t["mandateId"]) ? $t["mandateId"] : null,
                "proprietary_bank_transaction_code" => isset($t["proprietaryBankTransactionCode"]) ? $t["proprietaryBankTransactionCode"] : null,
                "remittance_information_structured" => isset($t["remittanceInformationStructured"]) ? $t["remittanceInformationStructured"] : null,
                "remittance_information_structured_array" => isset($t["remittanceInformationStructuredArray"]) ? json_encode($t["remittanceInformationStructuredArray"]) : null,
                "remittance_information_unstructured_array" => isset($t["remittanceInformationUnstructuredArray"]) ? json_encode($t["remittanceInformationUnstructuredArray"]) : null,
                "ultimate_creditor" => isset($t["ultimateCreditor"]) ? $t["ultimateCreditor"] : null,
                "ultimate_debtor" => isset($t["ultimateDebtor"]) ? $t["ultimateDebtor"] : null,

            ]
        );
    }

    public static function get_transaction_custom_uid($transaction)
    {
        if (isset($transaction["transactionId"]))
        {
            return $transaction["transactionId"];
        }
        else if (isset($transaction["entryReference"]))
        {
            return $transaction["entryReference"];
        }
        else if (isset($transaction["bankTransactionCode"]))
        {
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) . "-" . $transaction["bankTransactionCode"];
        }
        else if (isset($transaction['remittanceInformationUnstructured']))
        {
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) . "-" . $transaction["remittanceInformationUnstructured"];
        }
        else
        {
            return (isset($transaction["valueDate"]) ? $transaction["valueDate"] : $transaction["bookingDate"]) . "-" . $transaction["transactionAmount"]["currency"] . "" . $transaction["transactionAmount"]["amount"];
        }
    }

    public static function update_account_balance($account, $balance)
    {
        $balances_array = $balance["balances"];
        foreach ($balances_array as $ba)
        {
            $btype = $ba["balanceType"];
            if ($btype == "closingBooked" || $btype == "expected")
            {
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

    public static function can_fetch_transaction($user)
    {
        $lft = $user->last_transaction_fetch_time;
        if ($lft != null && Carbon::now() > Carbon::parse($lft)->addMinutes(config('app.settings.transaction_fetch_wait_time')))
        {
            return true;
        }
        else if ($lft == null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * ...
     *
     * @param  \App\Models\User   $user
     */
    public static function cash_flow_stats($user, $years = 2)
    {
        $active_month = Carbon::today()->month;
        $active_year = Carbon::today()->year;

        $accounts = $user->accounts;

        $months_in_year = $years * 12;

        $cash_flow_data = [];
        $income_data = [];
        $expense_data = [];

        $total_cash_in = 0;
        $total_cash_out = 0;
        $average_cash_in = 0;
        $average_cash_out = 0;

        $salary_total = 0;

        if(count($accounts) == 0){
            return 0;
        }
        
        foreach ($accounts as $account)
        {
            $i = 0;
            $total_months = 0;
            $tci = 0;
            $tco = 0;
            $currency = strtoupper($account->currency);
            $exchange = Currency::convert()->from($currency)->to(config('app.settings.report_currency'))->amount(1)->get();
            while ($i < $months_in_year)
            {

                $transactions = $account->transactions()->whereYear('fixed_date',$active_year)->whereMonth('fixed_date',$active_month);
                $cash_in_transactions = $transactions->where('transaction_amount', '>', 0);
                $cash_in_count = $cash_in_transactions->count();
                $cis = $cash_in_transactions->sum('transaction_amount');
                $cash_in_sum = $exchange * abs($cis);

                $transactions = $account->transactions()->whereYear('fixed_date',$active_year)->whereMonth('fixed_date',$active_month);
                $cash_out_transactions = $transactions->where('transaction_amount', '<', 0);
                $cash_out_count = $cash_out_transactions->count();
                $cos = $cash_out_transactions->sum('transaction_amount');
                $cash_out_sum = $exchange * abs($cos);
                
                $month_name = self::$month_array[(string) $active_month] . ', ' . $active_year;

                --$active_month;
                if ($active_month === 0)
                {
                    $active_month = 12;
                    --$active_year;
                }

                $i++;

                if($cash_out_count == 0 && $cash_in_count == 0){
                    continue;
                }

                $total_cash_in += $cash_in_sum;
                $total_cash_out += $cash_out_sum;
                $tci += $cash_in_sum;
                $tco += $cash_out_sum;
                $total_months += 1;

                if (array_key_exists($month_name, $cash_flow_data))
                {
                    $cash_flow_data[$month_name][0] += $cash_in_count;
                    $cash_flow_data[$month_name][1] += abs($cash_in_sum);
                    $cash_flow_data[$month_name][2] += $cash_out_count;
                    $cash_flow_data[$month_name][3] += abs($cash_out_sum);
                }
                else
                {
                    $cash_flow_data[$month_name] = [$cash_in_count, abs($cash_in_sum), $cash_out_count, abs($cash_out_sum)];
                }                
            }

            $cat_total = Functions::specific_category_total($account,$years,'Salary',$exchange);
            $salary_total += $cat_total;

            if($total_months > 0){
                $average_cash_in += $tci / $total_months;
                $average_cash_out += $tco / $total_months;
            }

            $income_data = Functions::get_income_expense_data($account, $income_data, $years, 'income', $exchange);
            $expense_data = Functions::get_income_expense_data($account, $expense_data, $years, 'expense', $exchange);
        }

        $salary_monthly = 0;
        if(count($cash_flow_data) > 0){
            $salary_monthly = $salary_total / count($cash_flow_data);
        }
        

        if($accounts->count() > 0){
            $average_cash_in = $average_cash_in / $accounts->count();
            $average_cash_out = $average_cash_out / $accounts->count();
        }

        $diff = $average_cash_in - $average_cash_out;
        $percent = 0;
        if($diff >= 0){
            if($average_cash_in > 0){
                $percent = ($diff / $average_cash_in ) *  100;
            }
        }
        else{
            if($average_cash_out > 0){
                $percent = ($diff / $average_cash_out ) *  100;
            }
        }

        $credit_score = ($percent + 100) / 2;
        $credit_rating = "Average";
        $credit_color = "secondary";
        if($credit_score >= 0 && $credit_score < 20){
            $credit_rating = "Horrible";
            $credit_color = "red";
        }
        else if($credit_score >= 20 && $credit_score < 40){
            $credit_rating = "Poor";
            $credit_color = "orange";
        }
        else if($credit_score >= 40 && $credit_score < 60){
            $credit_rating = "Average";
            $credit_color = "secondary";
        }
        else if($credit_score >= 60 && $credit_score < 80){
            $credit_rating = "Good";
            $credit_color = "primary";
        }
        else{
            $credit_rating = "Outstanding";
            $credit_color = "green";
        }      

        return [
            $cash_flow_data, 
            $income_data, 
            $expense_data, 
            $total_cash_in, 
            $total_cash_out, 
            $average_cash_in, 
            $average_cash_out, 
            $accounts->count(), 
            $credit_score, 
            $credit_rating, 
            $credit_color, 
            $diff, 
            $salary_monthly
        ];
    }

    private static function get_income_expense_data($account, $data, $years, $type, $exchange){
        $currency = strtoupper($account->currency);
        $categories = Category::where('type', $type)->get();
        foreach($categories as $category){
            $name = $category->name;
            $transactions = $account->transactions()->where('fixed_date','<',Carbon::now())->where('fixed_date','>',Carbon::now()->subYears($years))->where('category_id', $category->id);
            $category_transaction_count = $transactions->count();
            $ctt = $transactions->sum('transaction_amount');
            $category_transaction_total = $exchange * abs($ctt);
            $category_transaction_average = 0;
            if($category_transaction_count > 0 && abs($category_transaction_total) > 0){
                $category_transaction_average = $category_transaction_total / $category_transaction_count;

                if (array_key_exists($name, $data))
                {
                    $data[$name][0] += $category_transaction_count;
                    $data[$name][1] += abs($category_transaction_total);
                    $data[$name][2] += abs($category_transaction_average);
                }
                else
                {
                    $data[$name] = [$category_transaction_count, abs($category_transaction_total), abs($category_transaction_average)];
                }
            }
        }
        return $data;
    }

    private static function specific_category_total($account, $years, $name, $exchange){
        $category = Category::where('name', $name)->get()->first();
        $transactions = $account->transactions()->where('fixed_date','<',Carbon::now())->where('fixed_date','>',Carbon::now()->subYears($years))->where('category_id', $category->id);
        $ctt = $transactions->sum('transaction_amount');
        $category_transaction_total = $exchange * abs($ctt);

        return $category_transaction_total;
    }

    public static function fetchTransactions($user, $account, $df, $dt){
        $requisition = $account->requisition;
        $agreement = $account->agreement;

        if ($account->account_status != 'EXPIRED' && ($requisition->status_long != 'EXPIRED' || $requisition->status_long != 'SUSPENDED'))
        {
            try
            {
                $token = Token::where('status', 1)->get()->first();
                $query = [];

                $baseURL = 'https://ob.nordigen.com/api/v2/accounts/';
                if (config('services.nordigen.account') == "premium")
                {
                    $baseURL .= 'premium/';
                }

                if (!is_null($df))
                {
                    $query["date_from"] = $df;
                    $query["date_to"] =  Carbon::now()->toDateString();
                }
                if (!is_null($dt))
                {
                    if (Carbon::parse($dt) > Carbon::now())
                    {
                        $dt = Carbon::now()->toDateString();
                    }
                    if (is_null($df))
                    {
                        $dt = null;
                    }
                    $query["date_to"] = $dt;
                }

                $requisition_response = Http::withHeaders([
                    'accept' => 'application/json',
                    'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                ])->get(
                    'https://ob.nordigen.com/api/v2/requisitions/' . $requisition->requisition_id . '/'
                );

                if ($requisition_response->successful())
                {
                    $requisition_data = $requisition_response->json();
                    $requisition_status = $requisition_data['status'];

                    $requisition->status = $requisition_status;
                    $requisition->status_long = Functions::getRequisitionStatusLong($requisition_status);
                    $requisition->status_description = Functions::getRequisitionStatusDescription($requisition_status);
                    $requisition->save();
                }

                if($agreement->details_scope == 1){

                    $account_status_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->get(
                        'https://ob.nordigen.com/api/v2/accounts/' . $account->account_id . '/'
                    );

                    if ($account_status_response->successful())
                    {
                        $account_status_data = $account_status_response->json();
                        $account_status = $account_status_data['status'];
                        $account->account_status = $account_status;
                        $account->save();
                    }
                }

                if($agreement->balances_scope == 1){
                    $balance_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->get(
                        $baseURL . $account->account_id . '/balances/',
                        $query
                    );
    
                    if ($balance_response->successful())
                    {
                        $balance_data = $balance_response->json();
                        Functions::update_account_balance($account, $balance_data);
                        $user->update_error_code("balance_error_code", 200);
                    }
                    else
                    {
                        $user->update_error_code("balance_error_code", $balance_response->status());
                    }
                }

                $transaction_response = Http::withHeaders([
                    'accept' => 'application/json',
                    'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                ])->get(
                    $baseURL . $account->account_id . '/transactions/',
                    $query
                );

                if ($transaction_response->successful())
                {
                    $transactions_data = $transaction_response->json();
                    $booked_transactions = $transactions_data["transactions"]["booked"];
                    $pending_transactions = $transactions_data["transactions"]["pending"];

                    foreach ($booked_transactions as $t)
                    {
                        Functions::add_or_update_transactions($t, $account, "booked");
                    }
                    foreach ($pending_transactions as $t)
                    {
                        Functions::add_or_update_transactions($t, $account, "pending");
                    }
                    $user->update_error_code("transaction_error_code", 200);
                }
                else
                {
                    $user->update_error_code("transaction_error_code", $transaction_response->status());
                }
            }
            catch (Exception $e)
            {
                Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            }
        }
        else{
            $message = 'Link for some of your Accounts has Expired. Reconnect them from My Accounts Page.';

            $notification = Notification::create([
                'type' => 'account_expired',
                'data' => "",
                'user_id' => $user->id,
                'message' => $message,
                'read' => 0
            ]);

            SendNotification::dispatch($user, $notification);
        }
    }

    private static function getRequisitionStatusLong($status)
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

    private static function getRequisitionStatusDescription($status)
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
