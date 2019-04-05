<?php
namespace Jsehersan\LaravelWubook\Events;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestSendEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $token;
    public $method;

    public function __construct($token,$method)
    {
        $this->token = $token;
        $this->method = $method;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }

}
