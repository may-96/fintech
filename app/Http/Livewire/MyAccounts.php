<?php

namespace App\Http\Livewire;

use App\Events\SendNotification;
use App\Mail\ShareWithUnregisteredUsers;
use App\Models\Account;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class MyAccounts extends Component
{
    public $accounts;
    public $selected_account_id = 0;
    public $sharing_details;
    public $error = "";
    public $success = "";
    public $email;
    public $share_notes = 0;
    protected $ids;
    public $share;

    public $shared_emails = [];

    public function mount($accounts)
    {
        $this->ids = $this->accounts->pluck('id');
        $this->accounts = $accounts->groupBy('institution_id')->toArray();
        $this->get_share_values();
    }

    public function render()
    {
        return view('livewire.my-accounts');
    }

    public function get_sharing_info($id, $reset = true)
    {
        if($reset){
            $this->reset_status();
        }
        $this->selected_account_id = $id;
        $account = Account::find($id);
        
        $temp_1 = DB::table('account_shares_with_unregistered_users')->selectRaw("id,email,created_at,'other' as type")->where('account_id', $this->selected_account_id)->get()->toArray();
        $structured_1 = [];
        foreach($temp_1 as $temp){
            $structured_1[] = [
                'id' => $temp->id,
                'email' => $temp->email,
                'created_at' => $temp->created_at,
                'type' => $temp->type,
            ];
        }

        $temp_2 = $account->shared_with()->selectRaw("users.id,users.email,'user' as type")->get()->toArray();
        $structured_2 = [];
        foreach($temp_2 as $temp){
            $structured_2[] = [
                'id' => $temp['id'],
                'email' => $temp['email'],
                'created_at' => $temp['pivot']['created_at'],
                'type' => $temp['type'],
            ];
        }

        $this->shared_emails = array_merge($structured_1, $structured_2);
        usort($this->shared_emails, function ($item1, $item2) {
            if(Carbon::parse($item2['created_at']) > Carbon::parse($item1['created_at'])){
                return 1;
            }
            else if(Carbon::parse($item2['created_at']) < Carbon::parse($item1['created_at'])){
                return -1;
            }
            else{
                return 0;
            }
        });
    }

    public function add_shared_user()
    {
        $this->reset_status();
        if ($this->check_email())
        {
            $user = User::where('email', $this->email)->first();
            if($this->check_already_shared($user)){
                $this->error = "Account has already been shared with this user";
            }
            else{
                $account = Account::find($this->selected_account_id);
                if($user != null){
                    try{
                        $user->shared_accounts()->attach($this->selected_account_id , ['notes_shared' => $this->share_notes ? 1 : 0]);

                        $authenticated_user = Auth::user();
                        $message = $authenticated_user->fname . ' ' . $authenticated_user->lname . ' has shared an Account of '. $account->institution->name;

                        $notification = Notification::create([
                            'type' => 'account_share',
                            'data' => $account->account_id,
                            'user_id' => $user->id,
                            'message' => $message,
                            'read' => 0
                        ]);

                        SendNotification::dispatch($user, $notification);
                        // event(new SendNotification($user, $notification));
                    }
                    catch(Exception $e){
                        Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
                    }
                    $this->success = "Account has been Successfully Shared with the User.";
                }
                else{
                    try{
                        DB::table('account_shares_with_unregistered_users')->insert([
                            'account_id' => $this->selected_account_id,
                            'email' => $this->email,
                            'notes_shared' => $this->share_notes ? 1 : 0,
                            "created_at" =>  Carbon::now()->toDateTimeString(),
                            "updated_at" => Carbon::now()->toDateTimeString()
                        ]);

                        Mail::to($this->email)->send( new ShareWithUnregisteredUsers(Auth::user(), $account) );
                    }
                    catch(Exception $e){

                    }
                    $this->success = "Sharing Request has been Successfully sent to the user email address.";
                }
                $this->get_sharing_info($this->selected_account_id, false);
                $this->get_account_share_count($this->selected_account_id);
                $this->email = "";
            }
        }
    }

    public function remove_shared_user($id, $type)
    {
        if($type == 'other'){
            DB::table('account_shares_with_unregistered_users')->where('id',$id)->delete();
        }
        if($type == 'user'){
            $user = User::find($id);
            if($user){
                $user->shared_accounts()->detach($this->selected_account_id);
            }
        }
        $this->get_sharing_info($this->selected_account_id, false);
        $this->get_account_share_count($this->selected_account_id);
    }

    private function check_email()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->error = "Please enter a Valid Email Address";
            return false;
        }
        return true;
    }

    private function check_already_shared($user = null)
    {
        
        // $acc_id = $this->selected_account_id;
        // Integer Result
        // $exists = User::where('id', $user->id)->whereHas('shared_accounts', function ($q) use ($acc_id) { $q->where('accounts.id', $acc_id); })->count();

        // Boolean Result
        $exists = false;
        if($user != null){
            $exists = $user->shared_accounts()->newPivotStatementForId($this->selected_account_id)->exists();
        }
        
        if(!$exists){
            $other_exists = DB::table('account_shares_with_unregistered_users')->where('account_id', $this->selected_account_id)->where('email',$this->email)->count();
            if($other_exists > 0){
                return true;
            }
            return false;
        }
        return true;
    }

    private function reset_status(){
        $this->error = "";
        $this->success = "";
    }

    private function get_share_values(){
        foreach($this->ids as $id){
            $this->get_account_share_count($id);
        }
    }

    private function get_account_share_count($id){
        $count_1 = DB::table('account_shares_with_unregistered_users')->where('account_id', $id)->count();
        $count_2 = DB::table('account_user')->where('account_id', $id)->count();
        $count = $count_1 + $count_2;
        $this->share[$id]["count"] = $count;
    }

}
