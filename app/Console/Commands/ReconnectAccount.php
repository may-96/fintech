<?php

namespace App\Console\Commands;

use App\Events\SendNotification;
use App\Models\Account;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReconnectAccount extends Command
{

    protected $signature = 'command:reconnect.expiring.accounts';

    protected $description = 'Command for Requesting User to Reconnect their Expiring Account';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
        $accounts = Account::all();
        $requisitions_processed = [];
        $required_requisitions = [];
        
        foreach($accounts as $account){
            $req_id = $account->requisition_id;
            if(!in_array($req_id, $requisitions_processed)){
                $requisitions_processed[] = $req_id;
            }
            else{
                continue;
            }
            $requisition = $account->requisition;
            $user = $account->user;
            if($requisition->status_long == 'EXPIRED' || $requisition->status_long == 'SUSPENDED' ){
                
                if(array_key_exists($user->id, $required_requisitions)){
                    $required_requisitions[$user->id][] = $requisition->id;
                }
                else{
                    $required_requisitions[$user->id] = [$requisition->id];
                }

                continue;
            }

            $agreement = $requisition->agreement;
            $ag_date = Carbon::parse($agreement->agreement_date);
            $now = Carbon::now();
            $valid_for = (int) $agreement->access_valid_for_days;
            if($now->diffInDays($ag_date) > ($valid_for - 4)){
                if(array_key_exists($user->id, $required_requisitions)){
                    $required_requisitions[$user->id][] = $requisition->id;
                }
                else{
                    $required_requisitions[$user->id] = [$requisition->id];
                }
            }
        }

        foreach($required_requisitions as $user_id => $requisitions){
            $user = User::find($user_id);
            foreach($requisitions as $req){
                $message = "Access to some of your accounts are expiring soon! Click here to Reconnect your account.";
                
                $notification = Notification::create([
                    'type' => 'reconnect',
                    'data' => $req,
                    'user_id' => $user_id,
                    'message' => $message,
                    'read' => 0
                ]);
                
                SendNotification::dispatch($user, $notification);
            }
        }
    }
}
