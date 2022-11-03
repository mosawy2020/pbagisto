@extends('shop::layouts.master')

@section('page_title')
    {{ __('contact_lang::app.shop.title') }}
@endsection

@section('content-wrapper')
    <div class="auth-content form-container">
        <div class="container">
                    <div class="white-container">
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="fw6 title">                                    
                                    {{ __('contact_lang::app.shop.title') }}
                                </h1>

                                <p class="fs16 desc">
                                    {{ __('contact_lang::app.shop.desc') }}
                                    
                                </p>

                                <form class="cd-form floating-labels contact-us-form" action="{{ route('shop.contact.send-message') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="cd-label " for="cd-name">{{ __('contact_lang::app.datagrid.name') }}</label>
                                        <input class="text-input form-style" type="text" name="name" id="cd-name" required>
                                    </div> 

                                    <div class="form-group">
                                        <label class="cd-label" for="cd-email">{{ __('contact_lang::app.datagrid.email') }}</label>
                                        <input class="text-input  form-style" type="email" name="email" id="cd-email" required>
                                    </div> 

                                    {{-- <div class="form-group">
                                        <label class="cd-label" for="cd-mobile">Phone Number</label>
                                        <input class="text-input  form-style" type="number" name="phone" id="cd-mobile" required>
                                    </div>  --}}

                                    <div class="form-group">
                                        <label class="cd-label" for="cd-textarea">{{ __('contact_lang::app.datagrid.message') }}</label>
                                        <textarea class="message  form-control" name="message_body" rows="5" id="cd-textarea" required></textarea>
                                    </div>

                                    <div>
                                        <button type="submit" class="theme-btn btn-block p-3"><i class="fa fa-paper-plane"></i>{{ __('contact_lang::app.datagrid.send') }}</button>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-6">
                                <div class="contact-us-side">

                                    <img class="lazyload contact-img" data-src="{{ url('/themes/pura_theme/assets/images/static/contact-us.svg') }}">

                                    <div class="content-info-wrapper">
                                        <i class="icon-contact"></i>
                                        <a href="tel:{!! $velocityMetaData->phone !!}">
                                            @if ($velocityMetaData && $velocityMetaData->phone)
                                            {!! $velocityMetaData->phone !!}
                                            @endif
                                        </a>
                                        @if ($velocityMetaData && $velocityMetaData->subscription_bar_content)
                                            @include('velocity::layouts.particals.social-media', [
                                                'social' => json_decode($velocityMetaData->subscription_bar_content),
                                            ])
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        

                    </div>
                
            
        </div>
    </div>
@endsection