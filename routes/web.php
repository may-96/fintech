<?php

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

Route::get('/email/verified', function () {
    return view('auth.verified');
})->name('verification.verified');

Auth::routes(['verify' => true]);

Route::get('dashboard', function () {
    return view('app.dashboard');
})->name('dashboard');
Route::get('/connect_bank', function () {
    return view('app.connect_bank');
})->name('connectbank');


Route::get('my_accounts', function () {
    return view('app.my_accounts');
})->name('my.accounts');

Route::get('shared_accounts', function () {
    return view('app.shared_accounts');
})->name('shared.accounts');

Route::get('list_of_accounts', function () {
    return view('app.list_of_accounts');
})->name('list.accounts');;

Route::get('transaction', function () {
    return view('app.transaction_list');
})->name('list.transaction');

Route::get('transaction_timeline', function () {
    return view('app.transaction_timeline');
})->name('timeline.transaction');

Route::get('connect_bank', function () {
    return view('app.connect_bank');
})->name('connect_bank');

