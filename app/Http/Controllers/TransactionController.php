<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function my_account_transactions_view(Request $request, $account_id){
        try{
            /** @var \App\Models\User */
            $user = Auth::user();

            $account = Account::where('account_id',$account_id)->get()->first();

            if($account && $user->id == $account->user_id){
                return view('app.transactions', ["account_id" => $account_id]);
            }
            return redirect(route('my.accounts'))->with('danger', "No such Account or Access Denied");
        }
        catch(Exception $e){
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            return redirect(route('my.accounts'))->with('danger', $e->getMessage());
        }
    }

    public function shared_account_transactions_view(Request $request, $account_id){
        try{
            /** @var \App\Models\User */
            $user = Auth::user();

            $account = Account::where('account_id',$account_id)->get()->first();        
            if($account){
                $exists = $user->shared_accounts()->newPivotStatementForId($account->id)->exists();
                if($exists){
                    $notes = $user->shared_accounts()->newPivotStatementForId($account->id)->get()->first()->notes_shared;
                    return view('app.shared_transactions', ["account_id" => $account_id, 'notes_shared' => $notes]);
                }
                return redirect(route('shared.accounts'))->with('danger', "Access Denied");
            }
            return redirect(route('shared.accounts'))->with('danger', "No such Account Exist");
        }
        catch(Exception $e){
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            return redirect(route('shared.accounts'))->with('danger', $e->getMessage());
        }
    }
}
