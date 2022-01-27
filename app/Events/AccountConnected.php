<?php

namespace App\Events;

use App\Interfaces\AccountTransactionsEventInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccountConnected implements AccountTransactionsEventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $account;
    public $date_from;
    public $date_to;

    public function __construct($user, $account, $date_from = null, $date_to = null)
    {
        $this->user = $user;
        $this->account = $account;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }
}
