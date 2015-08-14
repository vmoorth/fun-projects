<?php

namespace App\Events;

use Log;
use App\Order;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Event
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param order $order 
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        Log::info('OrderPlacedEvent:', ['id' => $order->id]);
    }
}
?>
