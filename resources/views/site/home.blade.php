@extends('site.app')
@section('content')
    <section id="slider" class="slider-element slider-parallax swiper_wrapper min-vh-30 min-vh-md-75"
        data-autoplay="5000" data-speed="650" data-loop="true" data-effect="fade" data-progress="true">
        <div class="slider-inner">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $key => $slider)
                        <div class="swiper-slide dark" @if ($key == 0)
                         style="cursor: pointer"   onclick="window.location.href='https://www.greenpharmacyhall.com/product/pulse-oximeter'"
                        @endif>
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

    @if($bestOffer->products->count() > 0)

    <section id="content" style="padding:8px;">
        <div class="content-wrap" style="padding: 10px 0px 0px 0px">
            <div class="row justify-content-center">
                <div class="col-md-12" style="margin-bottom: 10px">
                    <div class="fancy-title title-center title-border">
                        <h3>Best Offers</h3>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom: 10px;padding-left:40px;padding-right:40px;">
                    <div id="oc-products" class="owl-carousel products-carousel carousel-widget " data-pagi="true"
                        data-items-xs="1" data-items-sm="2" data-items-md="3" data-nav="true" data-items-lg="4">
                        @foreach($bestOffer->products as $product)
                        <div class="oc-item" style="padding-top: 20px; padding-bottom:20px">
                            <div class="product" id="product_{{ $product->slug }}">
                                <div class="product-image">
                                    @php
                                    $productImage = $product->productImages->first();
                                    $productImage = $productImage->image ?? 'no_image.png';
                                @endphp
                                    <a href="{{ route('view_product', $product->slug) }}"><img class="product_image" src="{{ asset('web/images/product_images/thumbnails/' . $productImage ) }}" alt="Checked Short Dress"></a>
                                    @if($product->discount_in_percentage > 0)
                                        <div class="sale-flash badge badge-success p-2">Discount {{ $product->discount_in_percentage }} %</div>
                                    @elseif($product->discount_amount)
                                        <div class="sale-flash badge badge-success p-2">Flat {{ $product->price - $product->discount_amount }} Off*</div>
                                    @endif
                                </div>
                                <div class="product-desc center">
                                    <div class="product-title">
                                        <h3><a href="{{ route('view_product', $product->slug) }}">{{ substr($product->name,0, 20) }}</a></h3>
                                    </div>
                                    <div class="product-price">
                                        <del>{{ $product->price }}</del>
                                        <ins>{{ $product->discount_amount }}</ins>
                                        <input type="hidden" class="product_price" value="{{ $product->actual_price }}" />
                                        <input type="hidden" class="product_name" value="{{ $product->name }}" />
                                    </div>
                                </div>
                                @if($product->isForSale())
                                    <div class="text-center">
                                        <a class="btn btn-info" onclick="Cart.add(this)" data-productid="{{ $product->slug }}"
                                            class="text-info" style="font-weight: 300 !important; font-size:18px;"
                                            class="" href="Javascript:void(0)">
                                            <p class="add_cart_container" style="margin-bottom: 1px; line-height: 1">
                                            <span class="add_cart_label">Add To Cart</span>
                                            <i class="icon-shopping-cart"></i>
                                            </p>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($banners->count() > 0)
    <section id="content" style="padding:8px;margin-top: 20px; padding-top: 10px;">
        <div class="content-wrap" style="padding: 0px;" >
            <div class="row align-items-stretch banner_row_section_bg" >
                @foreach ($banners as $banner )
                     <div class="col-md-3" style="margin-top: 20px; marging-bottom:20px;">
                        <a href="{{ $banner->url }}" class="grid-inner d-block" style="height: 300px; background: url('{{ asset('web/images/banners/' . $banner->banner) }}');background-size: cover">
                        </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <section id="content">
        <div class="content-wrap" style="padding-top: 0px">
            <div class="container clearfix">

                <div class="col-md-12" style="margin-bottom: 10px">
                    <div class="fancy-title title-center title-border">
                        <h3>Our Products</h3>
                    </div>
                </div>
                <div id="shop" class="shop row grid-container " data-layout="fitRows" style="margin-top:10px;">
                    @foreach ($allProducts as $product)
                        <div class="product col-lg-3 col-md-3 col-sm-6" id="product_{{ $product->slug }}">
                            <div class="grid-inner">
                                <div class="product-image">
                                    @forelse ($product->productImages as $productImage)
                                        <a href="{{ route('view_product', $product->slug) }}">
                                            <img class="product_image lazy"
                                                data-src="{{ asset('web/images/product_images/thumbnails/' . $productImage->image) }}"
                                                alt="{{ $product->name }}" loading="lazy">
                                        </a>
                                    @empty
                                        <a href="{{ route('view_product', $product->slug) }}">
                                            <img class="product_image lazy"
                                                data-src="{{ asset('web/images/product_images/thumbnails/no_image.png') }}"
                                                alt="{{ $product->name }}" loading="lazy">
                                        </a>
                                    @endforelse
                                    @if($product->isForSale())
                                        <div class="sale-flash badge badge-success p-2 text-uppercase d-md-inline-block d-lg-inline-block  d-none">
                                            @if($product->discount_in_percentage > 0)
                                                {{ $product->discount_in_percentage }} %
                                            @endif Sale!
                                        </div>
                                    @endif
                                </div>
                                <div class="product-desc">
                                    <div class="product-title min-h-30 max-h-30" style="text-overflow: ellipsis">
                                        <h3><a href="{{ route('view_product', $product->slug) }}"
                                               >{{ $product->name }}</a></h3>
                                    </div>
                                    <div class="product-price">
                                        <div class="text-center">
                                            @if ($product->discount_amount > 0)
                                                <del>₹ {{ $product->price }}</del>
                                                <ins>₹ {{ $product->discount_amount }}</ins>
                                            @else
                                                <ins>₹ {{ $product->price }}</ins>
                                            @endif
                                            <input type="hidden" class="product_price" value="{{ $product->actual_price }}" />
                                            <input type="hidden" class="product_name" value="{{ $product->name }}" />
                                        </div>
                                    </div>
                                    @if($product->isForSale())
                                        <div class="text-center">
                                            <a class="btn btn-info" onclick="Cart.add(this)" data-productid="{{ $product->slug }}"
                                                class="text-info" style="font-weight: 300 !important; font-size:18px;"
                                                class="" href="Javascript:void(0)">
                                                <p class="add_cart_container" style="margin-bottom: 1px; line-height: 1">
                                                <span class="add_cart_label">Add To Cart</span>
                                                <i class="icon-shopping-cart"></i>
                                                </p>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Shop Details ended-->
                <div class="clear bottommargin-sm"></div>
            </div>
            <div class="text-center mb-0">
                <a href="{{ route('public.product_list') }}" class="text-white margin-auto btn btn-success">
                    View More
                </a>
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
            <div class="section border-top-0 border-bottom-0 mb-0 p-0 bg-transparent footer-stick" style="display: none">
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
                                action="http://themes.semicolonweb.com/html/canvas/include/subscribe.php" method="post"
                                class="mb-0">
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

                        <?php
                        $enquiry_form_class = 'col-md-4';
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
                                    <li><i class="icon-time color"></i> <strong>Mondays-Fridays:</strong>
                                        {{ $siteInformation->working_hours_mon_fri }}</li>
                                    <li><i class="icon-time color"></i> <strong>Saturdays:</strong>
                                        {{ $siteInformation->working_hours_sat }}</li>
                                    <li><i class="icon-time text-danger"></i> <strong>Sundays:</strong>
                                        {{ $siteInformation->working_hours_sun }}</li>
                                </ul>
                                <i class="icon-time bgicon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-mb-50">
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('https://goo.gl/maps/12tyEdUZqGAfksbWA', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href="#"><i class="icon-map-marker2"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Get Direction<span class="subtitle">Check In<br>Google Map</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('tel:+91{{ $siteInformation->phone_no }}', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href=""><i class="icon-phone3"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Speak to<br> Us<span class="subtitle"><a style="text-decoration: none;color:#000"
                                            href="tel:+91{{ $siteInformation->phone_no }}"> (+91)
                                            {{ $siteInformation->phone_no }}</a></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('https://www.instagram.com/{{ $siteInformation->instagram_id }}/', '_blank')">
                        <div class="feature-box fbox-center fbox-bg fbox-plain">
                            <div class="fbox-icon">
                                <a href="#"><i class="icon-instagram"></i></a>
                            </div>
                            <div class="fbox-content">
                                <h3>Follow<br>Us<span class="subtitle">2.3M Followers</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3" style="cursor: pointer"
                        onclick="window.open('https://www.facebook.com/{{ $siteInformation->facebook_id }}', '_blank')">
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


@endsection
