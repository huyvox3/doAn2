<?php

namespace App\Notifications;

use App\Models\order_line;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderIsShipped extends Notification
{
    use Queueable;
    private $user;
    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$order)
    {
        //

        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        
      
        return (new MailMessage)
                    ->greeting('Hi '. $this->user->name.',')
                    ->line('We are here to annouce you that your order is now shipped.')
                    
                    ->line('Order ID: '.$this->order->id)
           
                    ->line('The order will be deliveried within 3 days.')
                    ->line('Thank you for choosing our products!')
                  ;  
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
