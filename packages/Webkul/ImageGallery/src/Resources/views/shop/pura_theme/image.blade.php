@extends('shop::layouts.master')

@section('page_title')
  {{ $categories->first()->title }}
@endsection

@php
$opening_effect = core()->getConfigData('image.image.image_options.opening_effect');
$closing_effect = core()->getConfigData('image.image.image_options.closing_effect');
$caption = core()->getConfigData('image.image.image_options.caption');
$caption_type = core()->getConfigData('image.image.image_options.caption_type');
$caption_position = core()->getConfigData('image.image.image_options.caption_position');
$bg_effect = core()->getConfigData('image.image.image_options.background');
$cyclic = core()->getConfigData('image.image.image_options.cyclic');
$interval = core()->getConfigData('image.image.image_options.interval');
$img_border = core()->getConfigData('image.image.image_options.border');
$img_slide_count = core()->getConfigData('image.image.image_options.slidecount');
$img_control = core()->getConfigData('image.image.image_options.controls');
$brands = json_decode($categories->first()->brands, true);
$gallery_images = $categories->first()->image_name;
@endphp

@push('css')

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lg-fullscreen.min.css"
    integrity="sha512-JlgW3xkdBcsdFiSfFk5Cfj3sTgo3hA63/lPmZ4SXJegICSLcH43BuwDNlC9fqoUy2h3Tma8Eo48xlZ5XMjM+aQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lg-share.min.css"
    integrity="sha512-dOqsuo1HGMv5ohBl/0OIUVzkwFLF8ZmjhpZp2VT2mpH5UuOJXwtBhxxtbrrEIpvTDWm7mESg0JsEl4zkUGv/gw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lg-zoom.min.css"
    integrity="sha512-SGo05yQXwPFKXE+GtWCn7J4OZQBaQIakZSxQSqUyVWqO0TAv3gaF/Vox1FmG4IyXJWDwu/lXzXqPOnfX1va0+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lg-thumbnail.min.css"
    integrity="sha512-GRxDpj/bx6/I4y6h2LE5rbGaqRcbTu4dYhaTewlS8Nh9hm/akYprvOTZD7GR+FRCALiKfe8u1gjvWEEGEtoR6g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lightgallery.min.css"
    integrity="sha512-Szyqrwc8kFyWMllOpTgYCMaNNm/Kl8Fz0jJoksPZAWUqhE60VRHiLLJVcIQKi+bOMffjvrPCxtwfL+/3NPh/ag=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/css/lg-rotate.min.css"
    integrity="sha512-lENse+XF5kSp7h+shBUOqTCpGUNeomUR+2HI8j2wWWL48vjRyRoCoRFV01skx3iqDk151oRpJFeqxn2nc5Bd7A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content-wrapper')
{{-- {{dd($brands)}} --}}
{{-- {{dd($brands)}} --}}
  <div class="single-look-page-wrapper">
    <div class="container">
      <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
          <li class="breadcrumb-item"><a href="{{ URL::to('/') }}/gallery">{{ __('imagegallery::app.view.gallery') }}</a></li>
          <li class="breadcrumb-item active">{{ $categories->first()->title }}</li>
        </ol>
      </nav>
      <div class="single-look-wrapper">
        <h1 class="main-title">{{ $categories->first()->title }}</h1>
        <div class="brands">
          <h3>{{ __('imagegallery::app.view.brands') }}</h3>
          <brands-component></brands-component>
        </div>
      </div>
    </div>
    <div class="single-look-gallery">
      <div class="grid" id="lightgallery">
        @foreach ($gallery_images as $key => $image)
          <a href="{{ asset('storage/' . $image->image) }}" class="grid-item gallery-item">
            <img  class="lazyload" data-src="{{ asset('storage/' . $image->image) }}" title="{{$image->description}}" />
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{-- <script src="https://unpkg.com/packery@2/dist/packery.pkgd.min.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/lightgallery.min.js"
    integrity="sha512-FDbnUqS6P7md6VfBoH57otIQB3rwZKvvs/kQ080nmpK876/q4rycGB0KZ/yzlNIDuNc+ybpu0HV3ePdUYfT5cA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/plugins/fullscreen/lg-fullscreen.min.js"
    integrity="sha512-705ImNrRILAxWjuet0gwUMqQ249szpivFOpZilZeIMacaS/BcSQaGNE5UkfHKFNBzJaN2b4G4uzvjeoaNQFOKg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/plugins/share/lg-share.min.js"
    integrity="sha512-yEGrATBiy50yeZFbev13bZClHPp0J54MtYtgfLBpICRjx+7N+jw09DLOEYmZ6dotLTXFyhw1aEcJ5UwV4ihS9Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/plugins/thumbnail/lg-thumbnail.min.js"
    integrity="sha512-cavMj99wBO8HNDcMfXf1r6SGMFyrNYxq/Wle3vqeRNRHvlwvq2GRgwqQkPGxkXGXVa30WfF9bHEZmFK7T/Ya7g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/plugins/zoom/lg-zoom.min.js"
    integrity="sha512-5kOfZonUGdOM0k5LCWttgUTvxceTa3DCwYtH3alvvE+oULFgoIN11oMIoubI1HcOXOmGDuuMvi00Px0HwHZsaQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.5.0/plugins/rotate/lg-rotate.min.js"
    integrity="sha512-kL5j+xORkwH0MgFBuO30uHoDCxGQBnXJzmQsXCP/hlWKYj+wjqNh2kHvITLpCP4nuLbXVRWGkfmAg2cTANA51Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/x-template" id="brands-template">

    <div>
      <shimmer-component v-if="isLoading" shimmer-count="6"  :slides-per-page-xlg="6" :slides-per-page-lg="5"
      :slides-per-page-md="4" :slides-per-page-sm="3" :slides-per-page-xs="2"></shimmer-component>


      <carousel-component v-else navigation-enabled="hide" pagination-enabled="hide" class="brands-carousel"
        id="brands-carousel" :slides-count="{{ count($brands) }}" :slides-per-page-xlg="5" :slides-per-page-lg="5"
        :slides-per-page-md="4" :slides-per-page-sm="3" :slides-per-page-xs="2">
        @foreach ($brands as $key => $image)
          <slide slot="slide-{{ $loop->iteration - 1 }}">
            <div class="brand-item">
              <img class="lazyload"  data-src="{{ asset('storage/' . $image) }}"   />
            </div>
          </slide>
        @endforeach
      </carousel-component>
    </div>


    </script>

    <script>
        Vue.component('brands-component', {
            template: '#brands-template',

            data: function () {
                return {
                    'isLoading': true,

                }
            },

            mounted() {
              this.isLoading = false
            },
            methods: {

            }
        })
    </script>

  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      // var elem = document.querySelector('.grid');
      // var pckry = new Packery(elem, {
      //   // options
      //   itemSelector: '.grid-item',
      //   gutter: 0
      // });
      setTimeout(() => {
        lightGallery(document.getElementById('lightgallery'), {
          plugins: [lgZoom, lgShare, lgFullscreen , lgRotate , lgThumbnail],

        });
      }, 500);
    });
  </script>

@endpush
