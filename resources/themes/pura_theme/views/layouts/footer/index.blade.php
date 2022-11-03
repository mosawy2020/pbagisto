@php
    if (isset($velocityMetaData)) {
        if (isset($velocityMetaData->color)) {
            $footer_color = $velocityMetaData->color;
        }
    }
@endphp
<div class="footer">
    <div class="footer-content" @if(isset($footer_color)) style="background-color: {{ $footer_color }}" @endif>
        @include('shop::layouts.footer.footer-links')

        {{-- @if ($categories)
            @include('shop::layouts.footer.top-brands')
        @endif --}}


    </div>
    <div class="footer-copyrights" @if(isset($footer_color))  style="background-color: {{ $footer_color }}" @endif>
        @if (core()->getConfigData('general.content.footer.footer_toggle'))
            @include('shop::layouts.footer.copy-right')
        @endif
    </div>
</div>
