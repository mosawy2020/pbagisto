<?php

namespace Webkul\AbandonCart\Listeners;

/**
 * Cart event handler
 *
 * @author    Rahul Shukla <rahulshukla.symfony527@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Cart
{
    /**
     * Set abandon cart.
     *
     * @param  \Webkul\Checkout\Contracts\Cart  $cart
     * @return void
     */
    public function addAfter($cart)
    {
        if (core()->getConfigData('abandon_cart.settings.general.status')) {
            $cart->is_abandoned = 1;
            $cart->save();
        }
    }
}
