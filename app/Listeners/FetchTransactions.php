<?php

namespace App\Listeners;

use App\Interfaces\AccountTransactionsEventInterface;
use App\Helpers\Functions;
use App\Models\Token;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class FetchTransactions implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'fetch-transactions';

    public function handle(AccountTransactionsEventInterface $event)
    {
        /** @var \App\Models\User */
        $user = $event->user;

        $account = $event->account;
        $df = $event->date_from;
        $dt = $event->date_to;

        try
        {
            $token = Token::where('status', 1)->get()->first();

            $baseURL = 'https://ob.nordigen.com/api/v2/accounts/';
            if (config('services.nordigen.account') == "premium")
            {
                $baseURL .= 'premium/';
            }

            $query = [];
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
            else{
                $user->update_error_code("transaction_error_code", $transaction_response->status());
            }
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
