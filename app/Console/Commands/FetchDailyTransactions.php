<?php

namespace App\Console\Commands;

use App\Events\AccountConnected;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchDailyTransactions extends Command
{
    protected $signature = 'command:fetch.daily.transactions';

    protected $description = 'Fetch all the Users Transactions on Daily Basis';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try{
            $date_from = Carbon::now()->subDay()->toDateString();
            $date_to = Carbon::now()->toDateString();
            $users = User::has('accounts')->get();
            foreach($users as $user){
                $accounts = $user->accounts;
                foreach($accounts as $account){
                    event(new AccountConnected($user, $account, $date_from, $date_to));
                }
            }
            return 1;
        }
        catch(Exception $e){
            Log::error("From FetchDailyTransactions");
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            return 0;
        }
    }
}
