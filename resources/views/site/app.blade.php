<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @php
        $isHomePage = $page ?? false;

        if($productDetail ?? false ) {
            $description = $productDetail->description ?? $productDetail->name . " Rs " . number_format($productDetail->actual_price, 2) ;
        } else {
            $description = $siteInformation->meta_description;
        }
        $description = strip_tags(Str::substr($description, 0, 200));
        $productImages = $productDetail->productImages ?? null;
        if($productImages == null) {
            $image = asset('web/images/logo/' . $siteInformation->logo);
        } else {
            if($productImages->count() > 0) {
                $image = asset('web/images/product_images/' . $productImages->first()->image);
            } else {
                $image = asset('web/images/logo/' . $siteInformation->logo);
            }
        }
    @endphp
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="{{ $siteInformation->site_name }}" />
    <meta name="description" content="{{ $description }}" />
    <link rel="canonical" href="{{ env('APP_URL') }}" />
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $productDetail->name ?? $siteInformation->site_name }}">
    <meta property="og:description" content="{{  $description  }}">
    <meta property="og:url" content="{{ $productDetail->productUrl ?? env('APP_URL') }}">
    <meta property="og:site_name" content="{{ $siteInformation->site_name }}">
    <meta property="og:image" content="{{ $image }}" >
    <meta property="og:type" content="website" >
    <meta property="article:publisher" content="">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@GreenPharmacyHall">
    <meta name="twitter:site" content="@GreenPharmacyHall">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link
		href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&amp;display=swap"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('web/style.css') }}?v={{ $version }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('web/css/dark.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/magnific-popup.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/custom.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/swiper.css') }}" type="text/css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/settings.css') }}" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/layers.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/navigation.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    @stack('css')
    <title>{{ $siteInformation->site_name }}</title>
    <script src="{{  asset('web/js/jquery.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body class="stretched">
    <style>
        .ws_float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:89px;
	right:22px;
	background-color:#25d366;
	color:#FFF;
	border-radius:50px;
	text-align:center;
    font-size:30px;
	box-shadow: 2px 2px 3px #999;
  z-index:100;
}

.my-float{
	margin-top: 9px;
}
        </style>

	<div id="wrapper" class="clearfix">

        <div id="top-bar">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-12 col-md-auto">
                        <p class="mb-0 py-2 text-center text-md-left"><strong>Call:</strong>
                            <a href="tel:{{ $siteInformation->phone_no }}">
                                {{ $siteInformation->phone_no }}
                            </a>
                                |
							<strong>Email:</strong> <a href="mailto:{{ $siteInformation->email_id }}">{{ $siteInformation->email_id }}</a></p>
					</div>
					<div class="col-12 col-md-auto">
					</div>
				</div>
			</div>
		</div>
		<header id="header" class="full-header" data-logo-height="60" data-mobile-sticky=true data-mobile-sticky-logo-height="30" data-sticky-logo-height="30" data-menu-padding="32">
			<div id="header-wrap" class="">
				<div class="container">
					<div class="header-row top-search-parent">

						<!-- Logo
						============================================= -->
						<div id="logo" class="mobile-width-100" style="border:none" >
							<a  href="{{ route('home') }}" class="standard-logo"
                                data-dark-logo="{{ asset('web/images/logo/' . $siteInformation->logo) }}">
                                <img src="{{ asset('web/images/logo/' . $siteInformation->logo) }}"
									alt="{{ config('app.name') }}" >
                            </a>
							<a href="{{ route('home') }}" class="retina-logo" data-dark-logo="">
                                <img src="{{ asset('web/images/logo/' . $siteInformation->logo) }}" alt="{{ config('app.name') }}" style="height: 37px !important;">
                            </a>
                        </div>

						<div class="header-misc mobile-ml-auto">

                            @guest
                            <div class="header-misc-icon d-sm-block d-md-none d-lg-none">
								<a href="#" class="menu-link user_login" data-toggle="modal" data-target=".show-login-modal" style="width: 96px;margin-top: -14px;font-weight: 480;text-transform: none;color: #27680e">
                                    Login
                                </a>
							</div>
                            @endguest

							<!-- Top Search
							============================================= -->
							<div id="top-search" class="header-misc-icon">
								<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
							</div><!-- #top-search end -->

							<!-- Top Cart
							============================================= -->
							<div id="top-cart" class="header-misc-icon d-sm-block">
								<a href="#" id="top-cart-trigger"><i class="icon-line-bag"></i><span
                                    class="top-cart-number" id="top-cart-number"></span>
                                </a>
								<div class="top-cart-content">
									<div class="top-cart-title">
										<h4>Cart</h4>
									</div>
									<div class="top-cart-items" id="top-cart-items">

									</div>
									<div class="top-cart-action">
										<span class="top-checkout-price" id="top-checkout-price"></span>
										<a href="{{ route('public.cart.checkout') }}" class="button button-3d button-small m-0">Checkout</a>
									</div>
								</div>
							</div><!-- #top-cart end -->

						</div>

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
						</div>

						<!-- Primary Navigation
						============================================= -->
						@include('site.navbar')
                        <!-- #primary-menu end -->

						<form class="top-search-form" action="/search" method="get" style="width: 250px;">
							<input type="text" name="q" id="product_search_box" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>
				</div>
			</div>
			<div class="header-wrap-clone" style="height: 100px;"></div>
		</header>
        @yield('content')

        @include('site.footer')
