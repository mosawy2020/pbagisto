@php
    $orderStatusMessages = [
        'pending' => trans('admin::app.notification.order-status-messages.pending'),
        'canceled'=> trans('admin::app.notification.order-status-messages.canceled'),
        'closed' => trans('admin::app.notification.order-status-messages.closed'),
        'completed'=> trans('admin::app.notification.order-status-messages.completed'),
        'processing' => trans('admin::app.notification.order-status-messages.processing')
    ];
    $allLocales = core()->getAllLocales()->pluck('name', 'code');
@endphp
<header class="sticky-header">
  <div class="container">
    <div class="row remove-padding-margin velocity-divide-page">
      {{-- Left bar (user & cart & wishlist & compare) --}}
      <div class="left-bar col-md-4  searchbar actions-bar">
        <div class="left-wrapper actions">
          <div class="lang-wrapper currency">
            @include('velocity::layouts.top-nav.currency')
          </div>
          {{-- <div class="lang-wrapper">
            @include('velocity::layouts.top-nav.locale-currency')
          </div> --}}
        </div>
        <div class="left-wrapper actions">
{{-- @php dd(env('FIREBASE_MESSAGING_SENDER_ID')) @endphp --}}
          @include('velocity::layouts.top-nav.login-section')

          {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
          @include('shop::checkout.cart.mini-cart')
          {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}


          {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}
          @include('velocity::shop.layouts.particals.wishlist', ['isText' => true])
          {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}

          {!! view_render_event('bagisto.shop.layout.header.notifications.before') !!}

            {!! view_render_event('bagisto.shop.layout.header.notifications.after') !!}

          {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}
          @include('velocity::shop.layouts.particals.compare', ['isText' => true])
          {!! view_render_event('bagisto.shop.layout.header.compare.after') !!}

          <div class="lang-wrapper">
            @include('velocity::layouts.top-nav.locale-currency')
          </div>






        </div>
      </div>
      {{-- Center Bar (Logo) --}}
      <div class="center-bar col-md-4  text-center">
        <a class="navbar-brand" href="{{ route('shop.home.index') }}" aria-label="Logo">
          <img class="logo"
            src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/pura_theme/assets/images/logo-text.png') }}"
            alt="" />
        </a>
      </div>
      {{-- Right Bar --}}
      <div class="right-bar col-md-4 searchbar">
        <div class="contact-wrapper row">
          <div class="contact-info col-lg-6">
            <div class="content-info-wrapper">
              <i class="icon-contact"></i>
              <span>
                @if ($velocityMetaData && $velocityMetaData->phone)
                  {!! $velocityMetaData->phone !!}
                @endif
              </span>
            </div>
          </div>
          @if ($velocityMetaData && $velocityMetaData?->subscription_bar_content)
            @include('velocity::layouts.particals.social-media' , ['social'=> json_decode($velocityMetaData->subscription_bar_content)])
          @endif


          @php
            $social_data = json_decode($velocityMetaData?->subscription_bar_content, true);

          @endphp
        </div>
        <div class="search-bar-wrapper">
          @include('velocity::layouts.particals.search-bar')
        </div>

        {{-- <div class="col-lg-7 col-md-12 vc-full-screen">
                    <div class="left-wrapper">

                        {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}

                            @include('velocity::shop.layouts.particals.wishlist', ['isText' => true])

                        {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}

                        {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}

                            @include('velocity::shop.layouts.particals.compare', ['isText' => true])

                        {!! view_render_event('bagisto.shop.layout.header.compare.after') !!}

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}

                            @include('shop::checkout.cart.mini-cart')

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}
                    </div>
                </div> --}}

      </div>

    </div>

  </div>
</header>

@push('scripts')
  <script type="text/javascript">
    (() => {
      document.addEventListener('scroll', e => {
        scrollPosition = Math.round(window.scrollY);

        if (scrollPosition > 50) {
          document.querySelector('header').classList.add('header-shadow');
        } else {
          document.querySelector('header').classList.remove('header-shadow');
        }
      });
    })();
  </script>
@endpush
