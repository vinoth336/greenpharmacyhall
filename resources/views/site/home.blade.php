@extends('site.app')
@section('content')
    <section id="slider" class="slider-element slider-parallax swiper_wrapper min-vh-60 min-vh-md-100 include-header"
        data-autoplay="5000" data-speed="650" data-loop="true" data-effect="fade" data-progress="true">
        <div class="slider-inner">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide dark">
                            <div class="container">
                                @if ($slider->description)
                                    <div class="slider-caption slider-caption-center text-white">
                                        <h3 data-animate="fadeInUp">{{ $slider->description }}</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="swiper-slide-bg"
                                style="background-image: url('{{ asset('web/images/slider/' . $slider->slider) }}');">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
                <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
            </div>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <!-- Banner Section-->
                <div class="row align-items-stretch gutter-20 min-vh-60">
                    <div class="col-md-8">
                        <div class="row align-items-stretch gutter-20 h-100">
                            @foreach ($boxBanners as $boxBanner)
                                <div class="col-md-6 min-vh-25 min-vh-md-0">
                                    <a href="#" class="grid-inner d-block h-100"
                                        style="background-image: url('{{ asset('web/images/banners/' . $boxBanner->banner) }}');"></a>
                                </div>
                            @endforeach
                            <div class="col-md-12 min-vh-25 min-vh-md-0 pb-md-0">
                                <a href="#" class="grid-inner d-block h-100"
                                    style="background-image: url('{{ asset('web/images/banners/' . $verticalBanner->banner ?? null) }}');"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 min-vh-50">
                        <a href="#" class="grid-inner d-block h-100"
                            style="background-image: url('{{  asset('web/images/banners/' . $verticalWideBanner->banner ?? null) }}'); background-position: center top;"></a>
                    </div>
                </div>
                <!-- Banner Section Ended-->
                <div class="clear"></div>
                <!-- Shop Details started-->

                <div id="shop"  class="shop row grid-container gutter-30 " data-layout="fitRows" style="margin-top:10px;">
                    @foreach($allProducts as $product)
                        <div class="product col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="grid-inner">
                                <div class="product-image">
                                    @foreach($product->portfolioImages as $productImage)
                                        <a href="#"><img src="{{ asset('web/images/portfolio_images/' . $productImage->image)}}" alt="{{ $product->name }}"></a>
                                    @endforeach
                                    <div class="sale-flash badge badge-success p-2 text-uppercase">Sale!</div>
                                    <div class="bg-overlay">
                                        <div class="bg-overlay-content align-items-end justify-content-between"
                                            data-hover-animate="fadeIn" data-hover-speed="400">
                                            <a href="#" class="btn btn-dark mr-2"><i
                                                    class="icon-shopping-basket"></i>
                                            </a>
                                            <a href="include/ajax/shop-item.html" class="btn btn-dark"
                                                data-lightbox="ajax"><i class="icon-line-expand"></i>
                                            </a>
                                        </div>
                                        <div class="bg-overlay-bg bg-transparent"></div>
                                    </div>
                                </div>
                                <div class="product-desc">
                                    <div class="product-title">
                                        <h3><a href="#">{{ $product->name }}</a></h3>
                                    </div>
                                    <div class="product-price">
                                        @if($product->discount_amount > 0)
                                            <del>₹ {{ $product->price }}</del>
                                            <ins>₹ {{ $product->discount_amount }}</ins>
                                        @else
                                            <ins>₹ {{ $product->price }}</ins>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Shop Details ended-->
                <div class="clear bottommargin-sm"></div>


            </div>
            <div class="section mb-0">
                <div class="container">
                    <div class="row col-mb-50">
                        <div class="col-sm-6 col-lg-3">
                            <div class="feature-box fbox-plain fbox-dark fbox-sm">
                                <div class="fbox-icon">
                                    <i class="icon-thumbs-up2"></i>
                                </div>
                                <div class="fbox-content">
                                    <h3>100% Original</h3>
                                    <p class="mt-0">We guarantee you the sale of Original Brands.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="feature-box fbox-plain fbox-dark fbox-sm">
                                <div class="fbox-icon">
                                    <i class="icon-credit-cards"></i>
                                </div>
                                <div class="fbox-content">
                                    <h3>Payment Options</h3>
                                    <p class="mt-0">We accept Visa, MasterCard and American Express.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="feature-box fbox-plain fbox-dark fbox-sm">
                                <div class="fbox-icon">
                                    <i class="icon-truck2"></i>
                                </div>
                                <div class="fbox-content">
                                    <h3>Free Shipping</h3>
                                    <p class="mt-0">Free Delivery to 100+ Locations on orders above $40.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="feature-box fbox-plain fbox-dark fbox-sm">
                                <div class="fbox-icon">
                                    <i class="icon-undo"></i>
                                </div>
                                <div class="fbox-content">
                                    <h3>30-Days Returns</h3>
                                    <p class="mt-0">Return or exchange items purchased within 30 days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section border-top-0 border-bottom-0 mb-0 p-0 bg-transparent footer-stick">
                <div class="container clearfix">
                    <div class="row col-mb-50">
                        <div class="col-md-6 d-none d-md-flex align-self-end">
                            <img src="images/services/4.jpg" alt="Image" class="mb-0">
                        </div>
                        <div class="col-md-6 mb-5 subscribe-widget">
                            <div class="heading-block">
                                <h3><strong>GET 20% OFF*</strong></h3>
                                <span>Our App scales beautifully to different Devices.</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet cumque, perferendis
                                accusamus porro illo exercitationem molestias.</p>
                            <div class="widget-subscribe-form-result"></div>
                            <form id="widget-subscribe-form3"
                                action="http://themes.semicolonweb.com/html/canvas/include/subscribe.php"
                                method="post" class="mb-0">
                                <div class="input-group" style="max-width:400px;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="icon-email2"></i></div>
                                    </div>
                                    <input type="email" name="widget-subscribe-form-email"
                                        class="form-control required email" placeholder="Enter your Email">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="submit">Subscribe Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="content">
        <div id="contact_us" class="content-wrap " style="padding-top: 0px">
            <div class="container clearfix">
                <div class="row align-items-stretch col-mb-50 mb-0">
                    <div class="col-lg-6">
                        <div class="fancy-title title-border">
                            <h3>Send us an Email</h3>
                        </div>
                        <!-- Enquiry Form Start Here -->

                        <?php $enquiry_form_class = 'col-md-4';
                              $services = $servicesForEnquiries;
                        ?>
                        @include('site.enquiry_form', ['enquiry_form_class' => $enquiry_form_class] )

                        <!-- Enquiry Form Ended Here -->

                    </div>

                    <div class="col-lg-6 min-vh-50">
                        <div class="card topmargin overflow-hidden" style="border:none">
                            <div class="card-body">
                                <h4>Opening Hours</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit reprehenderit
                                    voluptates.</p>
                                <ul class="iconlist mb-0">
                                    <li><i class="icon-time color"></i> <strong>Mondays-Fridays:</strong> {{ $siteInformation->working_hours_mon_fri }}</li>
                                    <li><i class="icon-time color"></i> <strong>Saturdays:</strong> {{ $siteInformation->working_hours_sat }}</li>
                                    <li><i class="icon-time text-danger"></i> <strong>Sundays:</strong> {{ $siteInformation->working_hours_sun }}</li>
                                </ul>
                                <i class="icon-time bgicon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row col-mb-50">
                        <div class="col-sm-6 col-lg-3" style="cursor: pointer" onclick="window.open('https://goo.gl/maps/u86ebsZ7AeX54e7g9', '_blank')">
                            <div class="feature-box fbox-center fbox-bg fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="icon-map-marker2"></i></a>
                                </div>
                                <div class="fbox-content" >
                                    <h3>Get Direction<span class="subtitle">Check In<br>Google Map</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3" style="cursor: pointer" onclick="window.open('tel:+91{{ $siteInformation->phone_no }}', '_blank')">
                            <div class="feature-box fbox-center fbox-bg fbox-plain">
                                <div class="fbox-icon">
                                    <a href=""><i class="icon-phone3"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <h3>Speak to<br> Us<span class="subtitle"><a style="text-decoration: none;color:#000" href="tel:+91{{ $siteInformation->phone_no }}"> (+91) {{ $siteInformation->phone_no  }}</a></span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3" style="cursor: pointer" onclick="window.open('https://www.instagram.com/{{ $siteInformation->instagram_id }}/', '_blank')">
                            <div class="feature-box fbox-center fbox-bg fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="icon-instagram"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <h3>Follow<br>Us<span class="subtitle">2.3M Followers</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3" style="cursor: pointer" onclick="window.open('https://www.facebook.com/{{ $siteInformation->facebook_id }}', '_blank')">
                            <div class="feature-box fbox-center fbox-bg fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="icon-facebook2"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <h3>Follow<br>Us<span class="subtitle">2.3M Followers</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            // bind 'myForm' and provide a simple callback function
            $('#myForm').ajaxForm(function() {
                alert("Thank you for your comment!");
            });
        });

    </script>
@endsection
