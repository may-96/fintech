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

            $temp_array = explode('-',$account_id);
            $id = $temp_array[count($temp_array)-1];
            $aid = substr( $account_id, 0, strrpos( $account_id, '-' ) );

            $account = Account::where('id',$id)->where('account_id',$aid)->where('user_id',$user->id)->get()->first();

            if($account && $user->id == $account->user_id){
                return view('app.transactions', ["account_id" => $aid, "aid" => $id]);
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

            $temp_array = explode('-',$account_id);
            $id = $temp_array[count($temp_array)-1];
            $aid = substr( $account_id, 0, strrpos( $account_id, '-' ) );

            $account = Account::where('id',$id)->where('account_id',$aid)->get()->first();        
            if($account){
                $exists = $user->shared_accounts()->newPivotStatementForId($account->id)->exists();
                if($exists){
                    $notes = $user->shared_accounts()->newPivotStatementForId($account->id)->get()->first()->notes_shared;
                    return view('app.shared_transactions', ["account_id" => $aid, "aid" => $id, 'notes_shared' => $notes]);
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

    public function shareable_account(Request $request, $token){
        try{
            $account = Account::where('shareable_link', $token)->get()->first();
            if($account){
                return view('app.shareable_link_transactions', ["account_id" => $account->account_id, "aid" => $account->id, 'notes_shared' => 1]);
            }
            return redirect()->back()->with('danger', "No such Account Exist");

        }
        catch(Exception $e){
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
