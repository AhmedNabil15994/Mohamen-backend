<?php

namespace Modules\Reservation\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaidEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $payment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }
    public function broadcastOn()
    {
        return [config('core.config.constants.DASHBOARD_CHANNEL')];
    }
    public function broadcastAs()
    {
        return config('core.config.constants.DASHBOARD_ACTIVITY_LOG');
    }
}
