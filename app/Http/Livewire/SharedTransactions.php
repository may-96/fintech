<?php

namespace App\Http\Livewire;

use App\Events\SendNotification;
use App\Events\ViewTransactions;
use App\Models\Account;
use App\Models\Notification;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SharedTransactions extends Component
{
    public $user;

    public $grouped_transactions;
    public $transaction_status;
    public $load_amount = 50;
    public $transactions_loading = false;
    public $total_transactions;
    public $all_loaded = false;

    public $account_id;
    public $notes_shared;
    public $balance_shared;
    public $account;
    public $institution;
    public $aid;
    public $account_holder;
    public $authenticated_user_accounts;
    public $authenticated_user_accounts_ids;
    public $already_shared_accounts = [];
    public $not_shared_accounts = []; 
    public $account_shares = [];

    public $balances = [];

    public $error = '';
    public $success = '';

    public function mount($account_id, $aid, $notes_shared, $balance_shared)
    {
        $this->account_id = $account_id;
        $this->aid = $aid;
        $this->user = Auth::user();
        $this->transactions = collect();

        $this->authenticated_user_accounts = $this->user->accounts()->with('institution')->get()->flatten();
        $this->authenticated_user_accounts_ids = $this->authenticated_user_accounts->pluck('id')->toArray();
        $this->authenticated_user_accounts = $this->authenticated_user_accounts->toArray();

        $this->notes_shared = $notes_shared;
        $this->balance_shared = $balance_shared;
        
        $this->account = Account::where('id',$this->aid)->where('account_id',$this->account_id)->get()->first();
        
        $this->account_holder = $this->account->user;
        $all_account_shares = DB::table('account_user')->where('user_id', $this->account_holder->id)->get()->flatten();
        
        foreach($all_account_shares as $shared_account){
            if(in_array($shared_account->account_id,$this->authenticated_user_accounts_ids)){
                $this->already_shared_accounts[] = $shared_account->account_id;
                $this->account_shares[(int)$shared_account->account_id] = $shared_account->account_id;
            }
        }
        foreach($this->authenticated_user_accounts_ids as $auaid){
            if(!in_array($auaid, $this->already_shared_accounts)){
                $this->not_shared_accounts[] = $auaid;
            }
        }
        
        $this->institution = $this->account->institution;

        if($this->balance_shared == 1){
            $this->balances = $this->account->balances->toArray();
        }

        $this->total_transactions = $this->account->transactions()->count();
        
        $this->load_transactions();
        
    }

    public function render()
    {
        return view('livewire.shared-transactions');
    }

    private function load_transactions(){
        
            if($this->notes_shared == 1){
                $select_array = ['id','fixed_date','year','custom_uid', 'remit_info_unstructured', 'remittance_information_unstructured_array',  'remittance_information_structured', 'transaction_currency', 'transaction_amount','category_id','notes',];
            }
            else{
                $select_array = ['id','fixed_date','year','custom_uid', 'remit_info_unstructured', 'remittance_information_unstructured_array', 'remittance_information_structured', 'transaction_currency', 'transaction_amount','category_id'];
            }
            $transactions = $this->account->transactions()->with('category')->select($select_array)->skip(0)->take($this->load_amount)->orderBy('fixed_date','desc')->get();
            if($transactions->count() >= $this->total_transactions){
                $this->emit('allDataLoaded');
            }
            $this->grouped_transactions = $transactions->groupBy('year')->toArray();
            $this->transaction_status = "OK";
        
    }

    public function load_more(){
        $this->load_amount += 20;
        $this->load_transactions();
    }

    public function share_transactions()
    {
        $this->reset_msg();
        if($this->account_holder->id != $this->user->id){
            $shares_removed = [];
            $share = 0;
            foreach($this->account_shares as $ids){
                if($ids != false){
                    $id = (int) $ids;
                    if(!in_array($id, $this->already_shared_accounts)){
                        $share = 1;
                        DB::table('account_user')->insert([
                            'account_id' => $id,
                            'user_id' => $this->account_holder->id,
                            'notes_shared' => 1,
                            'balance_shared' => 1,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                        $temp_acc = Account::where('id',$id)->get()->first();
                        if($temp_acc){

                            $message = $this->user->fname . ' ' . $this->user->lname . ' has shared an Account ('. $temp_acc->iban .') of ' . $temp_acc->institution->name;

                            $notification = Notification::create([
                                'type' => 'account_share',
                                'data' => $temp_acc->account_id . '-' . $temp_acc->id,
                                'user_id' => $this->account_holder->id,
                                'message' => $message,
                                'read' => 0
                            ]);

                            SendNotification::dispatch($this->account_holder, $notification);

                        }
                        
                    }
                }
                
            }
            
            $this->already_shared_accounts = [];
            foreach($this->account_shares as $ids){
                if($ids != false){
                    $id = (int) $ids;
                    $this->already_shared_accounts[] = $id;
                }
            }

            foreach($this->authenticated_user_accounts_ids as $shared_id){
                if(!in_array($shared_id, $this->account_shares)){
                    $shares_removed[] = $shared_id;
                }
            }
            foreach($shares_removed as $rid){
                DB::table('account_user')->where('account_id', $rid)->where('user_id',$this->account_holder->id)->delete();
            }
            if($share == 1){
                $this->success = "Account Shared Successfully";
            }
            if($share == 0 && count($this->account_shares) > 0){
                $this->success = "Nothing new to share";
            }
            if($share == 0 && count($this->account_shares) == 0){
                $this->success = "Nothing to share";
            }
            
        }
        else{
            $this->error = "You cannot share account with yourself.";
        }
        
    }

    public function reset_msg(){
        $this->success = "";
        $this->error = "";
    }
}

