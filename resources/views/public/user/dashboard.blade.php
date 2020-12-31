@extends('site.app')

@section('content')

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-9">
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                @include('public.user.profile')
                            </div>
                        </div>
                    </div>
                    <div class="w-100 line d-block d-md-none"></div>
                    <div class="col-md-3">
                            @include('public.user.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
