<?php

namespace App\Http\Livewire;

use App\Helpers\Functions;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountPreview extends Component
{
    public $accounts;
    public $user;

    public function mount($accounts){
        $this->user = Auth::user();
        $this->accounts = $accounts;
    }

    public function render()
    {
        return view('livewire.account-preview');
    }

    public function fetch_transactions(){
        $req = "";
        $temp = [];
        foreach($this->accounts as $account_array){
            if(is_array($account_array)){
                $account = Account::find($account_array['id']);
            }
            else{
                $account = $account_array;
            }
            $temp[] = $account;
            Functions::fetchTransactions($this->user, $account, null, null);
            $req = $account->requisition->reference_id;
        }
        $this->accounts = $temp;
        $redirect_path = session()->pull('intended_report_share_redirect',"");
        
        if(Functions::not_empty(trim($redirect_path))){
            $this->emit('transactionFetchRedirectReportShare', $redirect_path);
        }
        else{
            $this->emit('transactionFetched', $req);
        }
        
    }
}
