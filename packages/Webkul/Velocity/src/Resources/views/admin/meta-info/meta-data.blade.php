@extends('admin::layouts.content')

@section('page_title')
    {{ __('velocity::app.admin.meta-data.title') }}
@stop

@php
$locale = core()->checkRequestedLocaleCodeInRequestedChannel();

$channel = core()->getRequestedChannelCode();

$channelLocales = core()->getAllLocalesByRequestedChannel()['locales'];

$social_data = json_decode($metaData->subscription_bar_content, true);
$apps_section = json_decode($metaData->home_page_apps, true);
$base_url = env('APP_URL').'/storage'.'/' ;
$footer_first_section=Json_decode($metaData->footer_first_section,true);
$footer_second_section=Json_decode($metaData->footer_second_section,true);
$footer_third_section=Json_decode($metaData->footer_third_section,true);

$usage_items=json_decode($metaData->usage_items,true);

$images = [
        // 4 => [],
        // 3 => [],
        // 2 => [],
        1 => [],
    ];

    $index = 0;

    foreach ($metaData->get('locale')->all() as $key => $value) {
        if ($value->locale == $locale) {
            $index = $key;
        }
    }

    $advertisement = json_decode($metaData->get('advertisement')->all()[$index]->advertisement, true);
    $advertisementJSON =isset($advertisement[1]) ? json_encode($advertisement[1],true)  : '{}' ;
    $advertisment_texts = json_decode($metaData->get('advertisment_texts')->all()[$index]->advertisment_texts, true);
    //dd($advertisementJSON);

$fixedContentBlocks = '{
    "about_section": {
        "type": "about",
        "name": "About Section",
        "content": "",
        "edit":"true",
        "label":"'. __('velocity::app.admin.home-content.labels.about_section') .'"
    },
    "advertisements": {
        "type": "advertisement",
        "name": "Ad Section",
        "select": "",
        "edit":"true",
        "label":"'. __('velocity::app.admin.home-content.labels.ad_section') .'"
    },
    "new_products": {
        "type": "new_products",
        "name": "New Products Section",
        "title": "",
        "subTitle": "",
        "link": "",
        "edit":"true",
        "label":"'. __('velocity::app.admin.home-content.labels.new_products') .'"
    },
    "featured_products": {
        "type": "featured_products",
        "name": "Featured Products Section",
        "edit":"false",
        "label":"'. __('velocity::app.admin.home-content.labels.featured_products') .'"
    },
    "apps_section": {
        "type": "apps_section",
        "name": "Apps Section",
        "edit":"false",
        "label":"'. __('velocity::app.admin.home-content.labels.app_section') .'"
    }
}';

$metaRoute = $metaData ? route('velocity.admin.store.meta-data', ['id' => $metaData->id]) : route('velocity.admin.store.meta-data', ['id' => 'new']);
@endphp

@push('css')
    <style>
        @media only screen and (max-width: 680px) {
            .content-container .content .page-header .page-title {
                float: left;
                width: 100%;
                margin-bottom: 12px;
            }

            .content-container .content .page-header .page-action button {
                position: absolute;
                right: 2px;
                top: 10px !important;
            }

            .content-container .content .page-header .control-group {
                margin-top: 16px !important;
                width: 100% !important;
                margin-left: 0px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <form method="POST" enctype="multipart/form-data" action="{{ $metaRoute }}" @submit.prevent="onSubmit">
            @csrf

            <div class="page-header">
                <div class="page-title">
                    <h1>{{ __('velocity::app.admin.meta-data.title') }}</h1>
                </div>

                <input type="hidden" name="locale" value="{{ $locale }}" />

                <input type="hidden" name="channel" value="{{ $channel }}" />

                <div class="control-group">
                    <select class="control" id="channel-switcher" name="channel">
                        @foreach (core()->getAllChannels() as $channelModel)
                            <option value="{{ $channelModel->code }}"
                                {{ $channelModel->code == $channel ? 'selected' : '' }}>
                                {{ core()->getChannelName($channelModel) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="control-group">
                    <select class="control" id="locale-switcher" name="locale">
                        @foreach ($channelLocales as $localeModel)
                            <option value="{{ $localeModel->code }}" {{ $localeModel->code == $locale ? 'selected' : '' }}>
                                {{ $localeModel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('velocity::app.admin.meta-data.update-meta-data') }}
                    </button>
                </div>
            </div>
            {{-- General section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.general') }}'" :active="true">
                <div slot="body">
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.activate-slider') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <label class="switch">
                            <input id="slides" name="slides" type="checkbox" class="control"
                                data-vv-as="&quot;slides&quot;" {{ $metaData && $metaData->slider ? 'checked' : '' }} />

                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.sidebar-categories') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="number" min="0" class="control" id="sidebar_category_count"
                            name="sidebar_category_count"
                            value="{{ $metaData ? $metaData->sidebar_category_count : '10' }}" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.header_content_count') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="number" min="0" class="control" id="header_content_count"
                            name="header_content_count" value="{{ $metaData ? $metaData->header_content_count : '5' }}" />
                    </div>




                    {{-- <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.about') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control" id="home_page_about" name="home_page_about">
                            {{ $metaData ? $metaData->home_page_about : '' }}
                        </textarea>
                    </div> --}}



{{--
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.text_ad') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control" id="text_ad" name="text_ad">
                            {{ $metaData ? $metaData->text_ad : '' }}
                        </textarea>
                    </div> --}}
                    {{-- <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.home-page-content') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea style="height: 400px;" class="control" rows="20" cols="14" name="home_page_content">
                            {{ $metaData ? $metaData->home_page_content : '' }}
                        </textarea>
                    </div> --}}

                    {{-- <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.product-policy') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control" id="product-policy" name="product_policy">
                            {{ $metaData ? $metaData->product_policy : '' }}
                        </textarea>
                    </div> --}}
                </div>


            </accordian>
            {{-- end General section --}}

            {{-- Contact section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.app-contact') }}'" :active="false">
                <div slot="body">


                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.phone') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="phone" name="phone"
                            value="{{ $metaData ? $metaData->phone : '' }}" />
                    </div>



                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.email') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="email" name="email"
                            value="{{ $metaData ? $metaData->email : '' }}" />
                    </div>

                    <h4>Social Media</h4>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.facebook') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="facebook" name="social_links[facebook]"
                            value="{{ isset($social_data['facebook']) ? $social_data['facebook'] : '' }}" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.twitter') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="twitter" name="social_links[twitter]"
                            value="{{ isset($social_data['twitter']) ? $social_data['twitter'] : '' }}" />
                    </div>


                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.snapchat') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="snapchat" name="social_links[snapchat]"
                            value="{{ isset($social_data['snapchat']) ? $social_data['snapchat'] : '' }}" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.tiktok') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="tiktok" name="social_links[tiktok]"
                            value="{{ isset($social_data['tiktok']) ? $social_data['tiktok'] : '' }}" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.instagram') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="text" class="control" id="instagram" name="social_links[instagram]"
                            value="{{ isset($social_data['instagram']) ? $social_data['instagram'] : '' }}" />
                    </div>
                </div>

            </accordian>
            {{-- end Contact section --}}

            {{-- Ads section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.images') }}'" :active="false">
                <div slot="body">
                    <div class="control-group image-with-textarea">
                        {{-- <label>{{ __('velocity::app.admin.meta-data.advertisement-four') }}</label> --}}

                        @php


                            //dd($advertisment_texts[1]['image_2']);

                        @endphp






                        <div class="control-group image-with-textarea">
                            {{-- <label>{{ __('velocity::app.admin.meta-data.advertisement-two') }}</label> --}}

                            @if (!isset($advertisement[1]) || !count($advertisement[1]))

                                <image-wrapper
                                    add-to-home-button-label="{{ __('velocity::app.admin.meta-data.add-section-btn-title') }}"
                                    :textarea="true" textarea-input="textarea[1]" input-name="images[1]"
                                    :images='[]' :text-old='[]'
                                    :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                                </image-wrapper>

                            @else
                                @foreach ($advertisement[1] as $index => $image)
                                    @php
                                        $images[1][] = [
                                            'id' => 'image_' . $index,
                                            'url' => Storage::url($image),
                                        ];
                                    @endphp
                                @endforeach


                                @foreach ($advertisment_texts[1] as $index => $text)
                                    @php
                                        $texts[1][] = [
                                            'ident' => $index,
                                            'text' => $text,
                                        ];
                                    @endphp
                                @endforeach





                                @endphp
                                <image-wrapper
                                    add-to-home-button-label="{{ __('velocity::app.admin.meta-data.add-section-btn-title') }}"
                                    :textarea="true" textarea-input="textarea[1]" input-name="images[1]"
                                    :images='@json($images[1])' :text-old='@json($texts[1])'
                                    :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                                </image-wrapper>
                            @endif
                            <span
                                class="control-info mt-10">{{ __('velocity::app.admin.meta-data.image-two-resolution') }}</span>
                        </div>




                    </div>
                </div>
            </accordian>
            {{-- end Ads section --}}

            {{-- Apps section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.apps_section') }}'" :active="false">

                <div slot="body">

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.apps_section') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control enable-wysiwyg" id="home_page_apps" name="home_page_apps[text]">
                        {!! isset($apps_section['text']) ? $apps_section['text'] : '' !!}
                        </textarea>
                    </div>
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.link_ios') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="url" min="0" class="control" name="home_page_apps[link_ios]"
                            value="{{ isset($apps_section['link_ios']) ? $apps_section['link_ios'] : '' }}" />
                    </div>


                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.link_android') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <input type="url" min="0" class="control" name="home_page_apps[link_android]"
                            value="{{ isset($apps_section['link_android']) ? $apps_section['link_android'] : '' }}" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.apps_image') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>
                        <image-single remove-button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}"
                            input-name="home_page_apps[image_1]"
                            :image="{ 'id': '1', 'url': '{{ isset($apps_section['image_1']) ? Storage::url($apps_section['image_1']) : '' }}' }"
                            :multiple="false"></image-single>
                    </div>
                </div>
            </accordian>
            {{-- end Apps section --}}


            {{-- Usage Steps section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.usage_section') }}'" :active="false">

                <div slot="body">

                    <div class="control-group">

                        <div class="control-group">
                            <label style="width:100%;">
                                {{ __('velocity::app.admin.meta-data.usage_title') }}
                                <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                            </label>

                                <textarea class="control enable-wysiwyg" id="usage_title" name="usage_title">
                                    {{ isset($metaData->usage_title) ? $metaData->usage_title : '' }}
                                </textarea>
                        </div>

                        <div class="control-group">
                            <label style="width:100%;">
                                {{ __('velocity::app.admin.meta-data.usage_description') }}
                                <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                            </label>

                            <textarea class="control" id="usage_steps" name="usage_description">
                                {!! isset($metaData->usage_description) ? $metaData->usage_description : '' !!}
                            </textarea>
                        </div>

                        <div class="control-group">
                            <label style="width:100%;">
                                {{ __('velocity::app.admin.meta-data.usage_link') }}
                                <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                            </label>

                            <input type="url" value="{{ isset($metaData->usage_link) ? $metaData->usage_link : '' }}" class="control" id="usage_link" name="usage_link">


                        </div>


                    </div>

                    @php

                        // dd($usage_items);


                    @endphp
                    <div class="control-group" style="width:100%;">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.usage_items') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>
                        <usage-wrapper base-url="{{ Storage::url("")  }}" :usage-items="{{ $usage_items ? json_encode($usage_items) : '[]' }}"  input-name="usage_items"  :multiple="true" ></usage-wrapper>
                    </div>
                </div>
            </accordian>
            {{-- Usage Steps section --}}


            {{-- footer section --}}
            <accordian :title="'{{ __('velocity::app.admin.meta-data.footer') }}'" :active="false">
                <div slot="body">
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.footer-logo') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <image-single remove-button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}"
                            input-name="footer_logo"
                            :image="{ 'id': '1', 'url': '{{Storage::url($metaData->footer_logo) }}' }"
                            :multiple="false"></image-single>
                    </div>
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.footer-bg') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>
                        <single-color-picker style="margin-top: 10px;" name="color" color="{{ $metaData->color ? $metaData->color : '#8fa0a3' }}"  ></single-color-picker>
                    </div>

                    <div class="row row-wrap">
                        {{-- first lisks --}}
                        <div class="col-12 col-lg-4">
                            <div class="control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-first-title') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>
                                <input class="control" id="footer_left_main_title"  value="{{  isset($footer_first_section['title'])? $footer_first_section['title']:''}}" name="footer_first_section[title]"/>

                            </div>
                            <div class="control-group links-repeater-control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-first-links') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>
                                @php
                                    $pages = app('Webkul\CMS\Repositories\CmsRepository')->getAll();

                                    foreach ($pages as $page) {
                                        $data[] = [
                                            'page_title' => $page->page_title,
                                            'url_key' => $page->url_key,
                                        ];
                                    }
                                @endphp
                                <links-wrapper  :links="{{ json_encode(isset($footer_first_section['links'])?$footer_first_section['links']:'') }}"    input-name="footer_first_section[links]"  :multiple="true" :pages="{{ json_encode($data) }}"></links-wrapper>
                            </div>
                        </div>



                        {{-- second lisks --}}
                        <div class="col-12 col-lg-4">
                            <div class="control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-second-title') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>
                                <input class="control" id="footer_left_main_title"   value="{{  isset($footer_second_section['title'])? $footer_second_section['title']:''}}"  name="footer_second_section[title]"/>

                            </div>
                            <div class="control-group links-repeater-control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-second-links') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>

                                <links-wrapper :links="{{ json_encode(isset($footer_second_section['links'])?$footer_second_section['links']:'') }}"      input-name="footer_second_section[links]" :multiple="true" :pages="{{ json_encode($data) }}"></links-wrapper>
                            </div>
                        </div>

                        {{-- third lisks --}}
                        <div class="col-12 col-lg-4">
                            <div class="control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-third-title') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>
                                <input class="control" id="footer_left_main_title" value="{{  isset($footer_third_section['title'])? $footer_third_section['title']:''}}" name="footer_third_section[title]"/>

                            </div>
                            <div class="control-group links-repeater-control-group">
                                <label style="width:100%;">
                                    {{ __('velocity::app.admin.meta-data.footer-third-links') }}
                                    <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                                </label>

                                <links-wrapper :links="{{ json_encode(isset($footer_third_section['links'])?$footer_third_section['links']:'') }}"     input-name="footer_third_section[links]" :multiple="true" :pages="{{ json_encode($data) }}"></links-wrapper>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.footer-left-content') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control" id="footer_left_content" name="footer_left_content">
                            {{ $metaData ? $metaData->footer_left_content : '' }}
                        </textarea>
                    </div> --}}

                    {{-- <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.footer-middle-content') }}
                            <span class="locale">[{{ $channel }} - {{ $locale }}]</span>
                        </label>

                        <textarea class="control" id="footer_middle_content" name="footer_middle_content">
                            {{ $metaData ? $metaData->footer_middle_content : '' }}
                        </textarea>
                    </div> --}}
                </div>
            </accordian>
            {{-- end footer section --}}

            {{-- Content section --}}
            <accordian title="home page content" :active="false">
                <div slot="body">
                    <input id="fixedContentBlocks" type="hidden" value="{{ $fixedContentBlocks }}"/>
                    <home-content
                        blade-content="{{ $metaData->home_page_content  ? $metaData->home_page_content : ''}}"
                        json-content="{{ $metaData->home_page_content_json ? $metaData->home_page_content_json : '[]' }}"
                        base_url="{{ $base_url }}"
                        :ads-json="{{ $advertisementJSON }}"
                        translation='{!! json_encode(  __('velocity::app.admin.home-content.input-titles'))!!}'
                    ></home-content>
                </div>
            </accordian>
            {{-- end Content section --}}
        </form>
    </div>
@stop

@push('scripts')
    @include('admin::layouts.tinymce')

    <script type="text/javascript">
        $(document).ready(function() {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea#home_page_content,textarea#footer_left_content,textarea#subscription_bar_content,textarea#footer_middle_content,textarea#product-policy,textarea#home_page_about,textarea#text_ad,textarea#home_page_apps , textarea.enable-wysiwyg',
                height: 400,
                width: "100%",
                image_advtab: true,
                valid_elements: '*[*]',
            });

            $('#channel-switcher, #locale-switcher').on('change', function(e) {
                $('#channel-switcher').val()

                if (event.target.id == 'channel-switcher') {
                    let locale = "{{ $channelLocales->first()->code }}";

                    $('#locale-switcher').val(locale);
                }

                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher')
                    .val();

                window.location.href = "{{ route('velocity.admin.meta-data') }}" + query;
            })
        });
    </script>
@endpush