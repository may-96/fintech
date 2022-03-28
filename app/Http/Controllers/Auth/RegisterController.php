<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Notification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $flash_message = "";

        $shares = DB::table('account_shares_with_unregistered_users')->where('email',$data['email'])->get();
        foreach($shares as $share){
            $user->shared_accounts()->attach($share->account_id, ['notes_shared' => $share->notes_shared]);

            $account = Account::find($share->account_id);
            $temp_user = $account->user;
            $message = $temp_user->fname . ' ' . $temp_user->lname . ' has shared an Account of '. $account->institution->name;
            $notification = Notification::create([
                'type' => 'account_share',
                'data' => $account->account_id.'-'.$account->id,
                'user_id' => $user->id,
                'message' => $message,
                'read' => 0
            ]);
            $flash_message .= $message;
        }
        DB::table('account_shares_with_unregistered_users')->where('email',$data['email'])->delete();

        $shares = DB::table('report_shares_with_unregistered_users')->where('email',$data['email'])->get();
        foreach($shares as $share){
            $user->shared_reports_with()->attach($share->user_id, [
                'view_cash_flow' => $share->view_cash_flow,
                'view_expense' => $share->view_expense,
                'view_income' => $share->view_income,
                'view_email' => $share->view_email,
                'view_contact' => $share->view_contact,
                'view_credit_score' => $share->view_credit_score,
                'view_initials_only' => $share->view_initials_only,
                'view_account_initials_only' => $share->view_account_initials_only,
                'token' => $share->token,
            ]);

            $temp_user = User::find($share->user_id);

            $message = $temp_user->fname . ' ' . $temp_user->lname . ' has shared the Credit Report with you.';

            $notification = Notification::create([
                'type' => 'report_share',
                'data' => $share->token,
                'user_id' => $user->id,
                'message' => $message,
                'read' => 0
            ]);

            if($flash_message != ""){
                $flash_message .= $message;
            }
            else{
                $flash_message .= "\n".$message;
            }
        }
        DB::table('report_shares_with_unregistered_users')->where('email',$data['email'])->delete();

        $shares = DB::table('report_requested_from_unregistered_users')->where('email',$data['email'])->get();
        foreach($shares as $share){
            $user->report_requested_from()->attach($share->user_id, [
                'amount' => $share->amount,
            ]);

            $temp_user = User::find($share->user_id);

            $message = $temp_user->fname . ' ' . $temp_user->lname . ' has requested you to share your Credit Report.';

            $notification = Notification::create([
                'type' => 'request_report',
                'data' => $temp_user->id,
                'user_id' => $user->id,
                'message' => $message,
                'read' => 0
            ]);

            if($flash_message != ""){
                $flash_message .= $message;
            }
            else{
                $flash_message .= "\n".$message;
            }
        }
        DB::table('report_requested_from_unregistered_users')->where('email',$data['email'])->delete();

        if($flash_message != ""){
            Session::flash('warning', $flash_message);
        }
        

        return $user;
    }
}
