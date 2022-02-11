<?php

namespace App\Http\Livewire;

use App\Events\ViewTransactions;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transactions extends Component
{
    public $user;

    public $transactions;
    public $grouped_transactions;
    public $transaction_status;
    public $load_amount = 30;
    public $total_transactions;

    public $account_id;
    public $account;

    public $categories;
    
    public $balances;
    public $balance_status;

    public function mount($account_id)
    {
        $this->account_id = $account_id;
        $this->user = Auth::user();
        $this->transactions = collect();

        $this->categories = Category::all()->toArray();
        
        $this->account = Account::where('user_id', $this->user->id)->where('account_id',$this->account_id)->get()->first();

        $this->total_transactions = $this->account->transactions()->count();
        
        $this->load_balance();
        $this->load_transactions();
        
    }

    private function load_balance(){
        if($this->user->balance_error_code == null ){
            $this->balance_status = "Processing";
        }
        else if($this->user->balance_error_code == 200){
            $this->balances = $this->account->balances;
            $this->balance_status = "OK";
        }
        else{
            $this->balance_status = "Error";
        }
    }

    private function load_transactions(){
        if($this->user->transaction_error_code == null ){
            $this->transaction_status = "Processing";
        }
        else if($this->user->transaction_error_code == 200){
            $select_array = ['id','fixed_date','year','custom_uid', 'remit_info_unstructured', 'transaction_currency', 'transaction_amount', 'notes','category_id'];
            $this->transactions = $this->account->transactions()->with('category')->select($select_array)->skip(0)->take($this->load_amount)->orderBy('fixed_date','desc')->get();
            if($this->transactions->count() >= $this->total_transactions){
                $this->emit('allDataLoaded');
            }
            $this->grouped_transactions = $this->transactions->groupBy('year')->toArray();
            $this->transaction_status = "OK";
        }
        else{
            $this->transaction_status = "Error";
        }
    }

    public function render()
    {
        return view('livewire.transactions');
    }

    public function save_note($id, $value){
        Transaction::where('id', $id)->update([
            'notes' => $value,
        ]);
        $this->load_transactions();
    }

    public function load_more(){
        $this->load_amount += 15;
        $this->load_transactions();
    }

    public function updateCategory($transaction_id, $category_id){
        $transaction = Transaction::find($transaction_id);
        if($category_id == null){
            $transaction->category_id = null;
        }
        else{
            $transaction->category_id = $category_id;
            // $category = Category::find($category_id);
            // $transaction->category()->associate($category);
        }
        $transaction->save();
        $this->load_transactions();
    }
}
