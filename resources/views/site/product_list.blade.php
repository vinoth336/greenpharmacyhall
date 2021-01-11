@extends('site.app')

@section('content')
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row gutter-40 col-mb-80">

                <div class="postcontent col-lg-9 order-lg-last">

                    <div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">

                        @foreach($products as $product)
                            <div class="product col-lg-3 col-md-3 col-sm-6 col-12 col-sm">
                                <div class="grid-inner">
                                    <div class="product-image">
                                        @foreach($product->portfolioImages as $productImage)
                                            <a href="#">
                                                <img src="{{ asset('web/images/portfolio_images/' . $productImage->image)}}" alt="{{ $product->name }}">
                                            </a>
                                        @endforeach
                                        <div class="sale-flash badge badge-success p-2 text-uppercase">Sale!</div>
                                        <div class="bg-overlay d-none">
                                            <div class="bg-overlay-content align-items-end justify-content-between"
                                                data-hover-speed="400">
                                                <a href="#" class="btn btn-dark mr-2"><i
                                                        class="icon-shopping-basket"></i>
                                                </a>
                                                <a href="{{ route('view_product_summary', $product->id) }}" class="btn btn-dark"
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
                </div>

                <div class="sidebar col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Select Category</h5>
                            <select class="selectpicker" name="categories" id="categories" multiple>
                                <option value="">All</option>
                                    @foreach ($categories as $category )
                                        <option value="{{ $category->slug }}"> {{ $category->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <h5>Sort By</h5>
                            <select class="selectpicker" name="sort_by" id="sort_by">
                                <option value="low_to_high">Low To High</option>
                                <option value="high_to_low">High To Low</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<link rel="stylesheet" href="{{ asset('web/css/components/bs-select.css') }}" type="text/css" />
<script src="{{ asset('web/js/components/bs-select.js') }}"></script>
<script src="{{ asset('web/js/components/selectsplitter.js') }}"></script>
@endsection
