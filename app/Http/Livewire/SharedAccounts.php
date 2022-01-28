<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SharedAccounts extends Component
{
    public $accounts;
    public $selected_account_id = 0;
    public $nickname;
    public $user;

    public function mount()
    {
        /** @var \App\Models\User */
        $this->user = Auth::user();

        $this->load_shared_account();
    }

    public function render()
    {
        return view('livewire.shared-accounts');
    }

    private function load_shared_account(){
        $this->accounts = $this->user->shared_accounts()->select(['accounts.id','accounts.account_id','iban','bban','resource_id','owner_name','display_name','currency'])->get()->flatten()->toArray();
    }

    public function add_nickname($id)
    {
        $this->selected_account_id = $id;
        $this->nickname = DB::table('account_user')->where('account_id',$this->selected_account_id)->where('user_id', $this->user->id)->get()->first()->nickname;
    }

    public function save_nickname(){
        $this->user->shared_accounts()->updateExistingPivot($this->selected_account_id, [
            'nickname' => $this->nickname,
        ]);
        $this->load_shared_account();
        $this->nickname = "";
        $this->selected_account_id = 0;
        $this->emit('nickNameAdded');
    }
}
