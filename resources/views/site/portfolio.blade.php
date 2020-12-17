@extends('site.app')

@section('content')



    <section id="page-title">
        <div class="container clearfix">
            <h1>Portfolio</h1>
            <span>Description of service</span>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row col-mb-50">
                    <div class="col-12">
                        Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh
                        ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit
                        aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.
                        Cras mattis consectetur purus sit amet fermentum. Donec id elit non mi porta gravida at eget
                        metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id ligula porta
                        felis euismod semper.
                    </div>



                    <section id="slider" class="slider-element">
                        <div id="flickr" class="widget clearfix">
                            @foreach ($portfolios as $portfolio)
                                <h3>{{ strtoupper($portfolio->name) }}</h3><br>
                                <div id="flickr-widget" class="flickr-feed masonry-thumbs grid-container has-init-isotope"
                                    data-id="" data-count="" data-type="group" data-lightbox="gallery"
                                    style="position: relative; height: 130px;">
                                    @foreach ($portfolio->portfolioImages()->orderBy('sequence')->get() as $portfolioImage)
                                        <a class="grid-item"
                                            href="{{ asset('web/images/portfolio_images/' . $portfolioImage->image) }}"
                                            title="Justice" data-lightbox="gallery-item"
                                            style="position: absolute; left: 0%; top: 0px;">
                                            <img src="{{ asset('web/images/portfolio_images/thumbnails/' . $portfolioImage->image) }}"
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
