@if (($velocityMetaData && $velocityMetaData->subscription_bar_content) ||
    core()->getConfigData('customer.settings.newsletter.subscription'))
  <div class="col-lg-3 col-md-12 col-sm-12 footer-rt-content">
    <div class="newsletter-subscription">
      <h3 class="newsletter-title">{{ __('shop::app.footer.subscribe-title') }}</h3>
      <h4 class="newsletter-desc">{{ __('shop::app.footer.subscribe-newsletter') }}</h4>
      <div class="newsletter-wrapper ">
        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
          <div class="subscribe-newsletter">
            <div class="form-container">
              <form action="{{ route('shop.subscribe') }}">
                <div class="subscriber-form-div">
                  <div class="control-group">
                    <input type="email" name="subscriber_email" class="control subscribe-field"
                      placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                      aria-label="Newsletter" required />

                    <button class="theme-btn subscribe-btn fw6">
                      {{-- {{ __('shop::app.subscription.subscribe') }} --}}
                      <!-- Generator: Adobe Illustrator 25.2.3, SVG Export Plug-In  -->
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0px" y="0px" width="10px" height="10.2px" viewBox="0 0 10 10.2"
                        style="overflow:visible;enable-background:new 0 0 10 10.2;" xml:space="preserve">
                        <g>
                          <path class="st0"
                            d="M0.3,0c2.5,1.2,5,2.6,7.5,3.8c0.6,0.3,1.3,0.6,1.9,1C9.9,4.9,9.9,4.9,10,5.1c0,0.2-0.1,0.3-0.2,0.4
                            C9.4,5.6,9,5.9,8.5,6.1c-2.7,1.4-5.3,2.7-8,4.1c-0.1,0-0.2,0.1-0.3,0.1C0.1,10.2,0,10.1,0,10c0-0.2,0-0.3,0.1-0.4
                            c0.3-1.2,0.5-2.3,0.8-3.5C0.9,6,0.9,6,0.9,6C1.5,5.9,2,5.8,2.5,5.7c0.6-0.1,1.2-0.2,1.8-0.3c0.4-0.1,0.9-0.2,1.3-0.2
                            c0,0,0.1,0,0.1,0c0,0,0,0-0.1,0C5,5,4.4,4.9,3.8,4.8C3.2,4.7,2.6,4.6,2,4.5C1.7,4.4,1.3,4.3,0.9,4.3c-0.1,0-0.1,0-0.1-0.1
                            C0.6,3,0.3,1.7,0,0.5c0-0.1,0-0.2,0-0.4C0.1,0.1,0.2,0,0.3,0C0.3,0,0.3,0,0.3,0z" />
                        </g>
                      </svg>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        @endif
      </div>
    </div>
    <div class="contact-wrapper row">
      <div class="contact-info col-lg-6">
        <div class="content-info-wrapper">
          <i class="icon-contact"></i>
          <a href="tel:{!! $velocityMetaData->phone !!}">
            @if ($velocityMetaData && $velocityMetaData->phone)
              {!! $velocityMetaData->phone !!}
            @endif
          </a>
        </div>
      </div>
      @if ($velocityMetaData && $velocityMetaData->subscription_bar_content)
        @include('velocity::layouts.particals.social-media', [
            'social' => json_decode($velocityMetaData->subscription_bar_content),
        ])
      @endif


      @php
        $social_data = json_decode($velocityMetaData->subscription_bar_content, true);
        
      @endphp
    </div>
  </div>
@endif
