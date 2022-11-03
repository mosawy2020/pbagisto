@php            
    if (isset($velocityMetaData)) {
        if (isset($velocityMetaData->footer_logo)) {
            $footer_logo = Storage::url($velocityMetaData->footer_logo);
        }
    }
@endphp

<a href="{{ route('shop.home.index') }}">
    <img
        src="{{ $footer_logo ? $footer_logo : asset('themes/pura_theme/assets/images/static/logo-text-white.png') }}"
        class="logo full-img" alt="" width="200" height="50" />
</a>