@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')

@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.cart.title') }}
@stop

@section('content-wrapper')
    <cart-component></cart-component>
@endsection

@push('css')
    <style type="text/css">
        @media only screen and (max-width: 600px) {
            .rango-delete {
                margin-top: 10px;
                margin-left: -10px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    @include('shop::checkout.cart.coupon')

    <script type="text/x-template" id="cart-template">
        <div>
            <div class="container">
                <section class="cart-details">

                    <div class="row">
                        @if ($cart)
                            <div class="cart-details-header col-lg-7 col-md-12">
                                <div class="d-flex justify-content-between cart-header-title">
                                    <h2 class="fw6 col-12">{{ __('shop::app.checkout.cart.title') }}</h2>
                                    <form
                                        method="POST"
                                        @submit.prevent="onSubmit"
                                        action="{{ route('velocity.cart.remove.all.items') }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            onclick="return confirm('{{ __('shop::app.checkout.cart.confirm-action') }}')"
                                            class="theme-btn light unset">

                                            {{ __('shop::app.checkout.cart.remove-all-items') }}
                                        </button>
                                    </form>
                                </div>

                                <div class="cart-header">
                                    <div class="row ">
                                        <span class="col-8 fw6 fs16">
                                            {{ __('velocity::app.checkout.items') }}
                                        </span>

                                        <span class="col-2 fw6 fs16 text-center">
                                            {{ __('velocity::app.checkout.qty') }}
                                        </span>

                                        <span class="col-2 fw6 fs16 text-right">
                                            {{ __('velocity::app.checkout.subtotal') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="cart-content">
                                    <form
                                        method="POST"
                                        @submit.prevent="onSubmit"
                                        action="{{ route('shop.checkout.cart.update') }}">

                                        <div class="cart-item-list">
                                            @csrf

                                            @foreach ($cart->items as $key => $item)
                                                @php
                                                    $productBaseImage = $item->product->getTypeInstance()->getBaseImage($item);

                                                    $product = $item->product;

                                                    $productPrice = $product->getTypeInstance()->getProductPrices();

                                                    if (is_null ($product->url_key)) {
                                                        if (! is_null($product->parent)) {
                                                            $url_key = $product->parent->url_key;
                                                        }
                                                    } else {
                                                        $url_key = $product->url_key;
                                                    }
                                                @endphp

                                                <div class="row">
                                                    <div class="col-2">
                                                        <a
                                                            title="{{ $product->name }}"
                                                            class="product-image-container "
                                                            href="{{ route('shop.productOrCategory.index', $url_key) }}">

                                                            <img
                                                                class="card-img-top"
                                                                alt="{{ $product->name }}"
                                                                src="{{ $productBaseImage['large_image_url'] }}"
                                                                :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`">
                                                        </a>
                                                    </div>

                                                    <div class="product-details-content col-6">
                                                        <div class="row item-title no-margin">
                                                            <a
                                                                href="{{ route('shop.productOrCategory.index', $url_key) }}"
                                                                title="{{ $product->name }}"
                                                                class="unset col-12 no-padding">

                                                                <span class="fs20 fw6 link-color">{{ $product->name }}</span>
                                                            </a>
                                                        </div>



                                                        <div class="row col-12 no-padding no-margin item-price">
                                                            <div class="product-price">
                                                                <span>{{ core()->currency($item->base_price) }}</span>
                                                            </div>
                                                        </div>

                                                        @php
                                                            $moveToWishlist = trans('shop::app.checkout.cart.move-to-wishlist');

                                                            $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                                                        @endphp

                                                        <div class="no-padding col-12 cursor-pointer fs16 item-actions">
                                                            @auth('customer')
                                                                @if ($showWishlist)
                                                                    @if ($item->parent_id != 'null' || $item->parent_id != null)
                                                                        <div class="d-inline-block">
                                                                            @include('shop::products.wishlist', [
                                                                                'route' => route('shop.movetowishlist', $item->id),
                                                                                'text' => "<span class='align-vertical-super'>$moveToWishlist</span>"
                                                                            ])
                                                                        </div>
                                                                    @else
                                                                        <div class="d-inline-block">
                                                                            @include('shop::products.wishlist', [
                                                                                'route' => route('shop.movetowishlist', $item->child->id),
                                                                                'text' => "<span class='align-vertical-super'>$moveToWishlist</span>"
                                                                            ])
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endauth

                                                            <div class="d-inline-block">
                                                                <a
                                                                    class="unset"
                                                                    href="{{ route('shop.checkout.cart.remove', ['id' => $item->id]) }}"
                                                                    @click="removeLink('{{ __('shop::app.checkout.cart.cart-remove-action') }}')">

                                                                    <span class="rango-delete fs24"></span>
                                                                    <span class="align-vertical-super">{{ __('shop::app.checkout.cart.remove') }}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="product-quantity col-2 no-padding">
                                                        @if ($item->product->getTypeInstance()->showQuantityBox() === true)
                                                            <quantity-changer
                                                                :control-name="'qty[{{$item->id}}]'"
                                                                quantity="{{ $item->quantity }}"
                                                                quantity-text="{{ __('shop::app.products.quantity') }}">
                                                            </quantity-changer>
                                                        @else
                                                            <p class="fw6 fs16 no-padding text-center ml15">--</p>
                                                        @endif
                                                    </div>

                                                    <div class="product-price fs18 col-2">
                                                        <span class="card-current-price fw6 mr10">
                                                            {{ core()->currency( $item->base_total) }}
                                                        </span>
                                                    </div>

                                                    @if (! cart()->isItemHaveQuantity($item))
                                                        <div class="control-error mt-4 fs16 fw6">
                                                            * {{ __('shop::app.checkout.cart.quantity-error') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.controls.after', ['cart' => $cart]) !!}
                                        <div class="misc">
                                            <a
                                                class="theme-btn light fs16 text-center"
                                                href="{{ route('shop.home.index') }}">
                                                {{ __('shop::app.checkout.cart.continue-shopping') }}
                                            </a>



                                            @if ($item->product->getTypeInstance()->showQuantityBox() === true)
                                                <button
                                                    type="submit"
                                                    class="theme-btn light unset">

                                                    {{ __('shop::app.checkout.cart.update-cart') }}
                                                </button>
                                            @endif
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.controls.after', ['cart' => $cart]) !!}
                                    </form>
                                </div>


                            </div>

                        @endif

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $cart]) !!}

                            @if ($cart)
                                <div class="col-lg-4 col-md-12  row order-summary-container">
                                    @include('shop::checkout.total.summary', ['cart' => $cart])


                                </div>
                            @else
                            <div class="cart-empty-wrapper">
                                <!-- Generator: Adobe Illustrator 25.2.3, SVG Export Plug-In  -->
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="223.9px" height="238.1px" viewBox="0 0 223.9 238.1" style="overflow:visible;enable-background:new 0 0 223.9 238.1;" xml:space="preserve"> <defs> </defs> <g> <path class="st0" d="M175.6,100c-5.2-3.5-9.4-7.5-7.7-14.8c0.7-3-2.2-2.2-3.8-2.2c-34.8,0-69.6,0-104.3-0.1c-3,0-4.4,0.8-3.9,3.9 c0.9,5.4-0.8,9.3-6,11.5c-0.7,0.3-1.1,1.1-1.7,1.7c-2.2,1.4-1.2,3.6-1.2,5.4c-0.1,36.2-0.1,72.4-0.2,108.6 c-1.3,0.3-2.5,0.7-3.8,0.9c-9.5,1.2-19.1,2.2-28.4,4.9c-3.3,1-8.1,1.4-8,5.2c0,3.4,4.7,4,7.9,4.9c23.6,6.2,47.9,6.9,72,7.7 c34.5,1.1,69.1,0.6,103.5-3.8c7.2-0.9,14.4-2.2,21.4-4.4c2.4-0.8,6-1.5,6.1-4.4c0.1-3.3-3.7-3.9-6.3-4.8c-3.1-1.1-6.4-1.8-9.7-2.3 c-8.1-1.4-16.3-2.6-24.5-3.9c0-36.1,0-72.1-0.1-108.2C176.9,103.9,178,101.5,175.6,100z M159,76.2c6.3-1.9,10.8-3.1,15.2-4.6 c2.3-0.8,4.5-0.8,6.8-0.4c16.6,3.2,32.9-5.2,39.8-20.5c6.9-15.3,2.2-33.2-11.2-43.4c-13.3-10.1-32-9.7-44.8,1.1 c-12.9,10.8-17.2,29.3-8.7,43.7C160.5,59.7,164.4,66.5,159,76.2z M9.7,44.8c0.2-1,0.3-2.9-1-2.5c-2.7,0.9-4.2-0.3-6-1.8 c-0.6-0.5-1.6-0.8-2.3-0.1c-0.9,0.9-0.4,1.8,0.1,2.7c2.1,3.5,4.6,6.4,8.3,8.3c0.9,0.5,1.9,0.9,2.7,0c0.6-0.7,0.1-1.5-0.2-2.3 C10.9,47.6,8.3,47.1,9.7,44.8z M113.5,24c1.4,0,3.3,0.1,2.9-1.7c-0.5-2.3-3-1.3-4.7-1.7c-1.3-0.3-3.2-0.3-2.8,1.6 C109.5,24.5,112,23.5,113.5,24z M93.8,73.3c-1-1,0.7-4-2.2-4.3c-1.5-0.2-1.7,1.5-1.3,2.6c0.6,1.7-0.5,4.5,2.2,4.9 C93.8,76.7,94,75,93.8,73.3z M101.1,66.2c-0.6-2.2-2.8-1.8-4.4-2.1c-1.2-0.3-3.3-0.5-3.1,1.2c0.2,2.7,3.1,1.6,4.8,2.3 C99.5,68.1,100.7,67.8,101.1,66.2z M30.3,29.2c1-0.8,4.1,0.7,4.1-2.3c0-1.7-2.1-1.2-3.3-1c-1.6,0.3-4.1-0.3-4.1,2.3 C27,29.7,28.7,29.7,30.3,29.2z M55.3,37.7c0.9,2.1,2.4,3.9,4.4,5c0.9,0.5,1.9-0.6,1.7-1.2c-0.6-2.3-2.3-4-4.3-5.1 C56.2,36,55.7,36.9,55.3,37.7z M49.9,30.2c-1.1-2.1-3.3-2.9-5.5-3.4c-0.9-0.2-1.9,0.4-1.6,1.3c0.8,2.5,3.5,2.7,5.4,3.7 C49,32.1,49.7,31.3,49.9,30.2z M100.8,25.5c0.1-1.5-0.6-2.2-1.4-1.9c-2.1,0.7-3.7,2.2-4.5,4.3c-0.3,0.8,0.2,2,1.1,1.7 C98.4,29,99.5,26.8,100.8,25.5z M129.9,30.2c-1-1.9-2.2-3.8-4.6-4.5c-0.9-0.3-1.8,0.5-1.4,1.4c0.8,2.2,2.3,3.9,4.5,4.7 C129.3,32.2,129.8,31.4,129.9,30.2z M19.6,32.7c-0.3-0.9-0.8-1.9-1.7-1.5c-2.1,0.9-4.1,2.1-4.9,4.4c-0.3,0.8,0.6,1.7,1.5,1.3 C16.8,36.2,18.5,34.6,19.6,32.7z M93.1,39.9c0-1.2,0.3-3-1.2-2.8c-2.8,0.4-1.7,3.1-2.2,4.8c-0.3,1.1-0.2,2.9,1.2,2.6 C93.5,44.2,92.6,41.5,93.1,39.9z M72.5,52.6c-1.1-1.9-2.6-3.6-4.8-4.4c-0.8-0.3-1.8,0.7-1.5,1.4c0.9,2.2,2.5,3.8,4.7,4.6 C71.8,54.5,72.5,53.8,72.5,52.6z M88.9,56.7c0.3,1.5-0.6,3.9,1.8,3.9c2.1,0,1.4-2.3,1.3-3.6c-0.1-1.4,0.9-3.9-1.7-3.8 C88.2,53.1,89.2,55.4,88.9,56.7z M113.7,63.9c-1.2,0.7-3.9-0.1-4.4,2.4c-0.2,1.3,1.4,1.8,2.5,1.3c1.7-0.7,4.4,0.2,4.9-2.4 C117,63.6,115.3,63.9,113.7,63.9z M80.4,58.1c-1.1,0.1-1.9,0.7-1.7,1.5c0.8,2.5,3.3,2.9,5.4,3.6c0.7,0.2,1.9-0.4,1.5-1.4 C84.8,59.4,82.2,59.3,80.4,58.1z M129.8,56.7c0.1-1.2-0.5-2-1.3-1.8c-2.4,0.6-3.6,2.6-4.6,4.7c-0.4,0.9,0.4,1.7,1.2,1.6 C127.7,60.5,128.7,58.4,129.8,56.7z M130.8,43.4c0.3,1.3-0.7,3.5,1.4,3.6c2.5,0.1,1.7-2.3,1.7-3.7c0.1-1.3,0.6-3.5-1.4-3.6 C130,39.6,131.2,42,130.8,43.4z"/> <path class="st1" d="M46.8,214.1c0-36.2,0.1-72.4,0.2-108.6c0-1.8-1-4,1.2-5.4c42.5,0,84.9,0,127.4,0c2.4,1.5,1.3,3.9,1.3,5.9 C177,142,177,178,177,214.1c0,1.3-0.1,2.7-0.1,4c0,9.8-1.1,10.9-10.8,10.9c-34.6,0-69.3-0.1-103.9,0.1 C45.6,229.1,47,228.1,46.8,214.1z M75.9,120.9c0.1,8.1,0.2,16.3,0.3,24.4c0.2,21.1,15.9,37.2,36.3,37.2c20.4,0,36.1-16.1,36.2-37.2 c0.1-8.1,0.2-16.3,0.3-24.4c2.9-2.4,3.9-5.3,2.5-8.8c-1.1-2.7-3.3-4.1-6.2-4.2c-3.1-0.1-5.5,1.3-6.7,4.2c-1.5,3.5-0.4,6.5,2.5,8.8 c0.1,8.6,0.1,17.3,0.2,25.9c0.1,9.1-3.6,16.5-10.6,22c-9,7.1-19.1,8.4-29.5,4c-9.7-4-16.1-11.6-17-22.2c-0.8-9.9-0.1-19.9,0-29.8 c3-2.6,4-5.6,2.2-9.3c-1.5-3-4.2-4.1-7.5-3.7c-2.6,0.4-4.6,2-5.4,4.5C72.1,115.9,73.2,118.7,75.9,120.9z"/> <path class="st2" d="M159,76.2c5.4-9.8,1.6-16.5-2.9-24.1c-8.5-14.5-4.1-33,8.7-43.7c12.8-10.7,31.5-11.2,44.8-1.1 c13.4,10.2,18,28.1,11.2,43.4C213.9,66,197.6,74.4,181,71.2c-2.3-0.5-4.5-0.4-6.8,0.4C169.8,73.1,165.3,74.3,159,76.2z M200.1,27.5 c-0.1-6.4-3.9-10.1-10.7-10.4c-7.2-0.4-12.8,3.5-13.4,9.1c0,0.5-0.1,1,0,1.5c0.2,2.1,1.4,3.4,3.4,3.7c1.8,0.3,3.2-0.7,4-2.3 c0.4-0.9,0.4-2,0.8-2.9c1-2.3,2.9-3.2,5.3-2.6c2.7,0.6,3,2.8,2.8,5.1c-0.3,2.6-2.2,4-3.9,5.6c-2.7,2.5-4,5.7-4.2,9.3 c-0.1,1.9,0.8,3.2,2.6,3.7c1.9,0.5,3.7-0.4,3.9-2.2c0.4-4.8,3.8-7.6,6.7-10.8C199.2,32.4,200.3,30,200.1,27.5z M192,54.4 c-0.3-2-1.5-3.5-4.1-3.5c-2.5,0-4.1,1.2-4.1,3.9c0,2.7,1.6,3.9,4,3.9C190.2,58.8,191.8,57.6,192,54.4z"/> <path class="st3" d="M46.8,214.1c0.2,14.1-1.2,15,15.4,14.9c34.6-0.2,69.3-0.1,103.9-0.1c9.7,0,10.8-1.1,10.8-10.9 c0-1.3,0.1-2.7,0.1-4c8.2,1.3,16.3,2.5,24.5,3.9c3.3,0.6,6.5,1.2,9.7,2.3c2.5,0.9,6.3,1.5,6.3,4.8c-0.1,2.9-3.6,3.6-6.1,4.4 c-7,2.2-14.2,3.4-21.4,4.4c-34.4,4.4-68.9,4.9-103.5,3.8c-24.1-0.8-48.4-1.5-72-7.7c-3.2-0.8-7.8-1.5-7.9-4.9c0-3.9,4.8-4.3,8-5.2 c9.3-2.8,18.8-3.7,28.4-4.9C44.3,214.8,45.5,214.4,46.8,214.1z"/> <path class="st4" d="M175.6,100c-42.5,0-84.9,0-127.4,0c0.6-0.6,1-1.4,1.7-1.7c5.2-2.2,7-6.2,6-11.5c-0.5-3.1,0.8-3.9,3.9-3.9 c34.8,0.1,69.6,0.1,104.3,0.1c1.6,0,4.5-0.8,3.8,2.2C166.2,92.5,170.4,96.4,175.6,100z M93,88.3c0.2,1.3,0,3.3,2.3,3.4 c1.6,0.1,1.8-1.4,1.4-2.5c-0.6-1.6-0.1-4.2-2.3-4.4C92.9,84.7,93,86.7,93,88.3z"/> <path class="st5" d="M9.7,44.8c-1.5,2.3,1.1,2.8,1.6,4.2c0.3,0.8,0.8,1.6,0.2,2.3c-0.8,1-1.7,0.5-2.7,0c-3.7-1.9-6.2-4.8-8.3-8.3 c-0.5-0.9-1-1.8-0.1-2.7c0.7-0.7,1.6-0.4,2.3,0.1c1.7,1.5,3.3,2.7,6,1.8C10.1,41.9,10,43.8,9.7,44.8z"/> <path class="st5" d="M113.5,24c-1.6-0.5-4,0.5-4.6-1.8c-0.4-1.9,1.5-1.9,2.8-1.6c1.6,0.4,4.1-0.6,4.7,1.7 C116.8,24.1,114.9,23.9,113.5,24z"/> <path class="st5" d="M93.8,73.3c0.2,1.7,0.1,3.4-1.3,3.2c-2.7-0.4-1.6-3.2-2.2-4.9c-0.4-1.1-0.1-2.8,1.3-2.6 C94.5,69.3,92.8,72.3,93.8,73.3z"/> <path class="st5" d="M101.1,66.2c-0.4,1.7-1.6,1.9-2.7,1.4c-1.7-0.7-4.6,0.4-4.8-2.3c-0.2-1.7,1.9-1.5,3.1-1.2 C98.3,64.4,100.5,64,101.1,66.2z"/> <path class="st5" d="M30.3,29.2c-1.7,0.4-3.3,0.5-3.3-0.9c0-2.6,2.5-2,4.1-2.3c1.2-0.2,3.3-0.8,3.3,1 C34.4,29.9,31.4,28.4,30.3,29.2z"/> <path class="st5" d="M55.3,37.7c0.4-0.8,0.9-1.8,1.8-1.3c2.1,1.1,3.7,2.8,4.3,5.1c0.2,0.6-0.8,1.7-1.7,1.2 C57.7,41.6,56.2,39.9,55.3,37.7z"/> <path class="st5" d="M49.9,30.2c-0.2,1.1-0.9,1.9-1.6,1.6c-2-1-4.6-1.2-5.4-3.7c-0.3-0.9,0.7-1.5,1.6-1.3 C46.7,27.3,48.8,28.1,49.9,30.2z"/> <path class="st5" d="M100.8,25.5c-1.3,1.4-2.5,3.5-4.8,4.1c-0.9,0.2-1.5-0.9-1.1-1.7c0.8-2.1,2.4-3.6,4.5-4.3 C100.2,23.3,101,23.9,100.8,25.5z"/> <path class="st5" d="M129.9,30.2c0,1.2-0.6,2-1.5,1.7c-2.2-0.8-3.7-2.6-4.5-4.7c-0.3-0.9,0.5-1.7,1.4-1.4 C127.7,26.4,128.9,28.4,129.9,30.2z"/> <path class="st5" d="M19.6,32.7c-1.2,2-2.9,3.5-5.1,4.3c-0.9,0.3-1.8-0.5-1.5-1.3c0.8-2.3,2.8-3.5,4.9-4.4 C18.9,30.8,19.4,31.7,19.6,32.7z"/> <path class="st5" d="M93.1,39.9c-0.5,1.6,0.4,4.3-2.3,4.7c-1.4,0.2-1.5-1.5-1.2-2.6c0.5-1.7-0.6-4.4,2.2-4.8 C93.4,36.9,93.1,38.7,93.1,39.9z"/> <path class="st5" d="M72.5,52.6c0,1.2-0.7,1.9-1.5,1.6c-2.2-0.8-3.9-2.4-4.7-4.6c-0.3-0.7,0.7-1.7,1.5-1.4 C69.9,49,71.4,50.8,72.5,52.6z"/> <path class="st5" d="M88.9,56.7c0.3-1.3-0.7-3.5,1.4-3.6c2.5,0,1.6,2.4,1.7,3.8c0.1,1.3,0.8,3.6-1.3,3.6 C88.3,60.6,89.2,58.2,88.9,56.7z"/> <path class="st5" d="M113.7,63.9c1.6,0,3.3-0.3,3,1.3c-0.4,2.6-3.2,1.7-4.9,2.4c-1.2,0.5-2.8,0-2.5-1.3 C109.8,63.8,112.5,64.7,113.7,63.9z"/> <path class="st5" d="M80.4,58.1c1.7,1.2,4.4,1.3,5.3,3.7c0.3,0.9-0.8,1.6-1.5,1.4c-2.1-0.7-4.6-1.1-5.4-3.6 C78.5,58.8,79.4,58.2,80.4,58.1z"/> <path class="st5" d="M129.8,56.7c-1.1,1.7-2.1,3.9-4.6,4.4c-0.9,0.2-1.7-0.7-1.2-1.6c1-2,2.2-4.1,4.6-4.7 C129.4,54.6,130,55.5,129.8,56.7z"/> <path class="st5" d="M130.8,43.4c0.3-1.4-0.8-3.8,1.7-3.7c2,0.1,1.5,2.2,1.4,3.6c-0.1,1.4,0.8,3.8-1.7,3.7 C130.1,46.9,131.1,44.7,130.8,43.4z"/> <path class="st0" d="M148.9,120.9c-0.1,8.1-0.2,16.3-0.3,24.4c-0.2,21.2-15.8,37.2-36.2,37.2c-20.4,0-36.1-16.1-36.3-37.2 c-0.1-8.1-0.2-16.3-0.3-24.4c1.3-1.4,0.5-3.2,0.8-4.8c0.3-2.1,1.3-3.5,3.5-3.3c2,0.1,2.8,1.5,3.1,3.3c0.3,1.6-0.6,3.4,0.8,4.8 c0,10-0.8,20,0,29.8c0.9,10.6,7.3,18.1,17,22.2c10.4,4.3,20.5,3.1,29.5-4c7-5.6,10.7-12.9,10.6-22c-0.1-8.6-0.2-17.3-0.2-25.9 c1.3-1.4,0.5-3.2,0.7-4.8c0.3-1.8,1-3.2,3-3.3c2.3-0.1,3.2,1.2,3.5,3.3C148.4,117.8,147.6,119.5,148.9,120.9z"/> <path class="st4" d="M84,120.9c-1.3-1.4-0.5-3.2-0.8-4.8c-0.3-1.8-1-3.2-3.1-3.3c-2.3-0.1-3.2,1.2-3.5,3.3 c-0.2,1.6,0.6,3.4-0.8,4.8c-2.7-2.2-3.7-5-2.6-8.4c0.9-2.6,2.8-4.1,5.4-4.5c3.2-0.5,5.9,0.6,7.5,3.7C88,115.3,86.9,118.4,84,120.9z "/> <path class="st4" d="M148.9,120.9c-1.3-1.4-0.5-3.2-0.7-4.8c-0.3-2.1-1.3-3.4-3.5-3.3c-2,0.1-2.8,1.5-3,3.3 c-0.2,1.6,0.6,3.4-0.7,4.8c-2.9-2.4-4-5.3-2.5-8.8c1.2-2.9,3.6-4.3,6.7-4.2c2.9,0.1,5.1,1.5,6.2,4.2 C152.8,115.6,151.8,118.6,148.9,120.9z"/> <path class="st0" d="M200.1,27.5c0.3,2.5-0.9,4.8-2.7,6.9c-2.9,3.2-6.3,5.9-6.7,10.8c-0.1,1.8-1.9,2.7-3.9,2.2 c-1.8-0.5-2.7-1.8-2.6-3.7c0.2-3.6,1.4-6.8,4.2-9.3c1.7-1.6,3.6-3.1,3.9-5.6c0.2-2.3,0-4.4-2.8-5.1c-2.4-0.6-4.3,0.3-5.3,2.6 c-0.4,0.9-0.4,2-0.8,2.9c-0.8,1.7-2.2,2.6-4,2.3c-2-0.3-3.2-1.6-3.4-3.7c0-0.5,0-1,0-1.5c0.6-5.7,6.2-9.5,13.4-9.1 C196.2,17.5,200,21.1,200.1,27.5z"/> <path class="st0" d="M192,54.4c-0.2,3.1-1.8,4.4-4.2,4.4c-2.4,0-4.1-1.3-4-3.9c0-2.7,1.6-3.9,4.1-3.9C190.4,51,191.7,52.4,192,54.4 z"/> <path class="st5" d="M93,88.3c0.1-1.6-0.1-3.6,1.4-3.4c2.1,0.3,1.7,2.8,2.3,4.4c0.4,1.1,0.2,2.6-1.4,2.5C93,91.5,93.2,89.6,93,88.3 z"/> </g> </svg>

                                <div class=" empty-cart-message">
                                    {{ __('shop::app.checkout.cart.empty') }}
                                </div>

                                <a
                                    class="fs16 mt15  remove-decoration continue-shopping"
                                    href="{{ route('shop.home.index') }}">

                                    <button type="button" class="theme-btn remove-decoration">
                                        {{ __('shop::app.checkout.cart.continue-shopping') }}
                                    </button>
                                </a>
                            </div>
                            @endif


                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $cart]) !!}
                    </div>


                </section>
            </div>
            @if ($cart)

                    @include ('shop::products.view.cross-sells')

            @endif
        </div>
    </script>

    <script type="text/javascript" id="cart-template">
        (() => {
            Vue.component('cart-component', {
                template: '#cart-template',

                data: function () {
                    return {
                        isMobileDevice: this.isMobile(),
                    }
                },

                methods: {
                    removeLink(message) {
                        if (! confirm(message)) {
                            event.preventDefault();
                        }
                    }
                }
            })
        })();
    </script>
@endpush