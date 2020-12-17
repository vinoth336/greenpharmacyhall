<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="{{ $siteInformation->site_name }}" />
    <meta name="description" content="{{ $siteInformation->meta_description }}" />
    <link rel="canonical" href="https://www.greenpharmacyhall.com" />
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="article:publisher" content="">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@GreenPharmacyHall">
    <meta name="twitter:site" content="@GreenPharmacyHall">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	<link
		href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&amp;display=swap"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('web/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('web/css/dark.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }} " type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/magnific-popup.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/custom.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/swiper.css') }}" type="text/css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/settings.css') }}" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/layers.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('web/include/rs-plugin/css/navigation.css') }}">
    <title>{{ $siteInformation->site_name }}</title>
    <script src="{{  asset('web/js/jquery.js') }}"></script>
</head>

<body class="stretched">
    <style>
        .float{
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
						<p class="mb-0 py-2 text-center text-md-left"><strong>Call:</strong> 1800-547-2145 |
							<strong>Email:</strong> <a href="http://themes.semicolonweb.com/cdn-cgi/l/email-protection"
								class="__cf_email__"
								data-cfemail="0960676f66496a68677f687a276a6664">[email&#160;protected]</a></p>
					</div>
					<div class="col-12 col-md-auto">
					</div>
				</div>
			</div>
		</div>
		<header id="header" class="full-header" data-logo-height="60" data-mobile-sticky=true data-mobile-sticky-logo-height="36" data-sticky-logo-height="36" data-menu-padding="32">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row">

						<div id="logo" style="border:none" >
							<a  href="{{ route('home') }}" class="standard-logo"
                                data-dark-logo="{{ asset('web/images/logo/' . $siteInformation->logo) }}">
                                <img src="{{ asset('web/images/logo/' . $siteInformation->logo) }}"
									alt="{{ config('app.name') }}" style="height: 60px !important;" ></a>
							<a href="index.html" class="retina-logo" data-dark-logo="">
                                <img src="{{ asset('web/images/logo/' . $siteInformation->logo) }}" alt="{{ config('app.name') }}" style="height: 37px !important;"></a>
						</div>
						<div class="header-misc">
                            <div id="top-search" class="header-misc-icon">
								<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i
										class="icon-line-cross"></i></a>
							</div>

							<div id="top-cart" class="header-misc-icon d-none d-sm-block">
								<a href="#" id="top-cart-trigger"><i class="icon-line-bag"></i><span
										class="top-cart-number">5</span></a>
								<div class="top-cart-content">
									<div class="top-cart-title">
										<h4>Shopping Cart</h4>
									</div>
									<div class="top-cart-items">
										<div class="top-cart-item">
											<div class="top-cart-item-image">
												<a href="#"><img src="images/shop/small/1.jpg"
														alt="Blue Round-Neck Tshirt" /></a>
											</div>
											<div class="top-cart-item-desc">
												<div class="top-cart-item-desc-title">
													<a href="#">Blue Round-Neck Tshirt with a Button</a>
													<span class="top-cart-item-price d-block">$19.99</span>
												</div>
												<div class="top-cart-item-quantity">x 2</div>
											</div>
										</div>
										<div class="top-cart-item">
											<div class="top-cart-item-image">
												<a href="#"><img src="images/shop/small/6.jpg"
														alt="Light Blue Denim Dress" /></a>
											</div>
											<div class="top-cart-item-desc">
												<div class="top-cart-item-desc-title">
													<a href="#">Light Blue Denim Dress</a>
													<span class="top-cart-item-price d-block">$24.99</span>
												</div>
												<div class="top-cart-item-quantity">x 3</div>
											</div>
										</div>
									</div>
									<div class="top-cart-action">
										<span class="top-checkout-price">$114.95</span>
										<a href="car" class="button button-3d button-small m-0">View Cart</a>
									</div>
								</div>
							</div>
						</div>
						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100">
								<path
									d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
								</path>
								<path d="m 30,50 h 40"></path>
								<path
									d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
								</path>
							</svg>
						</div>

						@include('site.navbar')
					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
        </header>

        @yield('content')

        @include('site.footer')