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
            
            $accounts = $user->accounts()->withCount('shared_with')->get()->groupBy('institution_id');
            return view('app.my_accounts', ["accounts" => $accounts]);
        }
        catch (Exception $e)
        {
            Log::error($e->getCode() . ' - ' . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
            abort(500, $e->getMessage());
        }
    }

    
}
