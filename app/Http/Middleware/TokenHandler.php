<?php

namespace App\Http\Middleware;

use App\Helpers\Functions;
use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TokenHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = Token::where('status', 1)->get()->first();
        if (Functions::is_empty($token))
        {
            $token = $this->generate_token();
        }
        else
        {
            $created_at = $token->created_at;
            $updated_at = $token->updated_at;
            $access_expires = $token->access_expires;
            $refresh_expires = $token->refresh_expires;

            $now = Carbon::now();
            $a_expiry = Carbon::parse($updated_at)->addSeconds($access_expires - 600);
            $r_expiry = Carbon::parse($created_at)->addSeconds($refresh_expires - 600);

            if ($now >= $r_expiry)
            {
                $token->status = 0;
                $token->save();
                $token = $this->generate_token();
            }
            else if ($now >= $a_expiry)
            {
                $token = $this->refresh_token($token);
            }
        }

        if(!Session::has('access_token')){
            Session::put("access_token",$token->access);
            Session::save();
        }
        
        return $next($request);
    }

    private function generate_token()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
        ])->post('https://ob.nordigen.com/api/v2/token/new/', [
            'secret_id' => config('services.nordigen.id'),
            'secret_key' => config('services.nordigen.key'),
        ]);
        if($response->successful()){
            $data = $response->json();
            $token = Token::create([
                'access' => Crypt::encryptString($data['access']),
                'access_expires' => $data['access_expires'],
                'refresh' => Crypt::encryptString($data['refresh']),
                'refresh_expires' => $data['refresh_expires'],
            ]);
            return $token;
        }
        throw new Exception("Error while Generating Token", 500);
    }

    private function refresh_token($token)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
        ])->post('https://ob.nordigen.com/api/v2/token/refresh/', [
            'refresh' => Crypt::decryptString($token->refresh),
        ]);
        if($response->successful()){
            $data = $response->json();
            $token->access =  Crypt::encryptString($data['access']);
            $token->access_expires = $data['access_expires'];
            $token->save();
            return $token;
        }
        throw new Exception("Error while Refreshing Token", 500);
    }
}
