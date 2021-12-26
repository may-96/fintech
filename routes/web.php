<?php

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

Route::get('/my_accounts', function () {
    return view('app.my_accounts');
})->name('my.accounts');

Route::get('/list_of_accounts', function () {
    return view('app.list_of_accounts');
})->name('list.accounts');;

Route::get('transaction', function () {
    return view('app.transaction');
})->name('list.transaction');

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();
