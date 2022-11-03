{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="error-container" style="width: 100%; display: flex; justify-content: center;">
        hiiiii 503
        <div class="wrapper" style="display: flex; height: 60vh; width: 100%;
            justify-content: start; align-items: center;">

            <div class="error-box"  style="width: 50%">

                <div class="error-title" style="font-size: 100px;color: #5E5E5E">
                    {{ __('admin::app.error.in-maitainace') }}
                </div>

                <div class="error-messgae" style="font-size: 24px;color: #5E5E5E">
                    {{ core()->getCurrentChannel()->maintenance_mode_text ?: __('admin::app.error.right-back') }}
                </div>
            </div>

            <div class="error-graphic icon-404" style="margin-left: 10% ;"></div>

        </div>

    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        {{-- title --}}
        <title>@yield('page_title')</title>

        {{-- meta data --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url()->to('/') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        {{-- {!! view_render_event('bagisto.shop.layout.head') !!} --}}

        {{-- for extra head data --}}
        {{-- @yield('head') --}}

        {{-- seo meta data --}}
        {{-- @yield('seo') --}}

        {{-- fav icon --}}
        @if ($favicon = core()->getCurrentChannel()->favicon_url)
            <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('/themes/pura_theme/assets/images/static/v-icon.png') }}" />
        @endif

        {{-- all styles --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" integrity="sha512-YTL2qFiv2wZNnC764l1DD5zN6lYxDzJ89Ss6zj6YoYIzr6+zwjdVKM1sUR+971X3h7qWCa9cPUBXyYqhOqWWLQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @include('shop::layouts.styles')
    </head>

    <body class="comming-soon-page">

        <!-- Coming Soon -->
        <div class="coming-soon">
            <div class="inner-bg">
                <div class="container min-height">
                    <div class="row">
                        <div class="col-sm-12">
                        	<div class="logo wow fadeInDown">
                        		<h1>
                        			<a href="">Pura-Comming Soon</a>
                        		</h1>
                        	</div>
                            <h2 class="wow fadeInDown">Something <strong>AWESOME</strong> is in the works!</h2>

                            <h3 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="1s">
                                {{ core()->getCurrentChannel()->maintenance_mode_text ?: __('admin::app.error.right-back') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        
        
        <!-- Footer -->
        <footer>
	        <div class="container">
	            <div class="row">
	                <div class="col-sm-7 footer-copyright">
	                    <p>© All Rights Reserved 2022 · PURA</p>
	                </div>
	                <div class="col-sm-5 footer-social pull-right">
	                	<ul class="social-icon">
								<li><a href=""><i class="fa fa-linkedin-square"></i></a></li>
								<li><a href=""><i class="fa fa-facebook-square"></i></a></li>
								<li><a href=""><i class="fa fa-twitter-square"></i></a></li>
								<li><a href=""><i class="fa fa-youtube-square"></i></a></li>
							</ul> 
	                </div>
	            </div>
	        </div>
        </footer>
</div>

        <!-- Javascript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" integrity="sha512-jGR1T3dQerLCSm/IGEGbndPwzszJBlKQ5Br9vuB0Pw2iyxOy+7AK+lJcCC8eaXyz/9du+bkCy4HXxByhxkHf+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.1.18/jquery.backstretch.min.js" integrity="sha512-bXc1hnpHIf7iKIkKlTX4x0A0zwTiD/FjGTy7rxUERPZIkHgznXrN/2qipZuKp/M3MIcVIdjF4siFugoIc2fL0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>            
            jQuery(document).ready(function() {
                
                /*
                    Fullscreen background
                */
                $.backstretch("themes/pura_theme/assets/images/static/main-bg.png");
                new WOW().init();
                
            });
        </script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>
</html>
