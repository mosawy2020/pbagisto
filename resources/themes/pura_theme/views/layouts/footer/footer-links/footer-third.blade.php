<div class="col-lg-3 col-md-12 col-sm-12 footer-ct-content">

    @php


    if($velocityMetaData)
    {
     if(isset($velocityMetaData->footer_third_section))
     {
         $data=json_decode($velocityMetaData->footer_third_section,true);

         //dd($data['links']);
         //dd($data['title'])
     }


}
  @endphp


        @if ($velocityMetaData)
            @if(isset($velocityMetaData->footer_third_section))
                <h5>{{ $data['title'] }}</h5>
                @if(isset($data['links']))
                    <ul type="none">
                        @foreach ( $data['links'] as $link )
                            @php $link['link'] = $link['link']??""  @endphp
                            <li>
                                <a href="{{ (isset($link['type'])&& $link['type']== 'page') ? URL::to('page/'.$link['link']) :  URL::to($link['link']) }}">{{ $link['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
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