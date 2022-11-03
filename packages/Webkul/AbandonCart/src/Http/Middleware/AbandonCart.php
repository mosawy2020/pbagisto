<?php

namespace Webkul\AbandonCart\Http\Middleware;

use Closure;

class AbandonCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        if (core()->getConfigData('abandon_cart.settings.general.status')) {
            return $next($request);
        }

        abort(404);
    }
}
