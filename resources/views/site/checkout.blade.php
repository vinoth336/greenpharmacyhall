@extends('site.app')

@section('content')

    <section id="page-title" style="background: #1abc9c">
        <div class="container clearfix">
            <h1 class="text-white">Few Steps to complete your order
                <i class="icon-shopping-cart"></i>
            </h1>

        </div>
    </section>

    @if(auth()->guard('web')->check())
        <form method="post" action="" >
    @endif

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                @if($errors->any())
                    <h4 class="text-danger m-auto text-center">Please Fix the Following Errors</h4>
                    <ul class="error card m-auto">
                        {!! implode('', $errors->all('<li>:message</li>')) !!}
                    </ul>
                @endif

                <div class="row col-mb-30 gutter-50 mb-4">
                    <div class="col-lg-9 m-auto">

                        <div class="accordion clearfix">
                            <div class="accordion-header">
                                <div class="accordion-icon">
                                    <i class="accordion-closed icon-line-minus"></i>
                                    <i class="accordion-open icon-line-check"></i>
                                </div>
                                <div class="accordion-title">
                                    Cart Details
                                </div>
                            </div>
                            <div class="accordion-content clearfix">
                                <div class="table-responsive">
                                    <div id="order_details">


                                    </div>
                                    <div   class="text-right" style="padding-top:20px;margin-top: 40px; margin-bottom: 40px; border-top: 1px solid #ccc">
                                            Total Amount : <span style="font-weight: bold" id="order_amount"></span>
                                    </div>
                                    <button onclick="Cart.showAddressInfoBlock()" type="button" class="btn btn-success float-right">
                                        Next
                                    </button>
                                </div>
                            </div>
                            <div class="accordion-header" id="account_and_delivery_address_info">
                                <div class="accordion-icon">
                                    <i class="accordion-closed icon-line-minus"></i>
                                    <i class="accordion-open icon-line-check"></i>
                                </div>
                                <div class="accordion-title">
                                    Account And Delivery Address Information
                                </div>
                            </div>
                            <div class="accordion-content clearfix">
                                <div class="row">
                                    <div class="postcontent col-lg-12">
                                        <div class="clear"></div>
                                        @if(auth()->guard('web')->check())
                                            @include('site.user_address_info')
                                            <button onclick="Cart.showOrderSummaryBlock()" type="button" class="btn btn-success float-right">
                                                Next
                                            </button>
                                        @else
                                            @include('site.cart_signup_form')
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-header" id="order_summary_details">
                                <div class="accordion-icon">
                                    <i class="accordion-closed icon-line-minus"></i>
                                    <i class="accordion-open icon-line-check"></i>
                                </div>
                                <div class="accordion-title" onclick="Cart.showOrderSummaryBlock()">
                                    Order Summary
                                </div>
                            </div>
                            <div class="accordion-content clearfix">
                                @if(auth()->guard('web')->check())
                                <div class="row">
                                    <div class="col-md-8">
                                        <div id="order_summary">


                                        </div>
                                        <br>
                                    </div>
                                    <div class="com-md-4">
                                        @if(auth()->guard('web')->check())
                                            @include('site.user_address_info')
                                        @endif
                                        <h6 style="font-weight:bolder;margin-top: 10px;">Payment Type</h6>
                                        <i class="fas fa-money-bill-wave"></i>Cash On Delivery
                                        <hr>
                                        <h6>Delivery Type</h6>
                                        <input type="radio" id="delivery_delivery_type" name="delivery_type" checked value="door_delivery" />&nbsp;Door Delivery - <i class="text-danger"  style="font-size: 12px;"> Min Order - {{  number_format($cart_settings['free_deliver_min_amt'], 2) }}</i><br>
                                        <input type="radio" id="delivery_shop_pickup" name="delivery_type" value="shop_pickup" />&nbsp;Shop Pickup - <i class="text-danger" style="font-size: 12px;"> Min Order - {{  number_format($cart_settings['shop_pickup_min_amt'], 2) }}</i> <br>
                                    </div>
                                </div>
                                    <div   class="text-right" style="padding-top:20px;margin-top: 40px; margin-bottom: 40px; border-top: 1px solid #ccc">
                                            Total Amount : <span style="font-weight: bold" id="order_summary_amount"></span>
                                    </div>
                                    <button type="button" class="btn btn-success float-right" onclick="Cart.checkout(this)">
                                        Place Order
                                    </button>
                                </div>
                                @else
                                    Please SignUp to complete your order
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="page" value="checkout" />
        <input type="hidden" id="min_amount_for_free_delivery" value="{{ $cart_settings['free_deliver_min_amt'] }}" />
        <input type="hidden" id="min_amount_for_shop_pickup" value="{{ $cart_settings['shop_pickup_min_amt'] }}" />

    </section>
    @if(auth()->guard('web')->check())
        </form>
    @endif

    <script>
        $(document).ready(function() {
            Cart.CartDetail();
        });
    </script>
@endsection
