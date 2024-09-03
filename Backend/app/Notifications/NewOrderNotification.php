<?php

namespace App\Notifications;

use App\Models\Order_item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order_item $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'message' => 'A new order has been placed!',
        ]);
    }
    /**
     * Get the array representation of the notification for the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */



}
