<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;

    public $message;
    public $subject;
    public $name;
    public $email;
    
    public function __construct($message, $subject, $name, $email)
    {
        $this->queue = "mail_queue";

        $this->message = $message;
        $this->subject = $subject;
        $this->name = $name;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject("Contact Form Query: ". $this->subject)
        ->markdown('emails.contact_reply', [
            'message'=> $this->message,
            'subject'=> $this->subject,
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
