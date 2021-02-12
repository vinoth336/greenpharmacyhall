<div class="content" >
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-5">
                {{ $userInfo->name }},<br>
                {{ $userInfo->address }},<br>
                Karur - {{ $userInfo->zipcode }},<br>Tamil Nadu<br>
                {{ $userInfo->phone_no }}
            </div>
            <div class="col-md-5">
                Order Date :<br>
                {{ $order->created_at }}
            </div>
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
    </div>
</div>
