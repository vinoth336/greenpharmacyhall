@extends('site.app')

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container-fluid px-5 clearfix">
            <div class="row gutter-40 col-mb-80 vh-100">

                <div class="postcontent col-lg-9 order-lg-last">

                    <div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">

                        @foreach($products as $product)
                            <div class="product col-lg-3 col-md-3 col-sm-6 col-12 col-sm" id="product_{{ $product->slug }}">
                                <div class="grid-inner">
                                    <div class="product-image">
                                        @foreach($product->productImages as $productImage)
                                            <a href="#">
                                                <img class="product_image" src="{{ asset('web/images/product_images/' . $productImage->image)}}" alt="{{ $product->name }}">
                                            </a>
                                        @endforeach
                                        <div class="sale-flash badge badge-success p-2 text-uppercase">Sale!</div>
                                        <div class="bg-overlay d-none">
                                            <div class="bg-overlay-content align-items-end justify-content-between"
                                                data-hover-speed="400">
                                                <a href="#" class="btn btn-dark mr-2"><i
                                                        class="icon-shopping-basket"></i>
                                                </a>
                                                <a href="{{ route('view_product', $product->id) }}" class="btn btn-dark"
                                                    ><i class="icon-line-expand"></i>
                                                </a>
                                            </div>
                                            <div class="bg-overlay-bg bg-transparent"></div>
                                        </div>
                                    </div>

                                    <div class="product-desc">
                                        <div class="product-title min-h-30">
                                            <h3><a href="{{ route('view_product', $product->slug) }}"
                                                    >{{ $product->name }}</a></h3>
                                        </div>
                                        <div class="product-price">
                                            <div class="float-left">
                                                @if ($product->discount_amount > 0)
                                                    <del>₹ {{ $product->price }}</del>
                                                    <ins>₹ {{ $product->discount_amount }}</ins>
                                                @else
                                                    <ins>₹ {{ $product->price }}</ins>
                                                @endif
                                                <input type="hidden" class="product_price" value="{{ $product->price }}" />
                                                <input type="hidden" class="product_name" value="{{ $product->name }}" />

                                            </div>
                                            <div class="float-right">
                                                <a onclick="Cart.add(this)" data-productid="{{ $product->slug }}"
                                                    class="text-info" style="font-weight: 300 !important; font-size:18px;"
                                                    class="" href="Javascript:void(0)">
                                                    <i class="icon-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    </div>
                </div>
                @include('site.side_filter')
            </div>
        </div>
    </div>
</section>
<link rel="stylesheet" href="{{ asset('web/css/components/bs-select.css') }}" type="text/css" />
<script src="{{ asset('web/js/components/bs-select.js') }}"></script>
<script src="{{ asset('web/js/components/selectsplitter.js') }}"></script>
@endsection
