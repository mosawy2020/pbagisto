
@php
    $isRendered = false;
    $advertisementOne = null;
    
@endphp
@if ($velocityMetaData && $velocityMetaData->home_page_apps) 

    @php
        if ($velocityMetaData && $velocityMetaData->home_page_apps){
          $data=json_decode($velocityMetaData->home_page_apps,true); 
          
        }
    @endphp
    {{-- {{ dd($data) }} --}}
<div class="apps-wrapper">
    <div class="container-fluid advertisement-one">       
        <div
            class="single-advertisment"
            style="background-image: url('{{ $data['image_1'] !== '' ?  Storage::url($data['image_1']) : '' }}')">
            
            <div class="advertisment-conetnt">
                <div class="container">
                    {!! $data['text'] !== ''  ? $data['text'] : '' !!}

                    <div class="apps-btns">
                        @if( $data['link_ios'] !== '')
                            <a href="{{ $data['link_ios'] }}" class="app-store" title="pp-store">
                            
                            </a>
                        @endif

                        @if( $data['link_android'] !== '')
                            <a href="{{ $data['link_android'] }}" class="google-play" title="google-play">
                            
                            </a>
                        @endif                       
                        
                    </div>
                </div>
            </div>                
        </div>                
    </div>

</div>
@endif

@if (! $isRendered)


@endif