@php
    $isRendered = false;
    $advertisementOne = null;
@endphp

@if ($velocityMetaData && $velocityMetaData->advertisement)
    @php
        $advertisement = json_decode($velocityMetaData->advertisement, true);
        if (isset($advertisement[1])) {
            $advertisementOne = $advertisement[1];
        }
        $advertisment_texts = json_decode($velocityMetaData->get('advertisment_texts')->all()[1]->advertisment_texts, true)[1];
    @endphp

    @if ($advertisementOne)
        @php
            $isRendered = true;
            // dd($advertisment_texts)
        @endphp
        {{-- {{ dd($advertisment_texts["image_".$value]) }} --}}

        <div class="container-fluid advertisement-one">       
            <div
                class="single-advertisment"
                style="background-image: url('{{ Storage::url($advertisementOne[$value]) }}')">
                
                <div class="advertisment-conetnt">
                    <div class="container">
                        {!!  $advertisment_texts["image_".$value] !!}
                    </div>
                </div>                
            </div>                
        </div>
    @endif
@endif

@if (! $isRendered)
    {{-- <div class="container-fluid advertisement-one">
        <div class="row">
            <div class="col offers-lt-panel bg-image"></div>

            <div class="col offers-ct-panel">

                <div class="row pb10">
                    <div class="col-12 offers-ct-top"></div>
                </div>

                <div class="row">
                    <div class="col-12 offers-ct-bottom"></div>
                </div>

            </div>

            <div class="col offers-rt-panel"></div>
        </div>
    </div> --}}

    <div class="container-fluid advertisement-one">
        <div class="row">
            <img src="{{ asset('themes/pura_theme/assets/images/placeholder2.svg') }}">

{{-- @foreach --}}
            {{-- <div
                class="col-12"
                style="background-image: url('{{ Storage::url($advertisementOne['image_1']) }}')">
                <h3>عنوان فرعي</h3>
                <h2>عنوان رئيسي</h2>
                <h3>عنوان فرعي</h3>
            </div> --}}

{{-- endforeach --}}
            
        </div>
    </div>
@endif