<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PharmaNewOrderSendNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $userOrder;

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
        return $this->to(SEND_NEW_ORDER_PHARMA_NOTIFICATION_TO_ADMIN)
        ->view('mail.admin_pharma_order')
        ->with('user', $this->user)
        ->with('userOrder', $this->userOrder);
    }
}
