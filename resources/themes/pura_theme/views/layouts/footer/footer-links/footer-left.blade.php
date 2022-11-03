{{-- <div class="col-lg-3 col-md-12 col-sm-12 software-description">

    
    <div class="logo">
        <a href="{{ route('shop.home.index') }}" aria-label="Logo">
            @if ($logo = core()->getCurrentChannel()->logo_url)
                <img
                    src="{{ $logo }}"
                    class="logo full-img" alt="" width="200" height="50" />
            @else
                <img
                    src="{{ asset('themes/pura_theme/assets/images/static/logo-text-white.png') }}"
                    class="logo full-img" alt="" width="200" height="50" />
            @endif

        </a>
    </div>

    @if ($velocityMetaData)
        {!! $velocityMetaData->footer_left_content !!}
    @else
        {!! __('velocity::app.admin.meta-data.footer-left-raw-content') !!}
    @endif
</div> --}}

<div class="col-lg-3 col-md-12 col-sm-12 footer-ct-content">
	<div class="row">

        @if ($velocityMetaData)
            {!! DbView::make($velocityMetaData)->field('footer_middle_content')->render() !!}
        @else
            <div class="col-lg-6 col-md-12 col-sm-12 no-padding">
                <ul type="none">
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.about-us') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.customer-service') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.whats-new') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.contact-us') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 no-padding">
                <ul type="none">
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                        {{ __('velocity::app.admin.meta-data.footer-middle.order-and-returns') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.payment-policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.shipping-policy') }}
                        </a>
                    </li>
                    <li>
                        <a href="https://webkul.com/about-us/company-profile/">
                            {{ __('velocity::app.admin.meta-data.footer-middle.privacy-and-cookies-policy') }}
                        </a>
                    </li>
                </ul>
            </div>
        @endif
	</div>
</div>