{{-- {{ dd($product) }} --}}
<div class="product-single-page product-bundle-page ">
  <div class="product-breadcrumb">
    <div class="container">
{{--      {{ Breadcrumbs::render('product', $product) }}--}}
    </div>
  </div>
  {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}
  <div class="container">
    <section class="product-detail">
      <div class="layouter">
        <product-view>
          {{-- form-container --}}
          <div class="">
            @csrf()

            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

            <div class="row">
              {{-- product-gallery --}}
              <div class="top col-12">
                @include ('shop::products.view.gallery' , ['type' => 'slider'])
              </div>

              {{-- right-section --}}
              <div class="bottom col-12">
                {{-- product-info-section --}}
                <div class="product-info-wrapper">
                  <div class="info">
                    <div class="main-header">
                      <h2 class="truncate">{{ $product->name }}</h2>
                      <div class="full-short-description">
                          {!! $product->short_description !!}
                      </div>
                    </div>

                    {{-- @if ($total)
                      <div class="reviews col-lg-12">
                        <star-ratings push-class="mr5" :ratings="{{ $avgStarRating }}"></star-ratings>

                        <div class="reviews">
                          <span>
                            {{ __('shop::app.reviews.ratingreviews', [
                                'rating' => $avgRatings,
                                'review' => $total,
                            ]) }}
                          </span>
                        </div>
                      </div>
                    @endif --}}

                    {{-- @include ('shop::products.view.stock', ['product' => $product]) --}}

                    <div class="price">
                      <div>
                        <i class="price-icon">
                          <!-- Generator: Adobe Illustrator 25.2.3, SVG Export Plug-In  -->
                          <svg enable-background="new 0 0 26.1 28.1" version="1.1" viewBox="0 0 26.1 28.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path class="st0" d="m5.7 24.5 1.5 3.2c0.2 0.4 0.3 0.4 0.6 0.2l6-2.8c0.7-0.3 0.7-0.3 1.2 0.2 0.2 0.2 0.3 0.3 0.4 0.3s0.2-0.1 0.4-0.3l10-10c0.2-0.2 0.3-0.3 0.3-0.4s-0.1-0.2-0.3-0.4l-12-12c-0.1-0.1-0.2-0.1-0.3-0.1l-2 0.3c-1.3 0.3-2.5 0.5-3.7 0.7-0.2 0-0.4 0-0.5-0.2-0.9-1-1.8-1.8-2.8-2.4-0.7-0.4-1.6-0.8-2.6-0.8-0.8 0-1.3 0.5-1.4 1.3-0.1 0.4 0 0.9 0.2 1.4 0.3 1.1 1 2.2 2.2 3.4 0.2 0.2 0.2 0.4 0.1 0.6-0.7 1.2-1.3 2.4-2 3.6l-0.9 1.5c-0.1 0.2-0.1 0.3-0.1 0.4l0.2 0.3 0.3 0.6c0.2 0 0.4 0 0.5-0.1 0-0.1-0.1-0.3-0.2-0.4-0.1-0.3-0.1-0.5 0-0.8 0.7-1.2 1.3-2.3 1.9-3.5l0.9-1.6c0-0.1 0.1-0.2 0.2-0.2l0.2-0.2v0.3 0.1l-0.2 1.2c-0.3 1.7-0.5 3.3-0.8 4.9-0.1 0.3 0 0.5 0.2 0.8 2.2 2.1 4.3 4.3 6.5 6.4l4.1 4.1c0.1 0.1 0.2 0.2 0.2 0.3s-0.1 0.2-0.3 0.2c-2 0.9-3.8 1.8-5.6 2.6-0.1 0-0.2 0.1-0.3 0.1s-0.2-0.2-0.2-0.3c-1.4-3-2.8-6.1-4.3-9.1l-1.3-2.8c-0.1-0.2-0.1-0.3-0.2-0.3s-0.1 0-0.3 0.1l-0.2 0.1v0.1c1.5 3.2 3 6.3 4.4 9.4m-1.9-19.3-0.2 0.3c0 0.1-0.1 0.2-0.2 0.2s-0.2-0.1-0.2-0.1c-0.8-0.8-1.7-1.9-2.1-3.3-0.1-0.3-0.1-0.6-0.1-1 0.1-0.5 0.4-0.7 0.9-0.8 0.6 0 1.2 0.2 1.6 0.4 1.1 0.5 2.1 1.2 3.1 2.4v0.1l0.1 0.2-0.6 0.1c-0.5 0.1-0.9 0.2-1.4 0.2-0.2 0-0.3 0.1-0.4 0.3-0.1 0.3-0.3 0.7-0.5 1m0 8.1c-0.2-0.2-0.2-0.3-0.2-0.6 0.4-2.5 0.8-5.2 1.2-7.9 0-0.2 0.1-0.4 0.4-0.4 0.5-0.1 1.1-0.2 1.8-0.3 0.2 0 0.3 0 0.4 0.2 0.3 0.4 0.5 0.8 0.7 1.3 0 0.1 0.1 0.2 0 0.3 0.1 0.1-0.1 0.2-0.2 0.2-0.9 0.2-1.5 1-1.5 2 0 0.9 0.7 1.7 1.6 1.8 1.1 0.1 2-0.5 2.3-1.4s-0.2-1.9-1-2.3c-0.3-0.1-0.4-0.2-0.5-0.5-0.2-0.5-0.5-1.1-0.8-1.5l-0.1-0.2 0.6-0.1c0.3-0.1 0.6-0.1 1-0.2l1.2-0.2c0.8-0.1 1.6-0.3 2.4-0.4 0.3-0.1 0.5 0 0.7 0.2l11.3 11.3c0.1 0.1 0.2 0.2 0.2 0.3s-0.1 0.2-0.2 0.3l-9.3 9.3c-0.1 0.1-0.2 0.2-0.3 0.2s-0.2-0.1-0.3-0.2c-3.8-3.6-7.6-7.4-11.4-11.2m4.4-5.5c-0.2 0.2-0.4 0.2-0.7 0.2h-0.2s-0.1 0-0.2-0.1c-0.1 0-0.1-0.1 0-0.2 0.1-0.5 0.6-1 1.1-1.1h0.2c0.1 0.1 0.1 0.2 0.1 0.4 0 0.4-0.1 0.6-0.3 0.8m0.9-0.8v-0.2l0.2 0.1c0.4 0.3 0.6 0.7 0.5 1.3-0.1 0.5-0.4 1-1 1.1-0.1 0-0.3 0.1-0.4 0.1-0.4 0-0.8-0.2-1-0.5l-0.2-0.2h0.2c1.2-0.3 1.5-0.6 1.7-1.7"/>
                          </svg>

                        </i>
                        {!! $product->getTypeInstance()->getPriceHtml() !!}
                      </div>
                      <div class="actions">
                          @include ('shop::products.add-to-wishlist-compare-only', [
                            'form' => false,
                            'product' => $product,
                            'showCartIcon' => false,
                            'showCompare' => core()->getConfigData('general.content.shop.compare_option') == "1"
                                            ? true : false,
                        ])
                        <product-share
                          url="  {{ Request::url() }}"
                          title="{{ $product->name }}"
                        ></product-share>
                      </div>
                      {{-- @include ('shop::products.price', ['product' => $product]) --}}

                      @if (Webkul\Tax\Helpers\Tax::isTaxInclusive() && $product->getTypeInstance()->getTaxCategory())
                        <span>
                          {{ __('velocity::app.products.tax-inclusive') }}
                        </span>
                      @endif
                    </div>

                    @if (count($product->getTypeInstance()->getCustomerGroupPricingOffers()) > 0)
                      <div class="col-12">
                        @foreach ($product->getTypeInstance()->getCustomerGroupPricingOffers() as $offers)
                          {{ $offers }} </br>
                        @endforeach
                      </div>
                    @endif

                    {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                    {{-- @if ($product->getTypeInstance()->showQuantityBox())
                      <div class="col-12">
                        <quantity-changer quantity-text="{{ __('shop::app.products.quantity') }}"></quantity-changer>
                      </div>
                    @else
                      <input type="hidden" name="quantity" value="1">
                    @endif --}}

                    {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}


                    @include ('shop::products.view.bundle-options')


                  </div>


                  <div class="info-accordion">
                    <animated-accordion   active-index="0" class="animated-accordion">
                      {{-- product long description --}}
                      @include ('shop::products.view.description')


                      @include ('shop::products.view.attributes', [
                          'active' => false,
                      ])
                    </animated-accordion>
                  </div>

                  {{-- reviews count --}}

                    {{-- @include ('shop::products.view.reviews', ['accordian' => true]) --}}

                </div>
              </div>
            </div>
          </div>
        </product-view>
      </div>
    </section>
  </div>
  {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}

  <div class="related-products">
    @include('shop::products.view.related-products')
    @include('shop::products.view.up-sells')
  </div>
</div>
