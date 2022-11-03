@foreach ($cart->items as $item)
    <?php
        $product = $item->product;

        if ($product->cross_sells()->count()) {
            $products[] = $product;
            $products = array_unique($products);
        }
        $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
    ?>
@endforeach

@if (isset($products))
<div class="cross-sells-wrapper">
    <div class="container">
        <card-list-header
            heading="{{ __('shop::app.products.cross-sell-title') }}"
            view-all="false"
            row-class="pt20"
        ></card-list-header>
    </div>
    
    <div class="carousel-products vc-full-screen">
        <carousel-component
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="upsell-products-carousel"
            locale-direction="{{ $direction }}"
            :slides-count="{{ $product->cross_sells()->count() }}" 
            :slides-per-page-xlg="3"
            :slides-per-page-lg="3"
            :slides-per-page-md="3"
            :slides-per-page-sm="2"
            :slides-per-page-xs="2">

            @foreach($products as $product)
                @foreach ($product->cross_sells()->paginate(4) as $index => $crossSellProduct)
                    <slide slot="slide-{{ $index }}">
                        @include ('shop::products.list.card', [
                            'product' => $crossSellProduct,
                            'addToCartBtnClass' => 'small-padding',
                        ])
                    </slide>
                @endforeach
            @endforeach
        </carousel-component>
    </div>
</div>
@endif