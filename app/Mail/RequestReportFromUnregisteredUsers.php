<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestReportFromUnregisteredUsers extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $user;
    
    public function __construct($user)
    {
        $this->queue = "mail_queue";
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->user->fname." Requested Your Credit Report")
        ->markdown('emails.request_report', [
            'user'=> $this->user,
        ]);
    }
}
