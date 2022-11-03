<?php

namespace Webkul\AbandonCart\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Checkout\Models\Cart;
use Illuminate\Support\Facades\Mail;
use Webkul\AbandonCart\Mail\AbandonCartNotification;

class AbandonCartMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abandoncart-mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically send abandoncart mail to customer.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (core()->getConfigData('abandon_cart.settings.general.status')) {
            $abandonCart = Cart::query()
            ->where('is_abandoned', 1)
            ->where('is_active', 1)
            ->where('is_guest', 0)
            ->get();

            foreach ($abandonCart as $cart) {
                Mail::send(new AbandonCartNotification($cart));
            }
        }      
    }
}