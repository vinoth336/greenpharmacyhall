@extends('site.app')

@section('content')
    <section id="content">
        <div class="content-wrap">
            <div class="container-fluid clearfix">
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
                                                                    <img class="product_image" src="{{ asset('web/images/product_images/' . $productImage->image)}}" alt="{{ $product->name }}">
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
                                                <input type="hidden" class="product_price" value="{{ $product->actual_price }}" />
                                                <input type="hidden" class="product_name" value="{{ $product->name }}" />
                                                @if($product->discount_amount > 0)
                                                <del>₹ {{ $product->price }}</del>
                                                <ins>₹ {{ $product->discount_amount }}</ins>
                                            @else
                                                <ins>₹ {{ $product->price }}</ins>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="quantity display-inline-block">
                                            <input type="hidden" id="productName" value="{{ $product->slug }}" />
                                            <input type="button" value="-" class="minus">
                                            <input type="number" step="1" min="1" onchange="Cart.updateQty('.single-product', this)" onkeyup="Cart.updateQty('.single-product', this)" id="product_{{ $product->slug }}" data-productid="{{ $product->slug }}" value="1" title="Qty"
                                                class="qty" />
                                            <input type="button" value="+" class="plus">
                                        </div>
                                        <button type="button" class="add-to-cart button m-0" onclick="Cart.add(this, $('#product_{{ $product->slug }}').val())" data-productid="{{ $product->slug }}">Add to cart</button>
                                        <div class="line"></div>
                                        {!! $product->description !!}
                                        <div
                                            class="si-share border-0 d-flex justify-content-between align-items-center mt-4">
                                            <span>Share:</span>
                                            <div>
                                                <a target="_blank" class="social-icon si-borderless si-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ $product->productUrl }}" >
                                                    <i class="icon-facebook"></i>
                                                    <i class="icon-facebook"></i>
                                                </a>
                                                <a target="_blank" class="social-icon si-borderless si-whatsapp" href="https://web.whatsapp.com/send?text={{ $product->productUrl }}">
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
                    </div>
                    @include('site.side_filter')

                </div>

                <div class="line"></div>
                <div class="w-100">
                    <h4>Related Products</h4>
                    <div class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false"
                        data-autoplay="5000" data-items-xs="1" data-items-md="2" data-items-lg="3"
                        data-items-xl="4">

                            @foreach ($relatedProducts as $product)
                            <div class="oc-item">
                            <div class="product" id="product_{{ $product->slug }}">
                                    <div class="product-image">
                                        @foreach ($product->productImages as $productImage)
                                            <a href="{{ route('view_product', $product->slug) }}">
                                                <img class="product_image"
                                                    src="{{ asset('web/images/product_images/thumbnails/' . $productImage->image) }}"
                                                    alt="{{ $product->name }}">
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="product-desc">
                                        <div class="product-title min-h-30">
                                            <h3><a href="{{ route('view_product', $product->slug) }}"
                                                   >{{ $product->name }}</a></h3>
                                        </div>
                                        <div class="product-price">
                                            <div class="text-left">
                                                @if ($product->discount_amount > 0)
                                                    <del>₹ {{ $product->price }}</del>
                                                    <ins>₹ {{ $product->discount_amount }}</ins>
                                                @else
                                                    <ins>₹ {{ $product->price }}</ins>
                                                @endif
                                                <input type="hidden" class="product_price" value="{{ $product->price }}" />
                                                <input type="hidden" class="product_name" value="{{ $product->name }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <a class="btn btn-info" onclick="Cart.add(this)" data-productid="{{ $product->slug }}"
                                            class="text-info" style="font-weight: 300 !important; font-size:18px;"
                                            class="" href="Javascript:void(0)">
                                            <p class="add_cart_container" style="margin-bottom: 1px; line-height: 1">
                                            <span class="add_cart_label">Add To Cart</span>
                                            <i class="icon-shopping-cart"></i>
                                            </p>
                                        </a>
                                    </div>
                            </div>
                        </div>
                            @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function() {
                Cart.updateSingleProductQty($("#productName").val());
            });
        </script>
    @endpush

@endsection
