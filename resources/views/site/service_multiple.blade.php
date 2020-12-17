@extends('site.app')
@section('content')

<section id="page-title">
    <div class="container clearfix">
        <h1>Our Services</h1>
        <span>Description of service</span>
    </div>
</section>
<section id="content">
    <div class="content-wrap pb-0">
        <div class="container clearfix">
            <div class="grid-filter-wrap">


            </div>
        </div>

        <div id="portfolio" class="portfolio row grid-container gutter-20 has-init-isotope" data-layout="fitRows">
            @foreach($services as $service)
            <article class="portfolio-item col-lg-3 col-md-4 col-sm-6 col-12 pf-media pf-icons">
                <div class="grid-inner">

                    <div class="portfolio-image">
                        <a href="{{ route('service', $service->slug) }}">
                            @if(file_exists(public_path('web/images/portfolio_images/thumbnails/' . $service->banner)))
                            <img style="height:200px" src="{{ asset('web/images/portfolio_images/thumbnails/' . $service->banner ) }}" />
                            @else
                            <img style="height:200px" src="{{ asset('site_images/no-image.png') }}" />
                            @endif
                        </a>
                    </div>
                    <div class="portfolio-desc">
                    <h3><a href="{{ route('service', $service->slug) }}">{{ ucwords($service->name) }}</a></h3>
                    </div>
                </div>
            </article>

            @endforeach


        </div>
    </div>
    <div class="line" style="padding-bottom: 20px; margin-bottom:20px;"></div>
</section>
@endsection
