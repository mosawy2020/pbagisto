<?php
    $productUpSells = $product->up_sells()->get();
    $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
?>

@if ($productUpSells->count())
<div class="upsell-wrapper">
        {{-- <card-list-header
            heading="{{ __('shop::app.products.up-sell-title') }}"
            view-all="false"
            row-class="pt20"
        ></card-list-header> --}}
    <div class="container">
        <div class="carousel-products-header custome-header">
            <h3>{{ __('shop::app.products.up-sell-title') }}</h3>
        </div>
    </div>

    <div class="carousel-products">
        <carousel-component
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="upsell-products-carousel"
            :slides-count="{{ sizeof($productUpSells) }}"
            locale-direction="{{ $direction }}" 
            :slides-per-page-xlg="3"
            :slides-per-page-lg="3"
            :slides-per-page-md="3"
            :slides-per-page-sm="2"
            :slides-per-page-xs="2">

            @foreach ($productUpSells as $index => $upSellProduct)
                <slide slot="slide-{{ $index }}">
                    @include ('shop::products.list.card', [
                        'product' => $upSellProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ])
                </slide>
            @endforeach
        </carousel-component>
    </div>
</div>
@endif