<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class NewOrderSendNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $userOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userOrder)
    {
        $this->user = $user;
        $this->userOrder = $userOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailNotification = Cache::get('email_notification');

        return $this->to($emailNotification['order_create'])
             ->subject('Non-Pharma - New Order')
             ->view('mail.admin_new_order')
             ->with('user', $this->user)
             ->with('order', $this->userOrder)
             ->with('orderItems', $this->userOrder->ordered_items()->get());
    }
}
