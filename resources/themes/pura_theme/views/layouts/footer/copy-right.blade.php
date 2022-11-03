<div class="footer-copy-right">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="d-flex align-items-center justify-content-between">
          <img class="logo"
            src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/pura_theme/assets/images/logo-text.png') }}"
            alt="" />
          <span>
            @if (core()->getConfigData('general.content.footer.footer_content'))
              {!! core()->getConfigData('general.content.footer.footer_content') !!}
            @else
              {!! trans('admin::app.footer.copy-right') !!}
            @endif
          </span>
        </div>
      </div>
      <div class="col-12 col-md-6 text-right">
        @include('shop::layouts.footer.payment-delivery')
      </div>
    </div>
  </div>
</div>
