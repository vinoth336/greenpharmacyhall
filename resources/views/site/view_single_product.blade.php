@extends('site.app')

@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid px-5 clearfix">
                <div class="row gutter-40 col-mb-80">
                    <div class="postcontent col-lg-9 order-lg-last">
                        <div class="single-product">
                            <div class="product">
                                <div class="row gutter-40">
                                    <div class="col-md-6">

                                        <div class="product-image">
                                            <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                                <div class="flexslider">
                                                    <div class="slider-wrap" data-lightbox="gallery">
                                                        @foreach($product->productImages as $productImage)
                                                            <div class="slide" data-thumb="{{ asset('web/images/product_images/thumbnails/' . $productImage->image)}}">
                                                                <a href="{{ asset('web/images/product_images/' . $productImage->image)}}" title="{{ $product->name }}" data-lightbox="gallery-item">
                                                                    <img src="{{ asset('web/images/product_images/' . $productImage->image)}}" alt="{{ $product->name }}">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sale-flash badge badge-success p-2">Sale!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 product-desc">
                                        <h3>{{ $product->name }}</h3>
                                        <div class="d-flex align-items-center justify-content-between">

                                            <div class="product-price">
                                                @if($product->discount_amount > 0)
                                                <del>₹ {{ $product->price }}</del>
                                                <ins>₹ {{ $product->discount_amount }}</ins>
                                            @else
                                                <ins>₹ {{ $product->price }}</ins>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="line"></div>

                                        <form class="cart mb-0 d-flex justify-content-between align-items-center"
                                            method="post" enctype='multipart/form-data'>
                                            <div class="quantity clearfix">
                                                <input type="button" value="-" class="minus">
                                                <input type="number" step="1" min="1" name="quantity" value="1" title="Qty"
                                                    class="qty" />
                                                <input type="button" value="+" class="plus">
                                            </div>
                                            <button type="submit" class="add-to-cart button m-0">Add to cart</button>
                                        </form>
                                        <div class="line"></div>
                                        {!! $product->description !!}



                                        <div
                                            class="si-share border-0 d-flex justify-content-between align-items-center mt-4">
                                            <span>Share:</span>
                                            <div>
                                                <a href="#" class="social-icon si-borderless si-facebook">
                                                    <i class="icon-facebook"></i>
                                                    <i class="icon-facebook"></i>
                                                </a>
                                                <a href="#" class="social-icon si-borderless si-whatsapp">
                                                    <i class="icon-whatsapp"></i>
                                                    <i class="icon-whatsapp"></i>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="w-100">
                            <h4>Related Products</h4>
                            <div class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false"
                                data-autoplay="5000" data-items-xs="1" data-items-md="2" data-items-lg="3"
                                data-items-xl="4">
                                <div class="oc-item">
                                    <div class="product">
                                        <div class="product-image">
                                            <a href="#"><img src="images/shop/dress/1.jpg" alt="Checked Short Dress"></a>
                                            <a href="#"><img src="images/shop/dress/1-1.jpg" alt="Checked Short Dress"></a>
                                            <div class="sale-flash badge badge-success p-2">50% Off*</div>
                                            <div class="bg-overlay">
                                                <div class="bg-overlay-content align-items-end justify-content-between"
                                                    data-hover-animate="fadeIn" data-hover-speed="400">
                                                    <a href="#" class="btn btn-dark mr-2"><i
                                                            class="icon-shopping-cart"></i></a>
                                                    <a href="include/ajax/shop-item.html" class="btn btn-dark"
                                                        data-lightbox="ajax"><i class="icon-line-expand"></i></a>
                                                </div>
                                                <div class="bg-overlay-bg bg-transparent"></div>
                                            </div>
                                        </div>
                                        <div class="product-desc center">
                                            <div class="product-title">
                                                <h3><a href="#">Checked Short Dress</a></h3>
                                            </div>
                                            <div class="product-price"><del>$24.99</del> <ins>$12.49</ins></div>
                                            <div class="product-rating">
                                                <i class="icon-star3"></i>
                                                <i class="icon-star3"></i>
                                                <i class="icon-star3"></i>
                                                <i class="icon-star3"></i>
                                                <i class="icon-star-half-full"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('site.side_filter')

                </div>
            </div>
        </div>
    </section>

@endsection
