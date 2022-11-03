@extends('shop::layouts.master')

@section('page_title')
  {{-- {{ $page->page_title }} --}}
  looks
@endsection

@section('body_class', 'body-with-banner')


@push('css')
  <style>
    .slidercontainer {
      width: 20rem;
      height: 385px;
      display: inline-block;
    }

    .product-card {
      border: 5px solid #dedede;
      margin-left: 10px;
    }

    .product-information {
      text-align: center;
    }
  </style>
@endpush

@php

$group = Webkul\ImageGallery\Models\ManageGroup::first();

$banner = Storage::url($group->banner);

$banner_text = $group->banner_text;

//dd($banner);

// api route =https://puralens.store/gallery/gallery-all

@endphp

@section('content-wrapper')

  <div class="looks-page-wrapper">
    <div class="page-banner">
      <img class="lazyload" data-src="{{ $banner }}" alt="" width="20" height="20" />
      <div class="banner-text">{!! $banner_text !!}</div>
    </div>
    <div class="looks-list-container">
      <looks-component load-more-text="{{ __('imagegallery::app.view.load')  }}" details-text="{{ __('imagegallery::app.view.look_details') }}" public-path="{{ url()->to('/') }}" url="{{ url()->to('/') }}/gallery/gallery-all"></looks-component>
    </div>
  </div>


@endsection

@push('scripts')
  <script>
    var slideIndex = [];
    indexSlides();

    function indexSlides() {
      var loops = document.getElementsByClassName("slidercontainer");
      var num;
      for (num = 0; num < loops.length; num++) {
        slideIndex[num] = 0;
      }
    }

    showSlides();

    function showSlides() {
      var i;
      var loops = document.getElementsByClassName("slidercontainer");
      var num;

      for (num = 0; num < loops.length; num++) {
        var name = "slideindex" + num;
        var slides = document.getElementsByClassName(name);
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        slideIndex[num]++;
        if (slideIndex[num] > slides.length) {
          slideIndex[num] = 1
        }
        slides[slideIndex[num] - 1].style.display = "block";
      }
      setTimeout(showSlides, 2000);
    }
  </script>

<script type="text/x-template" id="looks-template">
    <div>
      <shimmer-component v-if="isLoading" shimmer-count="1" shimmer-count="1"  :slides-per-page-xlg="1" :slides-per-page-lg="1"
      :slides-per-page-md="1" :slides-per-page-sm="1" :slides-per-page-xs="1"></shimmer-component>
      <template v-else-if="looks.length > 0">
        <div v-for="look in looks" class="looks-item">
          <div class="desc">
            <div class="container">
              <h2>@{{ look.title }}</h2>
              <div class="content">
                @{{ look.description }}
              </div>
            </div>
          </div>
          <div class="img">
              <img class="lazyload" :data-src="look.images[0]" alt="" width="500" height="300" />
          </div>
          <a class="theme-btn" :href="`${publicPath}/gallery/gallery-group/${look.id}`">@{{ detailsText }}</a>
        </div>
        <button v-if="isMore" class="load-more theme-btn" type="button" @click="loadMore">
          <span v-if="isLoadingMore" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          @{{ loadMoreText }}
        </button>
      </template>
    </div>
</script>

  <script>
    Vue.component('looks-component', {
      template: '#looks-template',
      props: {
        url: {
          type: String,
          required: true
        },
        detailsText: {
          type: String,
          required: false,
          default: 'Look Details'
        },
        loadMoreText: {
          type: String,
          required: false,
          default: 'Load More'
        },
        publicPath:{
            type: String,
            required: true,
            default: ''
        }
      },

      data: function() {
        return {
          looks: [],
          page: 1,
          isLoading: true,
          isLoadingMore: false,
          isMore: true
        };
      },
      computed:{
        mainLink(){

        }

      },

      mounted: function() {
        this.getLooks()
      },

      methods: {
        getLooks() {
          // let countriesEndPoint = `${this.$root.baseUrl}/api/countries?pagination=0`;
          this.$http.get(`${this.url}?page=${this.page}`)
            .then(response => {
              console.log(response)
              this.looks = [...this.looks, ...response.data.data]
              if(response.data.links.next){
                this.page++;
                this.isMore = true
              }else{
                this.page = null
                this.isMore = false
              }

              this.isLoading = false
              this.isLoadingMore = false
            })
            .catch(function(error) {});
        },
        loadMore() {
            if(this.page){
                this.isLoadingMore = true
                this.getLooks()
            }
        }
      },

      computed: {

      }


    })
  </script>
@endpush
