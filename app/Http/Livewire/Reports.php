<?php

namespace App\Http\Livewire;

use App\Events\SendNotification;
use App\Helpers\Functions;
use App\Mail\SharedReportWithUnregisteredUsers;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Reports extends Component
{
    public $data;

    public $credit_score = 1;
    public $initials_only = 0;
    public $account_initials_only = 1;
    public $cash_flow = 1;
    public $expenses = 1;
    public $income = 1;
    public $email_check = 1;
    public $contact = 1;
    public $email = "";
    public $error = "";
    public $success = "";

    public $email_addr = "";
    public $contact_num = "";
    public $report_user_name = "";
    public $report_user_name_initials = "";
    public $company_name = "";
    public $account_names = [];

    public $shared_emails = [];

    public $current_user;

    public $fetch_id;
    public $report_data;
    public $access;

    public $income_data_available = false;
    public $expense_data_available = false;
    public $cash_flow_data_available = false;

    public $shareable_link = null;

    public $first_render = true;
    public $amount_check = 0;

    public function mount($data)
    {
        $this->data = $data;
        
        $this->current_user = Auth::user();

        if($this->data[0] == 'self'){
            $this->fetch_id = $this->current_user->id;
        }
        if($this->data[0] == "shared"){
            $sharing_info = $this->data[1];
            $this->fetch_id = $sharing_info->user_id;
            $this->amount_check = $sharing_info->amount;
        }
        if($this->data[0] == "self_shared"){
            $sharing_info = $this->data[1];
            $this->fetch_id = $sharing_info->user_id;
            $this->amount_check = $sharing_info->amount;
        }

    }

    public function render()
    {
        if($this->first_render == false){
            $this->emit('hidePrintableReport');
        }
        $this->first_render = false;
        return view('livewire.reports');
    }

    public function load_report(){
        $temp = User::find($this->fetch_id);
        if($this->data[0] == "shared"){
            $this->access = $this->data[1];
        }
        
        $this->report_user_name = $temp->fname . " " . $temp->lname;
        $this->report_user_name_initials = Functions::getInitials($this->report_user_name);
        $this->company_name = $temp->company;
        if(($this->data[0] == 'self' || (($this->data[0] == 'shared' || $this->data[0] == 'self_shared') && $this->access['view_email'] == 1))){
            $this->email_addr = $temp->email;
        }
        if(($this->data[0] == 'self' || (($this->data[0] == 'shared' || $this->data[0] == 'self_shared') && $this->access['view_contact'] == 1))){
            $this->contact_num = $temp->contact;
        }
        
        $this->report_data = Functions::cash_flow_stats($temp);
        if($this->report_data != 0){
            $graphData = [];

            // logger($this->report_data[14]);
            logger($this->report_data[15]);

            if(((($this->data[0] == 'shared' || $this->data[0] == 'self_shared') && $this->access['view_account_initials_only'] == 1))){
                foreach ($this->report_data[13] as $account_name){
                    $this->account_names[] = Functions::getInitials($account_name).'********';
                }
            }
            else if(($this->data[0] == 'shared' || $this->data[0] == 'self_shared') && $this->access['view_account_initials_only'] == 0){
                foreach ($this->report_data[13] as $account_name){
                    $this->account_names[] = $account_name;
                }
            }
            else{
                foreach ($this->report_data[13] as $account_name){
                    $this->account_names[] = $account_name;
                }
            }

            if(count($this->report_data[0]) > 0){
                $this->cash_flow_data_available = true;
                $graphData['cash_flow'] = $this->report_data[0];
            }
            if(count($this->report_data[1]) > 0){
                $this->income_data_available = true;
                $graphData['income'] = $this->report_data[1];
            }
            if(count($this->report_data[2]) > 0){
                $this->expense_data_available = true;
                $graphData['expense'] = $this->report_data[2];
            }

            $this->emit('reportLoaded', $graphData);
        }
        else{
            return redirect()->route('dashboard')->with('danger', 'Please Connect Your Bank Account');
        }
        
    }

    public function generate_shareable_link(){
        $token = Str::orderedUuid();
        $this->current_user->report_shareable_link = (string)$token;
        $this->current_user->save();
        $this->shareable_link = (string)$token;
    }

    public function remove_shareable_link(){
        $this->current_user->report_shareable_link = null;
        $this->current_user->save();
        $this->shareable_link = null;
    }

    private function reset_status(){
        $this->error = "";
        $this->success = "";
    }

    public function get_sharing_info($reset = true)
    {
        if($reset){
            $this->reset_status();
        }

        // $this->shareable_link = $this->current_user->report_shareable_link;
        
        $temp_1 = DB::table('report_shares_with_unregistered_users')->selectRaw("id,email,created_at,'other' as type")->where('user_id', $this->current_user->id)->get()->toArray();
        $structured_1 = [];
        foreach($temp_1 as $temp){
            $structured_1[] = [
                'id' => $temp->id,
                'email' => $temp->email,
                'created_at' => $temp->created_at,
                'type' => $temp->type,
            ];
        }

        $temp_2 = $this->current_user->shared_reports()->selectRaw("users.id,users.email,'user' as type")->get()->toArray();
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

    public function add_report_user()
    {
        $this->reset_status();
        if ($this->check_email())
        {
            if($this->email == $this->current_user->email){
                $this->error = "You cannot share report with yourself.";
            }
            $user = User::where('email', $this->email)->first();
            if($this->check_already_shared($user)){
                $this->error = "Credit Report has already been shared with this user";
            }
            else{
                $token = (string) Str::orderedUuid();
                if($user != null){
                    try{
                        
                        $user->shared_reports_with()->attach($this->current_user->id , [
                            'view_cash_flow' => $this->cash_flow ? 1 : 0,
                            'view_expense' => $this->expenses ? 1 : 0,
                            'view_income' => $this->income ? 1 : 0,
                            'view_email' => $this->email_check ? 1 : 0,
                            'view_contact' => $this->contact ? 1 : 0,
                            'view_credit_score' => $this->credit_score ? 1 : 0,
                            'view_initials_only' => $this->initials_only ? 1 : 0,
                            'view_account_initials_only' => $this->account_initials_only ? 1 : 0,
                            'token' => $token,
                        ]);
                        
                        $message = $this->current_user->fname . ' ' . $this->current_user->lname . ' has shared the Credit Report with you.';

                        $notification = Notification::create([
                            'type' => 'report_share',
                            'data' => $token,
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
                    $this->success = "Credit Report has been Successfully Shared with the User.";
                }
                else{
                    try{
                        DB::table('report_shares_with_unregistered_users')->insert([
                            'user_id' => $this->current_user->id,
                            'email' => $this->email,
                            'view_cash_flow' => $this->cash_flow ? 1 : 0,
                            'view_expense' => $this->expenses ? 1 : 0,
                            'view_income' => $this->income ? 1 : 0,
                            'view_email' => $this->email_check ? 1 : 0,
                            'view_contact' => $this->contact ? 1 : 0,
                            'view_credit_score' => $this->credit_score ? 1 : 0,
                            'view_initials_only' => $this->initials_only ? 1 : 0,
                            'view_account_initials_only' => $this->account_initials_only ? 1 : 0,
                            'token' => $token,
                            "created_at" =>  Carbon::now()->toDateTimeString(),
                            "updated_at" => Carbon::now()->toDateTimeString()
                        ]);

                        Mail::to($this->email)->send( new SharedReportWithUnregisteredUsers($this->current_user, $token) );
                    }
                    catch(Exception $e){

                    }
                    $this->success = "Email with the Link to access the Credit Report has been Successfully sent to the user's email address.";
                }
                $this->get_sharing_info(false);
                // $this->get_account_share_count($this->selected_account_id);
                $this->email = "";
            }
        }
    }

    public function remove_report_user($id, $type)
    {
        if($type == 'other'){
            DB::table('report_shares_with_unregistered_users')->where('id',$id)->delete();
        }
        if($type == 'user'){
            $user = User::find($id);
            if($user){
                $user->shared_reports_with()->detach($this->current_user->id);
            }
        }
        $this->get_sharing_info(false);
        // $this->get_account_share_count($this->selected_account_id);
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
            $exists = $user->shared_reports_with()->newPivotStatementForId($this->current_user->id)->exists();
        }
        
        if(!$exists){
            $other_exists = DB::table('report_shares_with_unregistered_users')->where('user_id', $this->current_user->id)->where('email',$this->email)->count();
            if($other_exists > 0){
                return true;
            }
            return false;
        }
        return true;
    }
}
