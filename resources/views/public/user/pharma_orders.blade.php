
        <div class="postcontent col-lg-12">
            <h4>Pharma Orders</h4>
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Order Date</th>
                            <th>Prescription Details</th>
                            <th>Comment</th>
                            <th>Order Status</th>
                            <th>Prescription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach ($pharmaOrders as $order)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    @php $i=1; @endphp
                                    @foreach ($order->prescription_details as $prescription )
                                        <a href="{{ $prescription->image_url }}" data-lightbox="image">
                                            View Prescription{{ $i == 1 ? '' : " - " . $i }}<br>
                                        </a>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </td>
                                <td>{{ $order->comment_text }}</td>
                                <td>{{ optional($order->order_status)->name }}</td>
                                <td>
                                    @if ($order->hasMedia('member_photo'))
                                        @foreach($order->getMedia('prescription_details') as $media)
                                            <a href="{{ $media->getUrl('') }}" target="_blank" >
                                                View
                                            </a>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($order->order_status->slug_name == 'pending')
                                        <form method="POST" action="{{ route('public.pharma_order_delete', $order->id) }}"
                                            onsubmit="return confirm('Are You Sure Want Cancel This Order ?');"
                                            >
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">
                                            Cancel
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

