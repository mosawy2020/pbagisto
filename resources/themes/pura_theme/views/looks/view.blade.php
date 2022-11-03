@extends('shop::layouts.master')

@section('page_title')
  {{-- {{ $page->page_title }} --}}
  looks
@endsection


@section('head')
  {{-- @isset($page->meta_title)
    <meta name="title" content="{{ $page->meta_title }}" />
  @endisset

   @isset($page->meta_description)
    <meta name="description" content="{{ $page->meta_description }}" />
  @endisset

  @isset($page->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}" />
  @endisset --}}
@endsection



@section('content-wrapper')
  <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
      <li class="breadcrumb-item"><a href="/">دليل الاطلالات</a></li>
      <li class="breadcrumb-item active">اطلالة</li>
    </ol>
  </nav>
  <div class="single-look-wrapper">
    <h1 class="main-title">اطلالة</h1>
    <div class="brands">
        <h3>المشتركين في صانعي الإطلالة</h3>
        
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
