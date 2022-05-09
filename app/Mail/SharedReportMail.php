<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SharedReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $user;
    public $shared_user;
    public $token;
    
    public function __construct($user, $shared_user, $token)
    {
        $this->queue = "mail_queue";
        $this->user = $user;
        $this->shared_user = $shared_user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject($this->user->fname." Shared Credit Report with You")
        ->markdown('emails.share_report_mail', [
            'user'=> $this->user,
            'shared_user' => $this->shared_user,
            'token'=> $this->token
        ]);
    }
}
