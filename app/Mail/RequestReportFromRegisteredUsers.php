<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestReportFromRegisteredUsers extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $auth_user;
    public $user;
    
    public function __construct($auth_user, $user)
    {
        $this->queue = "mail_queue";
        $this->auth_user = $auth_user;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->user->fname." Requested Your Credit Report")
        ->markdown('emails.request_report_registered', [
            'auth_user'=> $this->auth_user,
            'user'=> $this->user,
        ]);
    }
}
