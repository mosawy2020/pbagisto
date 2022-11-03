@php
    $count = core()->getConfigData('catalog.products.homepage.no_of_new_product_homepage');
    $count = $count ? $count : 10;
    $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
@endphp

{!! view_render_event('bagisto.shop.new-products.before') !!}

<product-collections
    class="product-collection-carousel featured-category-products-carousel"
    count="{{ (int) $count }}"
    product-id="new-products-carousel"
    product-title="{{ $title ??   __('shop::app.home.new-products')  }}"
    product-sub-title="{{ $subTitle ??   __('shop::app.home.new-products') }}"
    product-button-text="{{ __('shop::app.home.shop-now') }}"
    product-button-link="{{ $link ??   __('shop::app.home.new-products') }}"
    product-route="{{ route('velocity.category.details', ['category-slug' => 'new-products', 'count' => $count]) }}"
    locale-direction="{{ $direction }}"
    show-recently-viewed="false"
    recently-viewed-title="{{ __('velocity::app.products.recently-viewed') }}"
    no-data-text="{{ __('velocity::app.products.not-available') }}"
    product-classes="main-product-card"
    :show-desc="true"
    :slides-per-page-xlg="3"
    :slides-per-page-lg="3"
    :slides-per-page-md="3"
    :slides-per-page-sm="3"
    :slides-per-page-xs="2">
</product-collections>
{{-- show-recently-viewed="{{ (Boolean) $showRecentlyViewed ? 'true' : 'false' }}" --}}
{{-- product-title="{{ __('shop::app.home.new-products') }}" --}}
{!! view_render_event('bagisto.shop.new-products.after') !!}
