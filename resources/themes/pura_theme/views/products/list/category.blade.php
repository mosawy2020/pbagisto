@foreach ($categories as $category)
  {{-- {{ dd($category) }} --}}
  <div class="col-md-4 col-12 category-col">
    <div class="category-card">
      <a href="{{ URL::to($category->url_path); }}" class="card-top">
        <div class="card-top-inner">
          <img src=" {{ Storage::url($category->category_icon_path) }}" alt="">
          <h3 class="title">{{ $category->name }}</h3>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 196.82 98.41">
          <g id="Layer_2" data-name="Layer 2">
            <g id="Layer_1-2" data-name="Layer 1">
              <path class="half-circle-path" d="M196.57,0A98.16,98.16,0,0,1,98.41,98.16,98.16,98.16,0,0,1,.25,0" />
            </g>
          </g>
        </svg>
      </a>
      <div class="card-bottom">
        <div class="desc">
          {!! substr(strip_tags($category->description), 0, 50) !!}

        </div>
      </div>
    </div>
  </div>
@endforeach
