<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:15,1')->only('verify', 'resend');
    }

    protected function verified(Request $request)
    {
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : view('auth.verified')->with('verified', true);
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (Functions::not_empty($user))
        {
            throw new AuthorizationException;
        }

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification())))
        {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail())
        {
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified())
        {
            event(new Verified($user));
        }

        if ($response = $this->verified($request))
        {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($this->redirectPath())->with('verified', true);
    }
}
