@extends('site.app')

@section('content')

<section id="page-title">
<div class="container clearfix">
<h1>Easy To Purchase</h1>
<span>Less Than 2 mins will purchase your order</span>
</div>
</section>

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">
        <div class="col-lg-9">
            <div class="row">
        @include('public.user.pharma_orders')
        @include('public.user.non_pharma_orders')
            </div>
        </div>
        <div class="col-lg-3">
            @include('public.user.sidebar')
        </div>
    </div>
</div>
</div>
</section>
@push('js')
<script type="text/javascript" src="{{ asset('web/js/order.js') }}"></script>
@endpush
@endsection
