<?php

namespace App\Events;

use App\Models\Messenger;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public function __construct(Messenger $messenger)
    {
        $this->message = $messenger;
    }

    public function broadcastOn()
    {

        return new PrivateChannel('messages.'.$this->message->to_user);

    }
    Public function broadcastWith(){
        return ['message'=>$this->message];
    }

}
