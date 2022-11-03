

<div class="container">
    <h4 class="main-title">{!! $usage_title !!}</h4>
    <h5 class="main-desc">{{ $usage_description }}</h5>
    <div class="row">
        @foreach ( $usage_items as $item  )           
            <div class="col-4 usage-item-wrapper">
                <div class="usage-item">
                    <img class="image lazyload" data-src="{{ $item['image'] ? Storage::url($item['image']) : '' }}">
                    <h6 class="item-title">{{  $item['title']  }}</h6>
                    <div class="item-desc">
                        {{  $item['desc']  }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <div class="usage-extra">
            <p class="usage-text">{{ __('velocity::app.admin.meta-data.we_recommend') }}</p>
            <a href="#" class="primary-button d-inline-block">{{ __('velocity::app.admin.meta-data.policy_usage') }}</a> 
        </div>
    </div>
</div>