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
        <div class="postcontent col-lg-9">
            <div class="faqs">
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Order Date</th>
                            <th>Prescription Details</th>
                            <th>Comment</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td><a href="{{ $order->image_url }}" target="_blank">View</a></td>
                                <td>{{ $order->comment_text }}</td>
                                <td>{{ $order->order_status->name }}</td>
                                <td>
                                    @if($order->order_status->slug_name == 'pending')
                                        <form method="POST" action="{{ route('public.pharma_order_delete', $order->id) }}"
                                            onsubmit="return confirm('Are You Sure Want Delete This Order ?');"
                                            >
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="icon-trash"></i>
                                        </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-3">
            @include('public.user.sidebar')
        </div>
    </div>
</div>
</div>
</section>
@endsection
