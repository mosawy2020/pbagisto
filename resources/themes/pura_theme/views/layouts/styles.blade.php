{{-- preloaded fonts --}}
<link rel="preload" href="{{ asset('themes/pura_theme/assets/fonts/font-rango/rango.ttf') . '?o0evyv' }}" as="font" crossorigin="anonymous" />

{{-- bootstrap --}}
<link rel="stylesheet" href="{{ asset('themes/pura_theme/assets/css/bootstrap.min.css') }}" />

{{-- bootstrap flipped for rtl --}}
{{-- @if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction === 'rtl')
    <link href="{{ asset('themes/pura_theme/assets/css/bootstrap-flipped.css') }}" rel="stylesheet">
@endif --}}

{{-- mix versioned compiled file --}}
<link href="{{ asset('themes/pura_theme/assets/css/suggestion.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('themes/pura_theme/assets/css/image-gallery/imagegallery.css') }}" />
<link rel="stylesheet" href="{{ asset(mix('/css/velocity.css', 'themes/pura_theme/assets')) }}" />
<link rel="stylesheet" href="{{ asset(mix('themes/pura_theme/assets/css/app.css')) }}" />




{{-- extra css --}}
@stack('css')

{{-- custom css --}}
<style>
    {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
</style>
