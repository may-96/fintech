<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('contact_us', function () { return view('app.contact_us'); })->name('contact.us');

Route::post('contact/query', [ContactController::class, 'queryHandler'])->name('submit.contact.query');

Auth::routes(['verify' => true]);

Route::get('/dashboard', function () { return view('app.dashboard'); })->middleware(['auth'])->name('dashboard');

Route::get('settings', [UserController::class, 'show'])->middleware(['auth'])->name('settings');
Route::post('settings/basic', [UserController::class, 'basic_settings'])->middleware(['auth'])->name('basic.settings');
Route::post('settings/contact', [UserController::class, 'contact_settings'])->middleware(['auth'])->name('contact.settings');
Route::post('settings/security', [UserController::class, 'security_settings'])->middleware(['auth'])->name('security.settings');

Route::get('/connect_bank', function () { return view('app.connect_bank'); })->middleware(['auth','token'])->name('connect_bank');

Route::get('/transactions/{account_id}', [TransactionController::class, 'my_account_transactions_view'])->middleware(['auth','token'])->name('my.transactions');
Route::get('/shared/transactions/{account_id}', [TransactionController::class, 'shared_account_transactions_view'])->middleware(['auth'])->name('shared.transactions');

Route::get('/connect/status/{reference_id}', [RequisitionController::class, 'redirect'])->middleware(['auth', 'token'])->name('requisition.redirect');
Route::get('/reconnect/status/{reference_id}', [RequisitionController::class, 'reconnect'])->middleware(['auth', 'token'])->name('requisition.reconnect');

Route::get('/my_accounts', [AccountController::class, 'index'])->middleware(['auth', 'token'])->name('my.accounts');

Route::get('/shared_accounts', [AccountController::class, 'shared_index'])->middleware(['auth'])->name('shared.accounts');

Route::get('request_report', [ReportController::class, 'show'])->middleware(['auth'])->name('request.report');
Route::post('request_report', [ReportController::class, 'requestReport'])->middleware(['auth'])->name('request.report.submit');
Route::post('report/grant_access', [ReportController::class, 'grantAccess'])->middleware(['auth'])->name('report.grant.access');

Route::get('shared_reports', [ReportController::class, 'sharedReports'])->middleware(['auth'])->name('shared.reports');

Route::post('/account/remove/{requisition}', [RequisitionController::class, 'destroy'])->middleware(['auth', 'token'])->name('remove.bank');

Route::post('/notification/fetch', [NotificationController::class, 'index'])->middleware(['auth'])->name('fetch.notifications');
Route::post('/notification/read/{notification}', [NotificationController::class, 'read'])->middleware(['auth'])->name('read.notification');
Route::post('/notification/unread/{notification}', [NotificationController::class, 'unread'])->middleware(['auth'])->name('unread.notification');
Route::post('/notification/destroy/{notification}', [NotificationController::class, 'destroy'])->middleware(['auth'])->name('destroy.notification');

Route::get('/report/{token?}', [ReportController::class, 'fetchReport'])->middleware(['auth'])->name('get.report');

