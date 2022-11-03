@extends('shop::layouts.master')

@section('page_title')
  {{-- {{ $page->page_title }} --}}
  looks
@endsection

@section('body_class', 'body-with-banner')
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
  <div class="looks-page-wrapper">
    <div class="page-banner">
      <img class="lazyload" data-src="https://i.imgur.com/LSt1E9P.png" alt="" width="20" height="20" />
    </div>
    <div class="looks-list-container">
      <looks-component url="https://jsonplaceholder.typicode.com/albums"></looks-component>
    </div>
  </div>
@endsection

@push('scripts')
  <script type="text/x-template" id="looks-template">
    <div>
      <shimmer-component v-if="isLoading" shimmer-count="1"></shimmer-component>
      <template v-else-if="looks.length > 0">
        <div v-for="look in looks" class="looks-item">        
          <div class="desc">
            <div class="container">
              <h2>@{{ look.title }}</h2>
              <div class="content">             
                نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. نبذة قصيرة عن الإطلالة .. 
              </div> 
            </div>
          </div>
          <div class="img">
              <img class="lazyload" :data-src="look.thumbnailUrl" alt="" width="500" height="300" />
          </div>
          <a class="theme-btn" :href="look.url">@{{ detailsText }}</a>
        </div>
        <button class="load-more theme-btn" type="button" @click="loadMore">
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
        detailsText:{
          type: String,
          required: false,
          default: 'Look Details'
        },
        loadMoreText:{
          type: String,
          required: false,
          default: 'Load More'
        }
      },

      data: function() {
        return {
          looks: [],
          page:1,
          isLoading:true,
          isLoadingMore:false
        };
      },

      mounted: function() {
        this.getLooks()
      },

      methods: {
        getLooks() {
          // let countriesEndPoint = `${this.$root.baseUrl}/api/countries?pagination=0`;
          this.$http.get(`${this.url}/${this.page}/photos`)
            .then(response => {
              this.looks = [...this.looks, ...response.data]
              this.isLoading = false
              this.isLoadingMore= false
            })
            .catch(function(error) {});
        },
        loadMore(){
          this.isLoadingMore = true
          this.page++;
          this.getLooks() 
        }
      },

      computed: {

      }


    })
  </script>
@endpush
