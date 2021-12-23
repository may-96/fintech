<?php

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
    return view('app.landing-page');
});
Route::get('/myaccounts', function () {
    return view('app.myaccounts');
});
Route::get('/listofaccounts', function () {
    return view('app.listofaccounts');
});
Route::get('/transaction', function () {
    return view('app.transaction');
});
