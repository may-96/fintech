<?php

namespace App\Helpers;

use App\Models\Balance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Category;

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
        
        foreach ($accounts as $account)
        {
            $i = 0;
            $total_months = 0;
            $tci = 0;
            $tco = 0;
            $currency = strtoupper($account->currency);
            while ($i < $months_in_year)
            {

                $transactions = $account->transactions()->whereYear('fixed_date',$active_year)->whereMonth('fixed_date',$active_month);
                $cash_in_transactions = $transactions->where('transaction_amount', '>', 0);
                $cash_in_count = $cash_in_transactions->count();
                $cis = $cash_in_transactions->sum('transaction_amount');
                $cash_in_sum = Currency::convert()->from($currency)->to(config('app.settings.report_currency'))->amount(abs($cis))->get();

                $cash_out_transactions = $transactions->where('transaction_amount', '<', 0);
                $cash_out_count = $cash_out_transactions->count();
                $cos = $cash_out_transactions->sum('transaction_amount');
                $cash_out_sum = Currency::convert()->from($currency)->to(config('app.settings.report_currency'))->amount(abs($cos))->get();
                
                $month_name = self::$month_array[(string) $active_month] . ', ' . $active_year;

                --$active_month;
                if ($active_month === 0)
                {
                    $active_year = 12;
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

            if($total_months > 0){
                $average_cash_in += $tci / $total_months;
                $average_cash_out += $tco / $total_months;
            }

            $income_data = Functions::get_income_expense_data($account, $income_data, $years, 'income');
            $expense_data = Functions::get_income_expense_data($account, $expense_data, $years, 'expense');
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
        if($credit_score >= 0 && $credit_score < 20){
            $credit_rating = "Horrible";
        }
        else if($credit_score >= 20 && $credit_score < 40){
            $credit_rating = "Poor";
        }
        else if($credit_score >= 40 && $credit_score < 60){
            $credit_rating = "Average";
        }
        else if($credit_score >= 60 && $credit_score < 80){
            $credit_rating = "Good";
        }
        else{
            $credit_rating = "Outstanding";
        }      

        return [$cash_flow_data, $income_data, $expense_data, $total_cash_in, $total_cash_out, $average_cash_in, $average_cash_out, $accounts->count(), $credit_score, $credit_rating];
    }

    private static function get_income_expense_data($account, $data, $years, $type){
        $currency = strtoupper($account->currency);
        $categories = Category::where('type', $type)->get();
        foreach($categories as $category){
            $name = $category->name;
            $transactions = $account->transactions()->where('fixed_date','<',Carbon::now())->where('fixed_date','>',Carbon::now()->subYears($years))->where('category_id', $category->id);
            $category_transaction_count = $transactions->count();
            $ctt = $transactions->sum('transaction_amount');
            $category_transaction_total = Currency::convert()->from($currency)->to(config('app.settings.report_currency'))->amount(abs($ctt))->get();
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
                    $cash_flow_data[$name] = [$category_transaction_count, abs($category_transaction_total), abs($category_transaction_average)];
                }
            }
        }
        return $data;
    }
}
