<?php

namespace App\Notifications\Admin;

use App\Enums\OrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveryTypeUpdate extends Notification implements ShouldQueue
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order_status_key = OrderStatus::getKey($this->order->order_status);
        $order_status = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $order_status_key));

        return (new MailMessage)
            ->subject(trans('email.order_status.subject',['order_id' => $this->order->id, 'order_status' => $order_status]))
            ->markdown('user.emails.order', ['order' => $this->order, 'order_status' => $order_status]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
