<?php

namespace App\Http\Livewire;

use App\Events\ViewTransactions;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SharedTransactions extends Component
{
    public $user;

    public $grouped_transactions;
    public $transaction_status;
    public $load_amount = 20;
    public $transactions_loading = false;
    public $total_transactions;
    public $all_loaded = false;

    public $account_id;
    public $notes_shared;
    public $account;
    public $aid;


    public function mount($account_id, $aid, $notes_shared)
    {
        $this->account_id = $account_id;
        $this->aid = $aid;
        $this->user = Auth::user();
        $this->transactions = collect();

        $this->notes_shared = $notes_shared;
        
        $this->account = Account::where('id',$this->aid)->where('account_id',$this->account_id)->get()->first();

        $this->total_transactions = $this->account->transactions()->count();
        
        $this->load_transactions();
        
    }

    public function render()
    {
        return view('livewire.shared-transactions');
    }

    private function load_transactions(){
        
            if($this->notes_shared == 1){
                $select_array = ['id','fixed_date','year','custom_uid', 'remit_info_unstructured', 'transaction_currency', 'transaction_amount','category_id','notes',];
            }
            else{
                $select_array = ['id','fixed_date','year','custom_uid', 'remit_info_unstructured', 'transaction_currency', 'transaction_amount','category_id'];
            }
            $transactions = $this->account->transactions()->with('category')->select($select_array)->skip(0)->take($this->load_amount)->orderBy('fixed_date','desc')->get();
            if($transactions->count() >= $this->total_transactions){
                $this->emit('allDataLoaded');
            }
            $this->grouped_transactions = $transactions->groupBy('year')->toArray();
            $this->transaction_status = "OK";
        
    }

    public function load_more(){
        $this->load_amount += 10;
        $this->load_transactions();
    }
}

