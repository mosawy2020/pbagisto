@php
    $isRendered = false;
    $advertisementTwo = null;
    $isLazyLoad = ! isset($lazyload) ? true : ( $lazyload ? true : false );
@endphp

@if ($velocityMetaData && $velocityMetaData->advertisement)
    @php
        $advertisement = json_decode($velocityMetaData->advertisement, true);

        if (isset($advertisement[2]) && is_array($advertisement[2])) {
            $advertisementTwo = array_values(array_filter($advertisement[2]));
        }
    @endphp

    @if ($advertisementTwo)
        @php
            $isRendered = true;
        @endphp
{{-- {{ dd($advertisementTwo ) }} --}}
        <div class="container-fluid advertisement-two-container">
            <div class="row">
                @if (count($advertisementTwo) > 1)
                    @if ( isset($advertisementTwo[0]))
                        <a class="col-lg-9 col-md-12 no-padding">
                            <img
                                class="{{ $isLazyLoad ? 'lazyload' : '' }}"
                                @if (! $isLazyLoad) src="{{ Storage::url($advertisementTwo[0]) }}" @endif
                                data-src="{{ Storage::url($advertisementTwo[0]) }}" alt="" />
                        </a>
                    @endif

                    @if ( isset($advertisementTwo[1]))
                        <a class="col-lg-3 col-md-12 pr0">
                            <img
                                class="{{ $isLazyLoad ? 'lazyload' : '' }}"
                                @if (! $isLazyLoad) src="{{ Storage::url($advertisementTwo[1]) }}" @endif
                                data-src="{{ Storage::url($advertisementTwo[1]) }}" alt="" />
                        </a>
                    @endif


                @else

                    <a class="col-md-12 no-padding">
                        <img
                            class="{{ $isLazyLoad ? 'lazyload' : '' }}"
                            @if (! $isLazyLoad) src="{{ Storage::url($advertisementTwo[0]) }}" @endif
                            data-src="{{ Storage::url($advertisementTwo[0]) }}" alt="" />
                    </a>  

                @endif 
            </div>
        </div>
    @endif
@endif

@if (! $isRendered)
    <div class="container-fluid advertisement-two-container">
        <div class="row">
            <a class="col-lg-9 col-md-12 no-padding">
                <img
                    class="{{ $isLazyLoad ? 'lazyload' : '' }}"
                    @if (! $isLazyLoad) src="{{ asset('/themes/pura_theme/assets/images/toster.webp') }}" @endif
                    data-src="{{ asset('/themes/pura_theme/assets/images/toster.webp') }}" alt="" />
            </a>

            <a class="col-lg-3 col-md-12 pr0">
                <img
                    class="{{ $isLazyLoad ? 'lazyload' : '' }}"
                    @if (! $isLazyLoad) src="{{ asset('/themes/pura_theme/assets/images/trimmer.webp') }}" @endif
                    data-src="{{ asset('/themes/pura_theme/assets/images/trimmer.webp') }}" alt="" />
            </a>
        </div>
    </div>
@endif