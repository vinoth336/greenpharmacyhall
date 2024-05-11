@extends('site.app')

@section('content')

    <section id="page-title">
        <div class="container clearfix">
            <h1>Shipping Policy</h1>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row gutter-40 col-mb-80">
                    <div class="col-12">
                        Green Pharmacy Hall ("we" and "us") is the operator of (https://www.greenpharmacyhall.com) ("Website"). By placing an order through this Website you will be agreeing to the terms below. These are provided to ensure both parties are aware of and agree upon this arrangement to mutually protect and set expectations on our service.
                        <ol style="list-style:none;padding-left:0px">
                            <li class="page-title-inline" style="font-size:16px;">1. General</li>
                            <li>
                                Subject to stock availability. We try to maintain accurate stock counts on our website but from time-to-time, there may be a stock discrepancy and we will not be able to fulfill all your items at the time of purchase. In this instance, we will fulfill the available products to you, and contact you about whether you would prefer to await restocking of the back-ordered item or if you would prefer for us to process a refund.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">2. Shipping Costs</li>
                            <li>
                                Shipping costs are calculated during checkout based on weight, dimensions, and destination of the items in the order. Payment for shipping will be collected with the purchase.

                                This price will be the final price for the shipping cost to the customer.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                3. Items Out Of Stock
                            </li>
                            <li>
                                If an item is out of stock, we will dispatch the in-stock items immediately and send the remaining items once they return to stock.
                            </li>
                            <li >4. Delivery Timing</li>
                            <li>
                                Note : We delivery only the selective places only, so kindly ensure our service available in your location by entering the pincode in the estimation delivery time input box or further clarification kindly contact our sales team. <Br>
                                For domestic buyers, orders are shipped through registered domestic courier
                                companies and /or speed post only. Orders are shipped within
                                1-2 days or as per the delivery date agreed
                                at the time of order confirmation and delivering of the shipment subject to Courier Company / post office norms.
                                GREEN PHARMACY HALL is not liable for any delay in delivery by the courier company / postal
                                authorities and only guarantees to hand over the consignment to the courier company or
                                postal authorities within 1-2 days rom the date of the order
                                and payment or as per the delivery date agreed at the time of order confirmation. Delivery
                                of all orders will be to the address provided by the buyer. For any issues in utilizing
                                our services you may contact our helpdesk on {{ $siteInformation->phone_no }}
                                or sales@greenpharmacyhall.com
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                5. Delivery Time Exceeded
                            </li>
                            <li>
                                If the delivery time has exceeded the forecasted time, please contact us so that we can conduct an investigation.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                6. Tracking Notifications
                            </li>
                            <li>
                                Upon dispatch, customers will receive a tracking link from which they will be able to follow the progress of their shipment based on the latest updates made available by the shipping provider.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                7. Parcels Damaged In Transit
                            </li>
                            <li>
                                If you find a parcel is damaged in transit, if possible, please reject the parcel from the courier and get in touch with our customer service. If the parcel has been delivered without you being present, please contact customer service with the next steps.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                8. Cancellations
                            </li>
                            <li>
                                If you change your mind before you have received your order, we are able to accept cancellations at any time before the order has been dispatched. If an order has already been dispatched, please refer to our <a href="{{ route('site.return_policy') }}">refund policy</a>.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                9. Process for parcel damaged in-transit
                            </li>
                            <li>
                                We will process a refund or replacement as soon as the courier has completed their investigation into the claim.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                10. Process for parcel lost in transit
                            </li>
                            <li>
                                We will process a refund or replacement as soon as the courier has conducted an investigation and deemed the parcel lost.
                            </li>
                            <li class="page-title-inline" style="font-size:16px;">
                                11. Customer service
                            </li>
                            <li>
                                For all customer service inquiries, please <a href="{{ route('site.contact_us') }}">contact us</a>
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
