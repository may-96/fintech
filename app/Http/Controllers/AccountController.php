<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            /** @var \App\Models\User */
            $user = Auth::user();
            
            $accounts = $user->accounts()->select(['id','institution_id','requisition_id','account_id','iban','bban','resource_id','owner_name','display_name','account_name','currency','type_string','account_status'])->withCount('shared_with')->with('requisition')->get()->flatten();
            return view('app.my_accounts', ["accounts" => $accounts]);
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    public function shared_index(Request $request)
    {
        try
        {
            /** @var \App\Models\User */
            $user = Auth::user();
            return view('app.shared_accounts');
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    
}
