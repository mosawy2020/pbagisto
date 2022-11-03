@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.login-form.page-title') }}
@endsection

@section('content-wrapper')
    <div class="auth-content form-container">

        {!! view_render_event('bagisto.shop.customers.login.before') !!}

            <div class="container">
                <div class="auth-page-wrapper">
                    <div class="row">
                        <div class="col-md-6 no-bg-column">
                            <div class="heading">
                                <h1 class="fs24 fw6">
                                    {{ __('velocity::app.customer.login-form.customer-login')}}
                                </h1>
                                
        

                            </div>
                            <div class="body ">
                                {{-- <div class="form-header">
                                    <h3 class="fw6">
                                        {{ __('velocity::app.customer.login-form.registered-user')}}
                                    </h3>
        
                                    <p class="fs16">
                                        {{ __('velocity::app.customer.login-form.form-login-text')}}
                                    </p>
                                </div> --}}
        
                                <form
                                    method="POST"
                                    action="{{ route('customer.session.create') }}"
                                    @submit.prevent="onSubmit">
        
                                    {{ csrf_field() }}
        
                                    
        
                                    <div class="form-group" :class="[errors.has('email') ? 'has-error' : '']">
                                        <label for="email" class="mandatory label-style">
                                            {{ __('shop::app.customer.login-form.email') }}
                                        </label>
        
                                        <input
                                            type="text"
                                            class="form-style"
                                            name="email"
                                            v-validate="'required|email'"
                                            value="{{ old('email') }}"
                                            data-vv-as="&quot;{{ __('shop::app.customer.login-form.email') }}&quot;" />
        
                                        <span class="control-error" v-if="errors.has('email')" v-text="errors.first('email')"></span>
                                    </div>
        
                                    <div class="form-group" :class="[errors.has('password') ? 'has-error' : '']">
                                        <label for="password" class="mandatory label-style">
                                            {{ __('shop::app.customer.login-form.password') }}
                                        </label>
        
                                        <input
                                            type="password"
                                            class="form-style"
                                            name="password"
                                            id="password"
                                            v-validate="'required'"
                                            value="{{ old('password') }}"
                                            data-vv-as="&quot;{{ __('shop::app.customer.login-form.password') }}&quot;" />
                                        <div class="show-pass">
                                            <input type="checkbox" onclick="myFunction()" id="shoPassword" class="show-password"> 
                                            <label for="shoPassword">{{ __('shop::app.customer.login-form.show-password') }}</label>  
                                        </div>
                                        <span class="control-error" v-if="errors.has('password')" v-text="errors.first('password')"></span>
        
                                        <a href="{{ route('customer.forgot-password.create') }}" class=" forget-password">
                                            {{ __('shop::app.customer.login-form.forgot_pass') }}  
                                        </a>
        
                                        <div class="mt10">
                                            @if (Cookie::has('enable-resend'))
                                                @if (Cookie::get('enable-resend') == true)
                                                    <a href="{{ route('customer.resend.verification-email', Cookie::get('email-for-resend')) }}">{{ __('shop::app.customer.login-form.resend-verification') }}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
        
                                    <div class="form-group">
        
                                        {!! Captcha::render() !!}
        
                                    </div>
                                    <div class="text-center">
                                        <input class="theme-btn" type="submit" value="{{ __('shop::app.customer.login-form.button_title') }}">
                                    </div>
                                    {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}
        
                                    {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
        
                                    
        
                                </form>
                            </div>

                        </div>
                        <div class="col-md-6 with-bg-column">

                            <div class="heading">
                                <div class="new-customer-wrapper">
                                    <img class="logo lazyload"
                                    src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/pura_theme/assets/images/logo-text.png') }}"
                                    alt="" />
                                    <h2 class="new-here"> {{ __('velocity::app.customer.login-form.new-customer')}}</h2>
                                    <p class="new-cutomer-text">{{ __('velocity::app.customer.signup-form.form-sginup-text') }}</p>
                                    
                                </div>
                                <a href="{{ route('customer.register.index') }}" class="btn-new-customer">
                                    <button type="button" class="theme-btn light">
                                        {{ __('velocity::app.customer.login-form.sign-up')}}
                                    </button>
                                </a>
                            </div>

                        </div>                                              
                    </div>
                </div>
            </div>

        {!! view_render_event('bagisto.shop.customers.login.after') !!}
    </div>
@endsection

@push('scripts')

{!! Captcha::renderJS() !!}

<script>
    $(function(){       
        $(":input[name=email]").focus();
    });

        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    
    </script>

@endpush



