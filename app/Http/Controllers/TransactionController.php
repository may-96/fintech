<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function my_account_transactions_view(Request $request, $account_id){
        return view('app.transactions', ["account_id" => $account_id]);
    }
}
