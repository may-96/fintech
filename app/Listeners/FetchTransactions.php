<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Interfaces\AccountTransactionsEventInterface;
use App\Helpers\Functions;
use App\Models\Notification;
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

        $requisition = $account->requisition;

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
                    Log::debug($requisition_data);
                    Log::debug($requisition_status);

                    $requisition->status = $requisition_status;
                    $requisition->status_long = $this->getRequisitionStatusLong($requisition_status);
                    $requisition->status_description = $this->getRequisitionStatusDescription($requisition_status);
                    $requisition->save();
                }


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
