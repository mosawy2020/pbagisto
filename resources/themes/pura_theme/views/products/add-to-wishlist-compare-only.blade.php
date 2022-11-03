{!! view_render_event('bagisto.shop.products.add_to_cart.before', ['product' => $product]) !!}

    <div class="mx-0 no-padding">
        @if (isset($showCompare) && $showCompare)
            <compare-component
                @auth('customer')
                    customer="true"
                @endif

                @guest('customer')
                    customer="false"
                @endif

                slug="{{ $product->url_key }}"
                product-id="{{ $product->id }}"
                add-tooltip="{{ __('velocity::app.customer.compare.add-tooltip') }}"
            ></compare-component>
        @endif

        @if (! (isset($showWishlist) && !$showWishlist) && core()->getConfigData('general.content.shop.wishlist_option'))
            @include('shop::products.wishlist', [
                'addClass' => $addWishlistClass ?? ''
            ])
        @endif
    </div>

{!! view_render_event('bagisto.shop.products.add_to_cart.after', ['product' => $product]) !!}