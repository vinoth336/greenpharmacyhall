@extends('site.app')

@section('content')
    <section id="page-title" class="page-title-parallax page-title-dark"
        style="background-image: url('{{ file_exists(public_path('web/images/product_images/' . $service->banner)) ? asset('web/images/product_images/' . $service->banner) : asset('web/images/banner/banner1.jpg') }}'); background-size: cover;"
        data-bottom-top="background-position:0px 0px;" data-top-bottom="background-position:0px -100px;">
        <div class="container clearfix">
            <h1>{{ ucwords($service->name) }}</h1>
            <span style="height: 20px;"></span>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row col-mb-50">
                    <div class="col-12">
                        {{ $service->description }}
                    </div>

                    <section id="slider" class="slider-element">
                        <div id="flickr" class="widget clearfix">

                            @foreach ($service->portfolios()->orderBy('sequence')->get() as $product)
                                <h3>{{ strtoupper($product->name) }}</h3><br>
                                <div id="flickr-widget" class="flickr-feed masonry-thumbs grid-container has-init-isotope"
                                    data-id="" data-count="" data-type="group" data-lightbox="gallery"
                                    style="position: relative; height: 130px;">
                                    @foreach ($product->productImages()->orderBy('sequence')->get() as $portfolioImage)
                                        <a class="grid-item"
                                            href="{{ asset('web/images/product_images/' . $portfolioImage->image) }}"
                                            title="Justice" data-lightbox="gallery-item"
                                            style="position: absolute; left: 0%; top: 0px;">
                                            <img src="{{ asset('web/images/product_images/thumbnails/' . $portfolioImage->image) }}"
                                                alt="Justice">
                                        </a>
                                    @endforeach
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>
@endsection
