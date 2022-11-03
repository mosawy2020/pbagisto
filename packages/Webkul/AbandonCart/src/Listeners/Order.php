<?php

namespace Webkul\AbandonCart\Listeners;

use Webkul\Checkout\Repositories\CartRepository;

/**
 * Order event handler.
 *
 * @author    Rahul Shukla <rahulshukla.symfony527@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Order
{   
    /**
     * CartRepository object
     *
     * @var \Webkul\Checkout\Repositories\CartRepository
     */
    protected $cartRepository;

    /**
     * Create a new event instance.
     *
     * @param  \Webkul\Checkout\Repositories\CartRepository  $cartRepository
     * @return void
    */
    public function __construct(CartRepository $cartRepository)
    {   
        $this->cartRepository = $cartRepository;
    }

    /**
     * Disable abandon cart after order.
     *
     * @param  \Webkul\Sales\Contracts\Order  $order
     * @return void
     */
    public function placeAfter($order)
    {   
        $cart = $this->cartRepository->findOneWhere(['id' => $order->cart_id]);
 
        $cart->is_abandoned = 0;

        $cart->save();
    }
}
