<?php

namespace Webkul\AbandonCart\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * AbandonCartNotification Mail class
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class AbandonCartNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The cart instance.
     *
     * @var Order
     */
    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                ->to($this->cart->customer_email, $this->cart)
                ->subject(trans('abandoncart::app.abandon-cart.mail.subject'))
                ->view('abandoncart::admin.emails.cart-abandon');
    }
}
