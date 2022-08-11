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
use Illuminate\Support\Facades\Auth;
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

    public static function filtered_request_data($data)
    {
        foreach ($data as $i => $d)
        {
            if ($d === "null" || $d === "")
            {
                $data[$i] = null;
            }
        }
        return $data;
    }

    public static function getInitials($name){
        if(empty(trim($name))){
            return "-";
        }
        $name_array = explode(' ',trim($name));
    
        $firstWord = $name_array[0];
        if(count($name_array) > 1){
            $lastWord = $name_array[count($name_array)-1];
        }
        else{
            if(strlen($firstWord) > 1){
                $lastWord = $firstWord[1];
            }
            $lastWord = $firstWord[0];
        }
        
        return strtoupper($firstWord[0])."".strtoupper($lastWord[0]);
    }

    public static function add_or_update_transactions($t, $account, $status)
    {
        try{

            $custom_uid = Functions::get_transaction_custom_uid($t);
            
            $transaction_type = "credit";
            if((float) $t["transactionAmount"]["amount"] < 0){
                $transaction_type = "debit";
            }

            $category = isset($t["categorisation"]) ? $t["categorisation"]["categoryTitle"] : null;
            if(Functions::not_empty($category)){
                if($transaction_type == "debit"){
                    $cat_count = Category::where('name',$category)->where('type','expense')->get()->count();
                    if($cat_count == 0){
                        Category::create([
                            'id'=> ((int) $t["categorisation"]["categoryId"]),
                            'name' => $category,
                            'type' => 'expense',
                        ]);
                    }
                }
                else{
                    $cat_count = Category::where('name',$category)->where('type','income')->get()->count();
                    if($cat_count == 0){
                        Category::create([
                            'id'=> (((int) $t["categorisation"]["categoryId"]) + 100),
                            'name' => $category,
                            'type' => 'income',
                        ]);
                    }
                }
            }

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
                    "category_id" => isset($t["categorisation"]) ? ( $transaction_type == 'debit' ? $t["categorisation"]["categoryId"] : (int)$t["categorisation"]["categoryId"] + 100) : null,

                    "merchant_name" => isset($t["cleaning"]) ? $t["cleaning"]["merchantName"] : null,
                    "transaction_type" => isset($t["cleaning"]) ? $t["cleaning"]["transactionCode"] : null,
                    "merchant_category_code" => (isset($t["cleaning"]) && isset($t["cleaning"]["merchantCategoryCode"])) ? $t["cleaning"]["merchantCategoryCode"] : null,
                    "invoice_number" => (isset($t["cleaning"]) && isset($t["cleaning"]["invoiceNumber"])) ? $t["cleaning"]["invoiceNumber"] : null,

                    "enriched_contact_address" => (isset($t["enrichment"]) && isset($t["enrichment"]['contacts'])) ? $t["enrichment"]["contacts"]["addressUnstructured"] : null,
                    "enriched_contact_phone" => (isset($t["enrichment"]) && isset($t["enrichment"]['contacts'])) ? $t["enrichment"]["contacts"]["phone"] : null,
                    "enriched_contact_title" => (isset($t["enrichment"]) && isset($t["enrichment"]['contacts'])) ? $t["enrichment"]["contacts"]["title"] : null,
                    
                    "enriched_subtitle" => (isset($t["enrichment"]) && isset($t["enrichment"]['description'])) ? $t["enrichment"]["description"]["subtitle"] : null,
                    "enriched_summary" => (isset($t["enrichment"]) && isset($t["enrichment"]['description'])) ? $t["enrichment"]["description"]["summary"] : null,

                    "enriched_logo" => (isset($t["enrichment"]) && isset($t["enrichment"]['logo'])) ? $t["enrichment"]["logo"] : null,
                    "enriched_name" => (isset($t["enrichment"]) && isset($t["enrichment"]['name'])) ? $t["enrichment"]["name"] : null,
                    "enriched_website" => (isset($t["enrichment"]) && isset($t["enrichment"]['website'])) ? $t["enrichment"]["website"] : null,

                    "pattern_regular_transaction_value" => (isset($t["patterns"]) && isset($t["patterns"]['regularTransaction'])) ? $t["patterns"]["regularTransaction"]["value"] : null,
                    "pattern_regular_transaction_id" => (isset($t["patterns"]) && isset($t["patterns"]['regularTransaction'])) ? $t["patterns"]["regularTransaction"]["id"] : null,

                    "pattern_opposite_match_value" => (isset($t["patterns"]) && isset($t["patterns"]['oppositeMatch'])) ? $t["patterns"]["oppositeMatch"]["value"] : null,
                    "pattern_opposite_match_id" => (isset($t["patterns"]) && isset($t["patterns"]['oppositeMatch'])) ? $t["patterns"]["oppositeMatch"]["id"] : null,

                    "pattern_anomaly" => (isset($t["patterns"]) && isset($t["patterns"]['anomaly'])) ? $t["patterns"]["anomaly"] : null,
                    "pattern_outlier" => (isset($t["patterns"]) && isset($t["patterns"]['outlier'])) ? $t["patterns"]["outlier"] : null,

                    "purpose_code" => isset($t["purposeCode"]) ? $t["purposeCode"] : null,
                    "bank_transaction_code" => isset($t["bankTransactionCode"]) ? $t["bankTransactionCode"] : null,
                    "status" => $status,
                    'end_to_end_id' => isset($t["endToEndId"]) ? $t["endToEndId"] : null,
                    
                    "additional_information_structured" => isset($t["additionalInformationStructured"]) ? json_encode($t["additionalInformationStructured"]) : null,
                    "balance_after_transaction" => isset($t["balanceAfterTransaction"]) ? json_encode($t["balanceAfterTransaction"]) : null,
                    "check_id" => isset($t["checkId"]) ? $t["checkId"] : null,
                    "creditor_agent" => isset($t["creditorAgent"]) ? $t["creditorAgent"] : null,
                    "creditor_id" => isset($t["creditorId"]) ? $t["creditorId"] : null,
                    "currency_exchange" => isset($t["currencyExchange"]) ? json_encode($t["currencyExchange"]) : null,
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
        catch(Exception $e){
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine() . ' - ' . $e->getTraceAsString());
        }
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
    public static function cash_flow_stats($user, $report_curr = 'EUR', $years = 2)
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

        $consistent_in = [];
        $consistent_out = [];

        $account_names = [];

        $salary_total = 0;

        if(count($accounts) == 0){
            return 0;
        }

        $temp_curr = "";
        foreach($accounts as $account){
            if($temp_curr == ""){
                $temp_curr = strtoupper($account->currency);
            }
            if($temp_curr !== strtoupper($account->currency)){
                $to_currency = $user->currency;
                break;
            }
            $to_currency = $temp_curr;
        }

        if(Functions::is_empty($report_curr)){
            $report_curr = "EUR";
        }
        
        $report_curr_exchange = 1;
        if($to_currency != $report_curr){
            $report_curr_exchange = Currency::convert()->from($to_currency)->to($report_curr)->amount(1)->get();
        }
        
        // $to_currency = config('app.settings.report_currency');
        if(Functions::is_empty($to_currency)){
            $to_currency = 'EUR';
        }

        $account_credit_score = 0;
        
        foreach ($accounts as $account)
        {
            $i = 0;
            $total_months = 0;
            $tci = 0;
            $tco = 0;

            if ($account->first_load == null)
            {
                Functions::fetchTransactions($user, $account, null, null);
                $account->first_load = Carbon::now()->toDateTimeString();
                $account->last_load_time = Carbon::now()->toDateTimeString();
                $account->save();
            }
            
            $llt = Carbon::parse($account->last_load_time);
            $now = Carbon::now();
            
            if($now->diffInHours($llt) > 22){
                Functions::fetchTransactions($user, $account, null, null);
                $account->last_load_time = Carbon::now()->toDateTimeString();
                $account->save();
            }

            $account_credit_score += $account->credit_score;
            
            $currency = strtoupper($account->currency);
            
            if(Functions::is_empty($currency)){
                $currency = 'EUR';
            }
            
            $account_names[] = Functions::not_empty($account->owner_name) ? $account->owner_name : $account->account_name;

            $exchange = 1;
            if($to_currency != $currency){
                $exchange = Currency::convert()->from($currency)->to($to_currency)->amount(1)->get();
            }
            
            while ($i < $months_in_year)
            {

                $cash_in_transactions = $account->transactions()->whereYear('fixed_date',$active_year)->whereMonth('fixed_date',$active_month)->where('transaction_amount', '>', 0);
                
                $cash_in_count = $cash_in_transactions->count();
                $cis = $cash_in_transactions->sum('transaction_amount');
                $cash_in_sum = $exchange * abs($cis);

                $cash_out_transactions = $account->transactions()->whereYear('fixed_date',$active_year)->whereMonth('fixed_date',$active_month)->where('transaction_amount', '<', 0);
                
                $cash_out_count = $cash_out_transactions->count();
                $cos = $cash_out_transactions->sum('transaction_amount');
                $cash_out_sum = $exchange * abs($cos);

                foreach($cash_in_transactions->get() as $cin_transaction){
                    $debitor = "";
                    if(Functions::not_empty($cin_transaction->debator_name)){
                        $debitor = trim($cin_transaction->debator_name);
                    }
                    else if(Functions::not_empty($cin_transaction->debtor_account)){
                        $debitor = trim($cin_transaction->debtor_account);
                    }
                    else if(Functions::not_empty($cin_transaction->remit_info_unstructured)){
                        $temp_arr = explode('<br>',$cin_transaction->remit_info_unstructured);
                        $first_sentence = $temp_arr[0];
                        $first_sentence_arr = explode(' ',$first_sentence);
                        $first_letter = $first_sentence_arr[0];
                        $second_letter = "";
                        if(count($first_sentence_arr) > 1){
                            $second_letter = $first_sentence_arr[1];
                        }
                        $debitor = trim($first_letter . " " . $second_letter);
                    }

                    if(array_key_exists($debitor, $consistent_in)){
                        $last_month = $active_month + 1;
                        if($last_month == 13){
                            $last_month = 1;
                        }
                        if($consistent_in[$debitor][0] == $active_month || $consistent_in[$debitor][0] == $last_month){
                            if($consistent_in[$debitor][0] != $active_month){
                                $consistent_in[$debitor][4][count($consistent_in[$debitor][4])-1][0] += 1;
                            }
                            $consistent_in[$debitor][0] = $active_month;
                            $consistent_in[$debitor][1] += 1;
                            $consistent_in[$debitor][3] += $exchange * (float)$cin_transaction->transaction_amount;
                            $consistent_in[$debitor][4][count($consistent_in[$debitor][4])-1][1] += $exchange * (float)$cin_transaction->transaction_amount;
                            $consistent_in[$debitor][4][count($consistent_in[$debitor][4])-1][] = $cin_transaction;
                            
                        }
                        else{
                            $consistent_in[$debitor][0] = $active_month;
                            $consistent_in[$debitor][1] += 1;
                            $consistent_in[$debitor][2] += 1;
                            $consistent_in[$debitor][3] += $exchange * (float)$cin_transaction->transaction_amount;
                            $consistent_in[$debitor][4][] = [1,$exchange * (float)$cin_transaction->transaction_amount,$cin_transaction];
                        }
                    }
                    else{
                        $consistent_in[$debitor] = [$active_month, 1,1,$exchange * (float)$cin_transaction->transaction_amount,[[1, $exchange * (float)$cin_transaction->transaction_amount, $cin_transaction]]];
                    }
                }

                foreach($cash_out_transactions->get() as $cout_transaction){
                    $creditor = "";
                    if(Functions::not_empty($cout_transaction->creditor_name)){
                        $creditor = trim($cout_transaction->creditor_name);
                    }
                    else if(Functions::not_empty($cout_transaction->creditor_account)){
                        $creditor = trim($cout_transaction->creditor_account);
                    }
                    else if(Functions::not_empty($cout_transaction->remit_info_unstructured)){
                        $temp_arr = explode('<br>',$cout_transaction->remit_info_unstructured);
                        $first_sentence = $temp_arr[0];
                        $first_sentence_arr = explode(' ',$first_sentence);
                        $first_letter = $first_sentence_arr[0];
                        $second_letter = "";
                        if(count($first_sentence_arr) > 1){
                            $second_letter = $first_sentence_arr[1];
                        }
                        $creditor = trim($first_letter . " " . $second_letter);
                    }

                    if(array_key_exists($creditor, $consistent_out)){
                        $last_month = $active_month + 1;
                        if($last_month == 13){
                            $last_month = 1;
                        }
                        if($consistent_out[$creditor][0] == $active_month || $consistent_out[$creditor][0] == $last_month){
                            if($consistent_out[$creditor][0] != $active_month){
                                $consistent_out[$creditor][4][count($consistent_out[$creditor][4])-1][0] += 1;
                            }
                            $consistent_out[$creditor][0] = $active_month;
                            $consistent_out[$creditor][1] += 1;
                            $consistent_out[$creditor][3] += $exchange * abs((float)$cout_transaction->transaction_amount);
                            $consistent_out[$creditor][4][count($consistent_out[$creditor][4])-1][1] += $exchange * abs((float)$cout_transaction->transaction_amount);
                            $consistent_out[$creditor][4][count($consistent_out[$creditor][4])-1][] = $cout_transaction;
                        }
                        else{
                            $consistent_out[$creditor][0] = $active_month;
                            $consistent_out[$creditor][1] += 1;
                            $consistent_out[$creditor][2] += 1;
                            $consistent_out[$creditor][3] += $exchange * abs((float)$cout_transaction->transaction_amount);
                            $consistent_out[$creditor][4][] = [1,$exchange * abs((float)$cout_transaction->transaction_amount),$cout_transaction];
                        }
                    }
                    else{
                        $consistent_out[$creditor] = [$active_month, 1,1,$exchange * abs((float)$cout_transaction->transaction_amount),[[1,$exchange * abs((float)$cout_transaction->transaction_amount),$cout_transaction]]];
                    }
                }
                
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
            $account_credit_score = ($account_credit_score / $accounts->count()) * 100;
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
        $credit_rating = Functions::score_text($credit_score);
        $credit_color = Functions::score_styles($credit_score);

        $account_credit_rating = Functions::score_text($account_credit_score);
        $account_credit_color = Functions::score_styles($account_credit_score);
             
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
            $salary_monthly,
            $account_names,
            $consistent_in,
            $consistent_out,
            $to_currency,
            $report_curr_exchange,
            $account_credit_score,
            $account_credit_rating,
            $account_credit_color,
        ];
    }

    private static function score_styles($value){
        $credit_color = "secondary";
        if($value >= 0 && $value < 20){
            $credit_color = "red";
        }
        else if($value >= 20 && $value < 40){
            $credit_color = "orange";
        }
        else if($value >= 40 && $value < 60){
            $credit_color = "secondary";
        }
        else if($value >= 60 && $value < 80){
            $credit_color = "primary";
        }
        else{
            $credit_color = "green";
        }
        return $credit_color;
    }

    private static function score_text($value){
        $credit_rating = "Average";
        if($value >= 0 && $value < 20){
            $credit_rating = "Horrible";
        }
        else if($value >= 20 && $value < 40){
            $credit_rating = "Poor";
        }
        else if($value >= 40 && $value < 60){
            $credit_rating = "Average";
        }
        else if($value >= 60 && $value < 80){
            $credit_rating = "Good";
        }
        else{
            $credit_rating = "Outstanding";
        }
        return $credit_rating;
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
        $agreement = $requisition->agreement;

        $reconnect_cond = false;
        $ag_date = Carbon::parse($agreement->agreement_date);
        $now = Carbon::now();
        $valid_for = (int) $agreement->access_valid_for_days;
        if($now->diffInDays($ag_date) > $valid_for){
            $reconnect_cond = true;
        }

        if ($account->account_status != 'EXPIRED' && ($requisition->status_long != 'EXPIRED' || $requisition->status_long != 'SUSPENDED') && $reconnect_cond !== true)
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

                    $account_data_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->get(
                        $baseURL . $account->account_id . '/details/'
                    );

                    if ($account_data_response->successful())
                    {
                        $account_data = $account_data_response->json();
                        
                        $credit_score = isset($account_data["account"]["scoring"]) ? $account_data["account"]['scoring']['value'] : null;
                        $fullName = isset($account_data["account"]["verification"]) ? $account_data["account"]['verification']['fullName'] : null;
                        $firstName = (isset($account_data["account"]["verification"]) && isset($account_data["account"]["verification"]['firstName'])) ? $account_data["account"]['verification']['firstName'] : null;
                        $lastName = (isset($account_data["account"]["verification"]) && isset($account_data["account"]["verification"]['lastName'])) ? $account_data["account"]['verification']['lastName'] : null;
                        
                        $status = isset($account_data['account']['status']) ? $account_data['account']['status'] : null;                        
                        
                        $account->status = $status;
                        $account->credit_score = $credit_score;
                        $account->full_name = $fullName;
                        $account->first_name = $firstName;
                        $account->last_name = $lastName;
                        
                        $account->save();
                    }

                    $account_status_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->get(
                        $baseURL . $account->account_id . '/'
                    );
                
                    if($account_status_response->successful()){
                        $account_status_data = $account_status_response->json();
                        $account_status = isset($account_status_data['status']) ? $account_status_data['status'] : null;
                        if($account_status !== null){
                            $account->account_status = $account_status;
                            $account->save();
                        }
                        
                    }
                }

                if($agreement->balances_scope == 1){
                    $balance_response = Http::withHeaders([
                        'accept' => 'application/json',
                        'Authorization' => 'Bearer ' . Crypt::decryptString($token->access),
                    ])->get(
                        $baseURL . $account->account_id . '/balances/'
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
                    $account->last_load_time = Carbon::now()->toDateTimeString();
                    $account->save();
                    
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
                Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine() . ' - ' . $e->getTraceAsString());
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
