<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\TransactionController;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app.landing_page');
})->name('index');

Route::get('/dashboard', function () {
    return view('app.dashboard');
})->name('dashboard');

Route::get('/shared_accounts', function () {
    return view('app.shared_accounts');
})->name('shared.accounts');

Route::get('/list_of_accounts', function () {
    return view('app.list_of_accounts');
})->name('list.accounts');;
Route::get('/reports', function () {
    return view('app.reports');
})->name('credit.report');;

// Route::get('transactions', function () {
//     return view('app.transaction_list');
// })->name('list.transaction');

Route::get('transaction_timeline', function () {
    return view('app.transaction_timeline');
})->name('timeline.transaction');

Route::get('transaction_timeline_2', function () {
    return view('app.transaction_timeline_2');
})->name('timeline.transaction.2');

Auth::routes(['verify' => true]);

Route::get('/connect_bank', function () {
    return view('app.connect_bank');
})->middleware(['auth','token'])->name('connect_bank');

Route::get('/transactions/{account_id}', [TransactionController::class, 'my_account_transactions_view'])->middleware(['auth','token'])->name('my.transactions');

Route::get('/connect/status/{reference_id}', [RequisitionController::class, 'redirect'])->middleware(['auth', 'token'])->name('requisition.redirect');

Route::get('/my_accounts', [AccountController::class, 'index'])->middleware(['auth', 'token'])->name('my.accounts');

Route::post('/account/remove/{requisition}', [RequisitionController::class, 'destroy'])->middleware(['auth', 'token'])->name('remove.bank');
