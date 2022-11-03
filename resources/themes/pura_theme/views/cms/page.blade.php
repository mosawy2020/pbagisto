@extends('shop::layouts.master')

@section('page_title')
  {{ $page->page_title }}
@endsection

@section('body_class',  $page->image ? 'body-with-banner' : '')

@section('head')
  @isset($page->meta_title)
    <meta name="title" content="{{ $page->meta_title }}" />
  @endisset

  @isset($page->meta_description)
    <meta name="description" content="{{ $page->meta_description }}" />
  @endisset

  @isset($page->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}" />
  @endisset
@endsection



@php
$page_faqs= $page->faqs ? json_decode($page->translate( app()->getLocale())->faqs,true) : null;
// dd($page)

//$page->image
@endphp
@section('content-wrapper')
  <div class="cms-page-container">
    @if($page->image)
      <div class="page-banner">
        <img class="logo lazyload"
          data-src="{{ Storage::url($page->image) }}" alt=""
          width="20" height="20" />
      </div>
    @endif
    <div class="page-top-content">
      <div class="container">
        <h1 class="main-title">{{ $page->content_title  }}</h1>
        <h2>{{ __('admin::app.cms.pages.pura') }}</h2>
      </div>
    </div>
    <div class="page-main-content">
      <div class="container">
        {!! DbView::make($page)->field('html_content')->render() !!}
      </div>
    </div>
    <div class="page-tabs">
      <div class="container">
        {{-- {{ dd($page) }} --}}
        @if($page_faqs != null)
            @foreach ($page_faqs as $item )           
                <accordian-component title="{{ $item['title'] ?? $item['title']}}" :active="{{  $loop->index  == 0 ? 'true' : 'false'}}">
                    <div slot="body">
                        {{  $item['desc'] ?? $item['desc'] }}
                    </div>
                </accordian-component>
            @endforeach
        @endif
        
      </div>
    </div>

  </div>
@endsection

@push('scripts')
  <script type="text/x-template" id="accordian-template">

    <div
        :class="[
            'accordian',
            isActive ? 'active' : '',
            className,
            !isActive && hasError ? 'error' : ''
        ]"
        :id="id"
    >
        <div class="accordian-header" @click="toggleAccordian()">
            <slot name="header">
                <span>@{{ title }}</span>
                <i :class="['icon', iconClass]"></i>
            </slot>
        </div>

        <div class="accordian-content" ref="controls">
            <slot name="body"></slot>
        </div>
    </div>
</script>

  <script>
    Vue.component('accordian-component', {
      template: '#accordian-template',
      props: {
        title: String,
        id: String,
        className: String,
        active: Boolean,
        downIconClass: {
          type: String,
          default: "rango-arrow-down"
        },
        upIconClass: {
          type: String,
          default: "rango-arrow-up"
        }
      },

      data: function() {
        return {
          isActive: false,

          imageData: "",

          hasError: false
        };
      },

      mounted: function() {
        this.isActive = this.active;
      },

      methods: {
        toggleAccordian: function() {
          this.isActive = !this.isActive;
        },
      },

      computed: {
        iconClass: function() {
          return {
            [this.downIconClass]: !this.isActive,
            [this.upIconClass]: this.isActive
          };
        }
      }


    })
  </script>
@endpush
