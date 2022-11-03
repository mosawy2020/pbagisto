<div class="fearured-products-carousel-wrapper">
    @php
        $count = core()->getConfigData('catalog.products.homepage.no_of_featured_product_homepage');
        $count = $count ? $count : 10;
        $direction = core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr';
    @endphp

    <product-collections
        product-id="fearured-products-carousel"
        product-title="{{ __('shop::app.home.featured-products') }}"
        product-route="{{ route('velocity.category.details', ['category-slug' => 'featured-products', 'count' => $count]) }}"
        locale-direction="{{ $direction }}"
        count="{{ (int) $count }}"
        :show-desc="true"
        :slides-per-page-xlg="2"
        :slides-per-page-lg="2"
        :slides-per-page-md="2"
        :slides-per-page-sm="2"
        :slides-per-page-xs="2">
    </product-collections>
</div>