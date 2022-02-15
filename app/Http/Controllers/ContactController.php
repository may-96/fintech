<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function queryHandler(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','min:3'],
            'email_address' => ['required','email'],
            'subject' => ['required','string','min:3'],
            'message' => ['required','string','min:10'],
            'g-recaptcha-response' => ['required','string']
        ]);

        $response = Http::withHeaders([
            'accept' => 'application/json',
        ])->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('GOOGLE_RECAPTCHA_V3_SECRET_KEY'),
                'response' => $data['g-recaptcha-response'],
                'remoteip' => $request->ip(),
            ]
        );

        if ($response->successful())
        {
            $response_data = $response->json();
            $success = $response_data['success'];
            if($success){
                Mail::to($data['email_address'])->send( new ContactFormReply($data['message'], $data['subject'], $data['full_name'], $data['email_address']) );
                return redirect()->back()->with('success', 'Message has been sent successfully.');
            }
            else{
                return redirect()->back()->with('danger', 'reCaptcha Verification Failed');
            }
        }
        else{
            return redirect()->back()->with('danger', 'Unable to Send Message. Google reCaptcha Server is Down!');
        }
    }
}
