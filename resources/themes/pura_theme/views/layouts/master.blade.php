<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        {{-- title --}}
        <title>@yield('page_title')</title>

        {{-- meta data --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url()->to('/') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        {!! view_render_event('bagisto.shop.layout.head') !!}

        {{-- for extra head data --}}
        @yield('head')

        {{-- seo meta data --}}
        @yield('seo')

        {{-- fav icon --}}
        @if ($favicon = core()->getCurrentChannel()->favicon_url)
            <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('/themes/pura_theme/assets/images/static/v-icon.png') }}" />
        @endif

        {{-- all styles --}}
        @include('shop::layouts.styles')
    </head>
@php
$pageName = str_replace('.', '-',   Route::currentRouteName() );
@endphp
    <body class="@if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction === 'rtl') rtl @else ltr @endif  {{ $pageName == 'shop-home-index' ? 'home-page' : 'inner-pages'}} {{ $pageName }} @yield('body_class')" >
        {!! view_render_event('bagisto.shop.layout.body.before') !!}


        {{-- main app --}}
        <div id="app">
            <product-quick-view v-if="$root.quickView"></product-quick-view>

            <div class="main-container-wrapper">

                @section('body-header')
                    {{-- top nav which contains currency, locale and login header --}}
                    @include('shop::layouts.top-nav.index')

                    {!! view_render_event('bagisto.shop.layout.header.before') !!}

                        {{-- primary header after top nav --}}
                        @include('shop::layouts.header.index')

                    {!! view_render_event('bagisto.shop.layout.header.after') !!}

                    <div class="main-content-wrapper col-12 no-padding">

                        {{-- secondary header --}}
                        <header class="row velocity-divide-page vc-header header-shadow active">

                            {{-- mobile header --}}
                            <div class="vc-small-screen container">
                                @include('shop::layouts.header.mobile')
                            </div>

                            {{-- desktop header --}}
                            @include('shop::layouts.header.desktop')

                        </header>

                        <div class="main-wrapper">
                            <div class="row col-12 remove-padding-margin">
                                <sidebar-component
                                    main-sidebar=true
                                    id="sidebar-level-0"
                                    url="{{ url()->to('/') }}"
                                    category-count="{{ $velocityMetaData ? $velocityMetaData->sidebar_category_count : 10 }}"
                                    add-class="category-list-container pt10">
                                </sidebar-component>

                                <div class="col-12 no-padding content" id="home-right-bar-container">
                                    <div class="container-right row no-margin col-12 no-padding">
                                        {!! view_render_event('bagisto.shop.layout.content.before') !!}

                                            @yield('content-wrapper')

                                        {!! view_render_event('bagisto.shop.layout.content.after') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @show


                    {!! view_render_event('bagisto.shop.layout.full-content.before') !!}

                        @yield('full-content-wrapper')

                    {!! view_render_event('bagisto.shop.layout.full-content.after') !!}

            </div>

            {{-- overlay loader --}}
            <velocity-overlay-loader></velocity-overlay-loader>

            <go-top bg-color="#4d2379"></go-top>
            <notification
                notif-title="{{ __('admin::app.notification.notification-title', ['read' => 0]) }}"
                view-all="{{ route('admin.notification.index') }}"
                title="{{ __('admin::app.notification.title-plural') }}"
                view-all-title="{{ __('admin::app.notification.view-all') }}"
                read-all-title="{{ __('admin::app.notification.read-all') }}"
                api-key="{{ env('FIREBASE_API_KEY') }}"
                auth-domain="{{ env('FIREBASE_AUTH_DOMAIN') }}"
                project-id="{{ env('FIREBASE_PROJECT_ID') }}"
                storage-bucket="{{ env('FIREBASE_STRORAGE_BUCKET') }}"
                messaging-sender-id="{{ env('FIREBASE_MESSAGING_SENDER_ID') }}"
                app-id="{{ env('FIREBASE_APP_ID') }}"
                vapid-key="{{ env('FIREBASE_VAPIDKEY') }}"
                token-url="{{route("admin.notifications.device_token.store")}}"
                notification-request-title="{{ __('velocity::app.notifications.notification_request_title') }}"
                notifiction-accept="{{ __('velocity::app.notifications.notifiction_accept') }}"
                notifiction-cancel="{{ __('velocity::app.notifications.notifiction_cancel') }}"
                locale-code={{ core()->getCurrentLocale()->code }}

                >

                <div class="notifications">
                    <div class="dropdown-toggle">
                        <i class="icon icon-bell align-vertical-top"  style="margin-left:0px"></i>
                    </div>
                </div>

            </notification>
        </div>

        {{-- footer --}}
        @section('footer')
            {!! view_render_event('bagisto.shop.layout.footer.before') !!}

                @include('shop::layouts.footer.index')

            {!! view_render_event('bagisto.shop.layout.footer.after') !!}
        @show

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        {{-- alert container --}}
        <div id="alert-container"></div>

        {{-- all scripts --}}
        @include('shop::layouts.scripts')
    </body>
</html>
