<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShareWithUnregisteredUsers extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $user;
    public $account;
    
    public function __construct($user, $account)
    {
        $this->queue = "mail_queue";
        $this->user = $user;
        $this->account = $account;
    }

    public function build()
    {
        return $this->subject($this->user->fname." Shared Account with You")
        ->markdown('emails.share_account', [
            'user'=> $this->user,
            'account'=> $this->account
        ]);
    }
}
