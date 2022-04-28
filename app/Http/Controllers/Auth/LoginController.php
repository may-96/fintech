<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Mail\ReportShareLinkMail;
use App\Models\ReportRequestByLink;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * 
     * @param Request $request 
     * @param User $user 
     * @return mixed 
     * @throws BindingResolutionException 
     * @throws NotFoundExceptionInterface 
     * @throws ContainerExceptionInterface 
     */
    protected function authenticated(Request $request, $user)
    {
        if(session()->has('intended')){
            $email = true;
            $path = session()->get('intended');
            $path_array = explode('/', $path);
            $token = explode('#',end($path_array))[0];
            $request_link_query = ReportRequestByLink::where('link',$token)->get();
            $request_link = $request_link_query->first();
            $shared_with = $request_link->user_id;
            
            if($shared_with == $user->id){
                $email = false;
            }

            $check = $request_link_query->count();
            if ($check == 0){
                $email = false;
            }

            $check2 = $user->shared_reports()->wherePivotNotNull('reference')->where('user_id', $user->id)->wherePivot('reference',$token)->count();
            if($check2 !== 0){
                $email = false;
            }

            $check3 = $user->link_notify_email_sent()->count();
            if($check3 !== 0){
                $email = false;
            }

            if($email){
                // Mail::to($user->email)->send( new ReportShareLinkMail($path));
                $user->link_notify_email_sent()->attach($request_link->id);
                $user->save();
            }
        }
        return redirect(session()->pull('intended',$this->redirectTo));
    }
}
