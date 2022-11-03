<div>
    <h3>
        <a href="{{ route('shop.home.index') }}" class="homelink">
            {{ __('imagegallery::app.view.home') }}
        </a>
        &nbsp;>&nbsp;&nbsp;
        {{ __('imagegallery::app.view.image_gallery') }}
    </h3>
    <div class="heading">
        <h3>{{ __('imagegallery::app.view.image_gallery') }}</h3>
    </div>
</div>

<?php
$cou = 0;
?>
 @foreach ($managegalleries as $key1 => $category)

<div class="slidercontainer">
    @foreach ($category->image_name as $key2 => $image)
    
    <div class="slideindex slideindex{{$cou}} fades">
        <div class="product-card">
            <div class="product-image">
                <a href="{{ route('imagegallery.shop.image',$category->id) }}">
                    <img src="{{asset("storage/".$image->image) }}" style="width: 224px; height: 215px;" />
                </a>
            </div>
            <div class="product-information">           
                <div class="product-name">
                    <span>
                        {{$category->gallery_title}} ({{count($category->image_name)}})
                    </span>
                </div>
            </div>
        </div>
    </div>
        
    @endforeach
</div>
<?php
    $cou++;
?>
@endforeach 