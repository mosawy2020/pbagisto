@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')
@inject ('productRepository', 'Webkul\Product\Repositories\ProductRepository')

@extends('shop::layouts.master')

@section('page_title')
    {{ trim($category->meta_title) != "" ? $category->meta_title : $category->name }}
@stop

@section('seo')
    <meta name="description" content="{{ $category->meta_description }}" />
    <meta name="keywords" content="{{ $category->meta_keywords }}" />

    @if (core()->getConfigData('catalog.rich_snippets.categories.enable'))
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getCategoryJsonLd($category) !!}
        </script>
    @endif
@stop

@push('css')
    <style type="text/css">
        .product-price span:first-child, .product-price span:last-child {
            font-size: 18px;
            font-weight: 600;
        }

        @media only screen and (max-width: 992px) {
            .main-content-wrapper .vc-header {
                box-shadow: unset;
            }
        }
    </style>
@endpush

@php
    $isProductsDisplayMode = in_array(
        $category->display_mode, [
            null,
            'products_only',
            'products_and_description'
        ]
    );

    $isDescriptionDisplayMode = in_array(
        $category->display_mode, [
            null,
            'description_only',
            'products_and_description'
        ]
    );
@endphp

@section('content-wrapper')

 
    <category-component></category-component>
    
@php
 //   dd($category->getPathCategories());
@endphp

@stop

@push('scripts')
    <script type="text/x-template" id="category-template">
        <!--<section class="row col-12 velocity-divide-page category-page-wrapper">-->
            
        <section class="velocity-divide-page category-page-wrapper">
            @if($category->subcategories->isNotEmpty())
                <div class="hero-image">
                    @if (!is_null($category->image))
                        <img class="logo lazyload" data-src="{{ $category->image_url }}" alt="" width="20" height="20" />
                    @endif
                </div>
            @endif
            @if($category->subcategories->isNotEmpty())
                <div class="sub-categories-wrapper ">
                    <div class="container">
                        <div class="row">
                            @include ('shop::products.list.category' , ['categories' => $category->subcategories])
                        </div>
                    </div>
                </div>
            @endif
            {!! view_render_event('bagisto.shop.productOrCategory.index.before', ['category' => $category]) !!}
            <!--
            @if (in_array($category->display_mode, [null, 'products_only', 'products_and_description']))
                @include ('shop::products.list.layered-navigation')
            @endif -->
            <!--<div class="category-container right">-->
            <div class="category-container">
                @if(!$category->subcategories->isNotEmpty())
                    <div class="container">
                        
                        @if ($isProductsDisplayMode)
                            <div class="filters-container">
                                <template v-if="products.length >= 0">
                                    @include ('shop::products.list.toolbar')
                                </template>
                            </div>
                        @endif

                        {{ Breadcrumbs::render('shop.productOrCategory.index',$category) }}                        
                    
                        <div class="row remove-padding-margin">
                            <div class="pl0 col-12">
                                <h2 class="fw6 mb10 primary-title">{{ $category->name }}</h2>

                                @if ($isDescriptionDisplayMode)
                                    @if ($category->description)
                                        <div class="category-description text-justify">
                                            {!! $category->description !!}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                    </div>
                @endif

                @if ($isProductsDisplayMode)
                    <!-- <div class="filters-container">
                        <template v-if="products.length >= 0">
                            @include ('shop::products.list.toolbar')
                        </template>
                    </div> -->

                    <div
                        class="category-block"
                        @if ($category->display_mode == 'description_only')
                            style="width: 100%"
                        @endif>

                        <shimmer-component v-if="isLoading" shimmer-count="2"  :slides-per-page-xlg="2" :slides-per-page-lg="2"
                        :slides-per-page-md="2" :slides-per-page-sm="2" :slides-per-page-xs="2"></shimmer-component>

                        <template v-else-if="products.length > 0">
                            @if ($toolbarHelper->getCurrentMode() == 'grid')
                                <div class="row no-margin">
                                    <div class="col-12 col-md-6"
                                        v-for="(product, index) in products" 
                                        :key="index">
                                        <product-card
                                            :show-desc="true"
                                            :product="product"
                                            product-classes="main-product-card "
                                            >
                                        </product-card>
                                    </div>
                                </div>
                            @else
                                <div class="product-list">
                                    <product-card
                                        list=true
                                        :key="index"
                                        :product="product"
                                        product-classes="main-product-card"
                                        v-for="(product, index) in products">
                                    </product-card>
                                </div>
                            @endif

                            {!! view_render_event('bagisto.shop.productOrCategory.index.pagination.before', ['category' => $category]) !!}

                            <div class="bottom-toolbar" v-html="paginationHTML"></div>

                            {!! view_render_event('bagisto.shop.productOrCategory.index.pagination.after', ['category' => $category]) !!}
                        </template>
                        @if(!$category->subcategories->isNotEmpty())
                            <div class="product-list empty" v-else>
                                <h2>{{ __('shop::app.products.whoops') }}</h2>
                                <p>{{ __('shop::app.products.empty') }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {!! view_render_event('bagisto.shop.productOrCategory.index.after', ['category' => $category]) !!}
        </section>
        
    </script>

    <script>
        Vue.component('category-component', {
            template: '#category-template',

            data: function () {
                return {
                    'products': [],
                    'isLoading': true,
                    'paginationHTML': '',
                }
            },

            created: function () {
                this.getCategoryProducts();
                // console.log(`${this.$root.baseUrl}/category-products/{{ $category->id }}${window.location.search}`)
            },

            methods: {
                'getCategoryProducts': function () {
                    this.$http.get(`${this.$root.baseUrl}/category-products/{{ $category->id }}${window.location.search}`)
                    .then(response => {
                        this.isLoading = false;
                        this.products = response.data.products;
                        this.paginationHTML = response.data.paginationHTML;
                    })
                    .catch(error => {
                        this.isLoading = false;
                        console.log(this.__('error.something_went_wrong'));
                    })
                }
            }
        })
    </script>
@endpush