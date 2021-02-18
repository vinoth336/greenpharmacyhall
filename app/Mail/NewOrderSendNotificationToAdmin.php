<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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

        return $this->to('greenpharmacyhall@gmail.com')
             ->view('mail.admin_new_order')
             ->with('user', $this->user)
             ->with('order', $this->userOrder)
             ->with('orderItems', $this->userOrder->ordered_items()->get());
    }
}
