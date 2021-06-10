<html>
    <head>
        <link rel="stylesheet" href="{{ asset('web/style.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}?v={{ $version }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/magnific-popup.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/custom.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('web/css/swiper.css') }}" type="text/css" />
    </head>
    <style>
        #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice .invoice_header_spliter {
    border-bottom: 1px solid #3989c6;
    margin-bottom: 10px;
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 3px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 20px;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 14px;
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 12px
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 12px
}

.invoice table .no {
    font-size: 12px;
    /* background: #fff; */
}

.invoice table .unit {
    /* background: #fff; */
}

.invoice table .total {
    /* background: #fff; */
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 12px;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr td {
    color: #3989c6;
    font-size: 16px;
    border-top: 1px solid #27680eb5
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}

body {
    font-family: sans-serif !important;
}

        </style>
<body>
    <div id="invoice">
        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <div class="invoice_header">
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="{{ env('APP_URL') }}">
                                <img src="{{ asset('web/images/logo/' . $siteInformation->logo) }}" style="width:300px" />
                            </a>
                        </div>
                        <div class="company-details">
                            <h4 class="name">
                                <a target="_blank" href="Javascript:void(0)">
                                {{ ucfirst($userDetail->name) }}
                                </a>
                            </h4>
                                {!! ucfirst(implode( "<br>", explode(",", $userDetail->address))) !!}<br>
                                Karur - {{ $userDetail->zipcode }}<br>
                                Tamil Nadu<br>
                                {{ $userDetail->phone_no }}<br>
                            @if($userDetail->email)
                                {{ $userDetail->email }}<br>
                            @endif
                        </div>
                    </div>
                </div>
                <div style="margin-top: -35px">
                    <div class="invoice_header_spliter"></div>
                    <main>
                        <div class="row contacts">
                            <div class="col invoice-details">
                                <h5 class="invoice-id">INVOICE {{ $order->order_no }}</h5>
                                <div class="date">Date of Invoice: {{ $order->created_at }}</div>
                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">Item</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sno = 1;
                                @endphp
                                @foreach ($order->ordered_items as $orderedItem)
                                <tr>
                                    <td class="no">{{ $sno++ }}</td>
                                    <td class="text-left">
                                        <h3>
                                        <a target="_blank" href="{{ env('APP_URL') }}product/{{ $orderedItem->product->slug }}" >
                                            {{ $orderedItem->product->name }}
                                        </a>
                                        </h3>
                                    </td>
                                    <td class="unit">{{ number_format($orderedItem->price, 2) }}</td>
                                    <td class="qty">{{ $orderedItem->qty }}</td>
                                    <td class="total">{{ number_format($orderedItem->qty * $orderedItem->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">GRAND TOTAL</td>
                                    <td>{{ number_format($order->total_amount, 2 ) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br><br>
                        <div class="thanks">Thank you!</div>
                        <div class="notices">
                            <div>Note:</div>
                            <div class="notice">Price Include With Taxes</div>
                        </div>
                    </main>
                </div>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <div></div>
        </div>
    </div>
</body>
</html>

