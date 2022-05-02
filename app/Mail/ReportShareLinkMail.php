<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportShareLinkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $token;
    
    public function __construct($token)
    {
        $this->queue = "mail_queue";

        $this->message = $token;
    }

    public function build()
    {
        return $this->subject("Instructions for Sharing Report with Link")
        ->markdown('emails.report_share_link', [
            'token'=> $this->token,
        ]);
    }
}
