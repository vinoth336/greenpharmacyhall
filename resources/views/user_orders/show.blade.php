<input type="hidden" id="order_id" value="{{ $order->id }}" />
<div class="content" >
    <div class="row">
        <div class="col-lg-5">
                <p>
                {{ $userInfo->name }},<br>
                {{ $userInfo->address }},<br>
                Karur - {{ $userInfo->zipcode }},<br>Tamil Nadu<br>
                {{ $userInfo->phone_no }}
                </p>
        </div>
        <div class="col-lg-5">
            <p class="text-right">
            Order Date :<br>
            {{ $order->created_at }}
            </p>
        </div>
    </div>
    <div class="row">
        <table class="table table-border table-stripped">
            <thead>
                <tr>
                    <td>S NO</td>
                    <td>Product</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $sno = 1;
                @endphp
                @foreach ($orderItems as $orderItem)
                    <tr>
                        <td class="text-left">{{ $sno++ }}</td>
                        <td >{{ $orderItem->product->name }}</td>
                        <td class="center">{{ $orderItem->qty }}</td>
                        <td class="text-right">{{ $orderItem->price }}</td>
                        <td class="text-right">{{ number_format($orderItem->qty * $orderItem->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">
                        Grand Total
                    </td>
                    <td class="text-right">
                        {{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
        <table class="table " id="update_order_status">
            <tbody>
                <tr>
                    <td >
                        <p>
                        <b>Order Status</b>
                        <select id="orderStatus" name="order_status" class="selectpicker">
                            @foreach ($orderStatus as $value)
                                <option value="{{ $value->id }}"
                                    @if($value->id == $order->order_status_id)
                                    selected
                                    @endif
                                >
                                    {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                        </p>
                        <br>
                        <p>
                        <b>Comment : </b>
                        <textarea class="form-control" id="orderComment" >{{ $order->comment }}</textarea>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
