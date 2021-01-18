
        <div class="postcontent col-lg-12">
            <h4>Pharma Orders</h4>
            <div class="">
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
                        @foreach ($pharmaOrders as $order)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td><a href="{{ $order->image_url }}" target="_blank">View</a></td>
                                <td>{{ $order->comment_text }}</td>
                                <td>{{ optional($order->order_status)->name }}</td>
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

