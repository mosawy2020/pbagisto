@if ($velocityMetaData && $velocityMetaData->text_ad)                    
    
    {{-- <div class="col-sm-6">
        @include('velocity::layouts.top-nav.locale-currency')
    </div>

    <div class="col-sm-6">
        @include('velocity::layouts.top-nav.login-section')
    </div> --}}
    
  <header-top-offer text-data="{!! $velocityMetaData->text_ad !!}" ></header-top-offer>   
@endif    