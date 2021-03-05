<div class="postcontent col-lg-12">
    <br>
    <h4>Non Pharma Orders</h4>
    <br>
        <div class="row">
            @forelse($nonPharmaOrders as $order)
                <div class="col-md-12" style="margin-bottom: 30px;">
                    <div class="">
                        <div class="top-cart-item-desc1 clearfix">
                            Order No : GH{{ $order->order_no }}
                            &nbsp;
                            @if($order->order_status->slug_name == 'pending' )
                            <a href="Javascript:void(0)" class="text-danger float-right"  onclick="Order.removeOrder('{{ $order->id }}')" data-productid="PRODUCT_ID">
                                Cancel
                            </a>
                            @endif
                            <a href="Javascript:void(0)" class="text-danger float-right"  onclick="Order.removeOrder('{{ $order->id }}')" data-productid="PRODUCT_ID">
                                ReOrder
                            </a>
                            <div class="clearfix"></div>
                            <i>{{ $order->created_at }}</i>
                            <div class="clearfix"></div>
                            <b>{{ $order->order_status->name }}</b>
                        </div>
                        @foreach ($order->ordered_items as $orderedItem)
                            <div class="top-cart-item">
                                <div class="top-cart-item-image">
                                    <a href="#">
                                        @if($orderedItem->product->productImages->count() ?? false)
                                        <img src="{{ asset('web/images/product_images/thumbnails/' . $orderedItem->product->productImages->first()->image) }}"
                                            alt="{{ $orderedItem->product->name }}" />
                                        @else
                                        <img src="{{ asset('web/images/product_images/thumbnails/no_image.png') }}"
                                            alt="{{ $orderedItem->product->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="top-cart-item-desc">
                                    <div class="top-cart-item-desc-title">
                                        <a href="product/summary/{{ $orderedItem->product->slug }}" data-lightbox="ajax">
                                            {{ $orderedItem->product->name }}
                                        </a>
                                        <span class="top-cart-item-price d-block float-left">
                                            {{ $orderedItem->qty }} * {{ $orderedItem->price }}
                                        </span>
                                        <span class="top-cart-item-price top-cart-item-price-total d-block float-right">
                                            <b style="font-weight: bold"
                                                class="update_currency_format">{{ $orderedItem->qty * $orderedItem->price }}</b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div   class="text-right" style="padding-top:20px;margin-top: 40px; margin-bottom: 40px; border-top: 1px solid #ccc">
                            Total Amount : <span style="font-weight: bold" class="update_currency_format">{{ $order->total_amount }}</span>
                        </div>
                    </div>
                </div>
                <hr>
            @empty
                    <h6 class="col-lg-12" align="center">Let Start your valuable order with us</h6>
            @endforelse
        </div>
</div>
