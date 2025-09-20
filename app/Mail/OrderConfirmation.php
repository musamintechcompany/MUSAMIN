<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;

    public function __construct($orders)
    {
        $this->orders = is_array($orders) ? $orders : [$orders];
    }

    public function build()
    {
        return $this->subject('Order Confirmation - Your Purchase is Confirmed')
                    ->view('emails.order-confirmation')
                    ->with(['orders' => $this->orders]);
    }
}