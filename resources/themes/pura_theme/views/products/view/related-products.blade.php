<?php
    $relatedProducts = $product->related_products()->get();
    $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
    // dd(json_encode($relatedProducts))
?>

@if ($relatedProducts->count())
<div class="related-products-wrapper">
    <div class="container">
        {{-- <card-list-header
            heading="{{ __('shop::app.products.related-product-title') }}"
            view-all="false"
            row-class="pt20"
        ></card-list-header> --}}
        <div class="carousel-products-header custome-header">
            <h3>{{ __('shop::app.products.related-product-title') }}</h3>
            <h4>
                <span class="light-grey-text">{{ __('shop::app.products.related-product-subtitle') }}</span> 
                <span class="primary-text">{{ __('shop::app.products.related-product-subtitle2') }} </span>
                <span class="secondary-text">.</span> 
                <span class="yellow-text">.</span>
                <img class="lazyload"
                src="{{ asset('themes/pura_theme/assets/images/static/like_emoji.png') }}"
                alt="" />
            
            </h4>
        </div>
    </div>

    <div class="carousel-products">
        <carousel-component
            navigation-enabled="hide"
            pagination-enabled="hide"
            locale-direction="{{ $direction }}"
            id="related-products-carousel"
            :slides-count="{{ sizeof($relatedProducts) }}" 
            :slides-per-page-xlg="3"
            :slides-per-page-lg="3"
            :slides-per-page-md="3"
            :slides-per-page-sm="2"
            :slides-per-page-xs="2">

            @foreach ($relatedProducts as $index => $relatedProduct)
                <slide slot="slide-{{ $index }}">
                    @include ('shop::products.list.card', [
                        'product' => $relatedProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ])                    
                </slide>
            @endforeach
        </carousel-component>
    </div>
</div>
@endif