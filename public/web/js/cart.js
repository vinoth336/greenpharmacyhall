var CURRENCY_DECIMAL_PLACES = 2;
const MIN_ORDER_AMOUNT = $("#MIN_ORDER_AMOUNT").val();
const CURRENCY_FORMATER = new Intl.NumberFormat('en-IN', {
    style: 'decimal',
    currency: 'IND',
    minimumFractionDigits: CURRENCY_DECIMAL_PLACES
});
$(document).ready(function() {
    // bind 'myForm' and provide a simple callback function
    $('#myForm').ajaxForm(function() {
        alert("Thank you for your comment!");
    });
    Cart.init();
});

var Cart = {
    init: function() {
        if (navigator.cookieEnabled) {
            this.syncCartItems()
            this.syncCartValues();
            this.refreshCartItems();
            this.showOrderSummaryBlock();
        } else {
            alert("Your browser is not supported some features, please use latest version or try in another browser");
        }
    },
    /**
     * Pincode Validation
     */
    isValidPincode:function(pincode){
        const pcode=pincode.target.value;
        if(pcode.length==6){
            $.ajax({
                "url": "/delivery-est",
                "type": "get",
                "data":{
                    pincode:pcode
                },
                "dataType": "json",
                success: function(items) {
                    console.log(items['message']);
                    $('#estimate_delivery_data').html(items['message']).data('isvalid', 'true');
                },
                error: function(jqXHR, exception) {
                    $('#estimate_delivery_data').html(jqXHR.responseJSON['message']).data('isvalid', 'false');
                }
            });
        } 
    },
    syncCartValues: function() {
        var items = Cart.getItemFromLocalStorage();
        $.ajax({
            "url": "/cart",
            "type": "get",
            "dataType": "json",
            "success": function(items) {
                Cart.addCartItemsFromServerToLocatStorage(items);
                Cart.refreshCartItems();
                Cart.CartDetail();
            },
            "error": function(jqXHR, exception) {

            }
        });
    },
    add: function(product, qty = 1) {
        var productId = $(product).data('productid');
        $.ajax({
            "url": "/cart/" + productId + "/add",
            "type": "post",
            "dataType": "json",
            "data": {
                "qty": qty
            },
            "success": function(data) {
                Cart.addCartItemsFromServerToLocatStorage(data);
                Cart.refreshCartItems();
            },
            "error": function(jqXHR, exception) {
                if (jqXHR.status == 401) {
                    Cart.addInLocalStorage(productId, qty);
                }
            }
        });

    },
    updateQty: function(container, product) {
        var productId = $(product).data('productid');
        var qty = $(product).val();
        container = $(product).closest('' + container);
        if (qty < 1) {
            return false;
        }

        //This logic used in view single product page
        if (!Cart.isProductExistsInCart(productId)) {
            Cart.add(product, qty);
            return true;
        }

        $.ajax({
            "url": "/cart/" + productId + "/update",
            "type": "put",
            "dataType": "json",
            "data": {
                "qty": qty
            },
            "success": function(items) {
                Cart.addCartItemsFromServerToLocatStorage(items);
                Cart.updateInLocalStorage(container, productId, qty);
            },
            "error": function(jqXHR, exception) {
                if (jqXHR.status == 401) {
                    Cart.updateInLocalStorage(container, productId, qty);
                    Cart.refreshCartItems();
                }
            }
        });
    },
    removeProduct: function(product) {
        var productId = $(product).data('productid');
        $.ajax({
            "url": "/cart/" + productId + "/remove",
            "type": "delete",
            "dataType": "json",
            "success": function(data) {
                Cart.addCartItemsFromServerToLocatStorage(data);
                Cart.refreshCartItems();
                Cart.CartDetail();
            },
            "error": function(jqXHR, exception) {
                if (jqXHR.status == 401) {
                    Cart.removeInLocalStorage(productId);
                }
            }
        })
    },
    syncCartItems: function() {
        var items = Cart.getItemFromLocalStorage();
        if (Object.keys(items).length == 0) {
            return false;
        }

        $.ajax({
            "url": "/cart/sync_cart",
            "type": "post",
            "dataType": "json",
            "data": {
                "items": items
            },
            "success": function(data) {
                Cart.addCartItemsFromServerToLocatStorage(data);
                Cart.refreshCartItems();
                Cart.CartDetail();
            },
            "error": function(jqXHR, exception) {

            }
        });
    },
    addCartItemsFromServerToLocatStorage: function(items) {
        var data = {}
        $.each(items.data, function(key, productInfo) {
            data[productInfo.product] = {
                "productName": productInfo.name,
                "productPrice": productInfo.price,
                "productImage": productInfo.image,
                "qty": productInfo.qty,
                "status": productInfo.status
            };
        });
        Cart.setItemInLocalStorage(data);
        Cart.refreshCartItems();
        // if (Cart.isCheckoutPage()) {
        //     Cart.refreshCartItems();
        // }
    },
    addInLocalStorage: function(productId, qty) {
        var container = $("#product_" + productId);
        var productImage = container.find('.product_image:first').attr('src');
        var productPrice = container.find('.product_price').val();
        var productName = container.find('.product_name').val();
        var data = {};
        if (localStorage.cart) {
            data = Cart.getItemFromLocalStorage();
            data[productId] = {
                "productName": productName,
                "productPrice": productPrice,
                "productImage": productImage,
                "qty": qty,
                "status": true
            };
        }
        data[productId] = {
            "productName": productName,
            "productPrice": productPrice,
            "productImage": productImage,
            "qty": qty,
            "status": true
        };
        Cart.setItemInLocalStorage(data);

        //toastr.success('Added Successfully');
        Cart.refreshCartItems();
    },
    updateInLocalStorage: function(container, productId, qty) {
        if (localStorage.cart) {
            data = Cart.getItemFromLocalStorage();
            if (typeof data[productId] != 'undefined') {
                data[productId]['qty'] = qty;
                Cart.setItemInLocalStorage(data);
                var sum = 0;
                var totalAmount = data[productId]['qty'] * data[productId]['productPrice'];
                container.find('.top-cart-item-price-total').html('<b>' + CURRENCY_FORMATER.format(totalAmount) + '</b>');
                container.find('.product_total_amount').val(totalAmount);
                $(".top-cart-items").find('.product_total_amount').each(function() {
                    sum += Number($(this).val());
                });
                Cart.updateTotalCartAmount(sum);
                Cart.updateActiveCartItemTotal('order_amount');
            }
        }
    },
    updateProductCartStatus: function(product) {
        if (localStorage.cart) {
            var productId = $(product).data('productid');
            var status = $(product).is(":checked") ? true : false;
            $.ajax({
                "url": "/cart/" + productId + "/update_status",
                "type": "put",
                "dataType": "json",
                "data": {
                    "status": status
                },
                "success": function(items) {

                },
                "error": function(jqXHR, exception) {}
            });
            data = Cart.getItemFromLocalStorage();
            if (typeof data[productId] != 'undefined') {
                data[productId]['status'] = status
                Cart.setItemInLocalStorage(data);
                Cart.updateActiveCartItemTotal();
            }
        }
    },
    removeInLocalStorage: function(productId) {
        if (localStorage.cart) {
            data = Cart.getItemFromLocalStorage();
            if (typeof data[productId] != 'undefined') {
                delete data[productId];
                Cart.setItemInLocalStorage(data);
            }
            Cart.refreshCartItems();
            Cart.refreshCartDetail();
        }
    },
    refreshCartItems: function() {
        var cart = Cart.getItemFromLocalStorage();
        var sum = 0;
        var content = '';
        var totalItem = '';
        $.each(cart, function(productId, productInfo) {
            var cartList = cartItemListTemplate;
            var totalAmount = productInfo.qty * productInfo.productPrice;
            cartList = cartList.replace(/PRODUCT_ID/g, productId);
            cartList = cartList.replace(/IMG_SRC/g, productInfo.productImage);
            cartList = cartList.replace(/PRODUCT_NAME/g, productInfo.productName);
            cartList = cartList.replace(/PRODUCT_PRICE/g, productInfo.productPrice);
            cartList = cartList.replace(/QTY/g, productInfo.qty);
            cartList = cartList.replace(/TOTAL_AMOUNT/g, CURRENCY_FORMATER.format(totalAmount));
            content += cartList;
            sum += totalAmount;
            totalItem++;
        });
        Cart.updateTotalCartAmount(sum);
        Cart.updateTotalItemCount(totalItem);
        Cart.updateItemList(content);
    },
    CartDetail: function() {
        var cart = Cart.getItemFromLocalStorage();
        var sum = 0;
        var content = '';
        var totalItem = '';
        var template = '';
        $.each(cart, function(productId, productInfo) {
            var totalAmount = productInfo.qty * productInfo.productPrice;
            var html = ItemListTemplate;
            html = html.replace(/PRODUCT_ID/g, productId);
            html = html.replace(/IMG_SRC/g, productInfo.productImage);
            html = html.replace(/PRODUCT_NAME/g, productInfo.productName);
            html = html.replace(/PRODUCT_PRICE/g, productInfo.productPrice);
            html = html.replace(/QTY/g, productInfo.qty);
            if (productInfo['status'] == true) {
                html = html.replace(/IS_CHECKED/g, 'checked=true');
            } else {
                html = html.replace(/IS_CHECKED/g, '');
            }
            html = html.replace(/TOTAL_AMOUNT/g, CURRENCY_FORMATER.format(totalAmount));
            content += html;
            sum += totalAmount;
            totalItem++;
        });
        Cart.updateOrderDetailsContent(content);
        Cart.updateActiveCartItemTotal('order_amount');

    },
    OrderSummaryDetail: function() {
        var cart = Cart.getItemFromLocalStorage();
        var sum = 0;
        var content = '';
        var totalItem = '';
        var template = '';
        $.each(cart, function(productId, productInfo) {
            if (productInfo['status'] == true) {
                var totalAmount = productInfo.qty * productInfo.productPrice;
                var html = OrderConfirmListTemplate;
                html = html.replace(/PRODUCT_ID/g, productId);
                html = html.replace(/IMG_SRC/g, productInfo.productImage);
                html = html.replace(/PRODUCT_NAME/g, productInfo.productName);
                html = html.replace(/PRODUCT_PRICE/g, productInfo.productPrice);
                html = html.replace(/QTY/g, productInfo.qty);
                html = html.replace(/TOTAL_AMOUNT/g, CURRENCY_FORMATER.format(totalAmount));
                content += html;
                sum += totalAmount;
                totalItem++;
            }
        });

        Cart.updateOrderSummaryContent(content);
        Cart.updateActiveCartItemTotal('order_summary_amount');
    },
    checkout: function(elm) {
        if (localStorage.cart) {
            $(elm).attr('disabled', true);
        $.ajax({
                "url": "/cart/checkout",
                "type": "post",
                "dataType": "json",
                "data": {
                    "delivery_type": $("[name='delivery_type']:checked").val()
            },
                "success": function(items) {

                    var options=items[0];
                    options.handler=function(response){
                        document.getElementById('rzp_paymentid').value = response.razorpay_payment_id;
                        document.getElementById('rzp_orderid').value = response.razorpay_order_id;
                        document.getElementById('rzp_signature').value = response.razorpay_signature;
                        document.getElementById('amount').value = options['amount'];
                        document.razorpayform.submit();
                    };
                    var rzp=new Razorpay(options);
                    rzp.open();
    },
                "error": function(jqXHR, exception) {
                    $(elm).attr('disabled', false);
                    toastr.error(jqXHR.responseText);
            }
        });
        }
    },
    isProductExistsInCart: function(productId) {
        if (localStorage.cart) {
            data = Cart.getItemFromLocalStorage();
            if (typeof data[productId] != 'undefined') {
                return true;
            }
        }

        return false
    },
    updateActiveCartItemTotal: function(id = 'order_amount') {
        var cart = Cart.getItemFromLocalStorage();
        var sum = 0;
        $.each(cart, function(productId, product) {
            if (product['status']) {
                sum += Number(product['qty'] * product['productPrice']);
            }
        });
        $("#" + id).html(CURRENCY_FORMATER.format(sum));

        console.log(sum + " --------------- " + $("#min_amount_for_free_delivery").val());

        if (sum >= $("#min_amount_for_free_delivery").val()) {
            $("#delivery_door_delivery").attr('checked', true);
        } else {
            $("#delivery_shop_pickup").attr('checked', true);
        }

    },
    updateTotalCartAmount: function(sum) {
        $("#top-checkout-price").html(CURRENCY_FORMATER.format(sum));
    },
    updateTotalItemCount: function(totalItem) {
        $("#top-cart-number").html(totalItem);
    },
    updateOrderDetailsContent: function(totalItem) {
        $("#order_details").html(totalItem);
    },
    updateOrderSummaryContent: function(totalItem) {
        $("#order_summary").html(totalItem);
    },
    updateSingleProductQty: function(productId) {
        var cart = Cart.getItemFromLocalStorage();

        if (typeof cart[productId] != 'undefined') {
            var productInfo = cart[productId];
            $("#product_qty_" + productId).val(productInfo['qty']);
        }
    },
    updateItemList: function(content) {
        if (content == '') {
            content = "<p align='center'>Cart Is Empty</p>";
        }
        $("#top-cart-items").html(content);
    },
    showLoginForm: function() {
        $("#login_form").find('#redirectTo').val('checkout');
        $(".show-login-modal").modal('show');
    },
    showAddressInfoBlock: function() {
        $("#account_and_delivery_address_info").click();
    },
    showOrderSummaryBlock: function() {
        $("#order_summary_details").click();
        Cart.OrderSummaryDetail()
    },
    setItemInLocalStorage: function(data) {
        return localStorage.setItem('cart', JSON.stringify(data));
    },
    getItemFromLocalStorage: function(data) {
        if (localStorage.cart) {
            return JSON.parse(localStorage.cart);
        }
        return null;
    },
    isCheckoutPage: function() {
        if ($("#page").val() != 'undefined') {
            if ($("#page").val() == 'checkout') {
                return true;
            }
        }
        return false;
    },
};

var OrderConfirmListTemplate = `<div class="top-cart-item" id="order_confirm_item_PRODUCT_ID">
                                <div class="top-cart-item-image">
                                    <a href="#">
                                        <img src="IMG_SRC"
                                            alt="PRODUCT_NAME" />
                                    </a>
                                </div>
                                <div class="top-cart-item-desc">
                                    <div class="top-cart-item-desc-title">
                                        <a href="/product/PRODUCT_ID" data-lightbox="ajax">
                                            PRODUCT_NAME
                                        </a>
                                        <span class="top-cart-item-price d-block float-left">
                                            QTY * PRODUCT_PRICE
                                        </span>
                                        <span class="top-cart-item-price top-cart-item-price-total d-block float-right">
                                            <b style="font-weight: bold">TOTAL_AMOUNT</b>
                                        </span>
                                    </div>
                                </div>
                </div>`;

var ItemListTemplate = `<div class="top-cart-item" id="order_item_PRODUCT_ID">
                            <div class="totp-cart-item-desc m-auto" style="padding:20px">
                                <input type="checkbox" onchange="Cart.updateProductCartStatus(this)" name="status[PRODUCT_ID]" data-productid="PRODUCT_ID" value="1" IS_CHECKED />
                            </div>
                                <div class="top-cart-item-image">
                                    <a href="#">
                                        <img src="IMG_SRC"
                                            alt="PRODUCT_NAME" />
                                    </a>
                                </div>
                                <div class="top-cart-item-desc">
                                    <div class="top-cart-item-desc-title">
                                        <a href="/product/PRODUCT_ID" data-lightbox="ajax">
                                            PRODUCT_NAME
                                        </a>
                                        <div class="quantity clearfix">
                                                <input type="button" value="-" class="minus">
                                                <input type="hidden" class="product_price" value="PRODUCT_PRICE" />
                                                <input type="number" onchange="Cart.updateQty('.top-cart-item', this)" onkeyup="Cart.updateQty('.top-cart-item', this)" id="checkout_row_PRODUCT_ID" data-productid="PRODUCT_ID"  step="1" min="1" value="QTY" class="qty">
                                                <input type="button" value="+" class="plus">
                                        </div>
                                        <div class="inline-block">
                                            * PRODUCT_PRICE
                                        </div>
                                        <span class="top-cart-item-price top-cart-item-price-total d-block float-right">
                                            <b>TOTAL_AMOUNT</b>
                                        </span>
                                        <input type="hidden" class="product_total_amount" value="TOTAL_AMOUNT" />
                                    </div>
                                    <div class="">
                                        <a href="Javascript:void(0)" class="text-danger float-right"  onclick="Cart.removeProduct(this)" data-productid="PRODUCT_ID">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                </div>`;

var cartItemListTemplate = `<div class="top-cart-item" id="cart_item_PRODUCT_ID">
                                <div class="top-cart-item-image">
                                    <a href="#">
                                        <img src="IMG_SRC"
                                            alt="PRODUCT_NAME" />
                                    </a>

                                </div>
                                <div class="top-cart-item-desc">
                                    <div class="top-cart-item-desc-title">
                                        <a href="/product/PRODUCT_ID" data-lightbox="ajax">
                                            PRODUCT_NAME
                                        </a>
                                        <span class="top-cart-item-price d-block float-left">
                                           <input type="hidden" class="product_price" value="PRODUCT_PRICE" />
                                           <input onkeyup="Cart.updateQty('.top-cart-item', this)" oninput="Cart.updateQty('.top-cart-item', this)" id="cart_row_PRODUCT_ID" data-productid="PRODUCT_ID" type="number" min="1" style="width:35px;margin-right:5px" value="QTY" /> * PRODUCT_PRICE
                                        </span>
                                        <span class="top-cart-item-price top-cart-item-price-total d-block float-right">
                                            <b>TOTAL_AMOUNT</b>
                                        </span>
                                        <input type="hidden" class="product_total_amount" value="TOTAL_AMOUNT" />
                                    </div>
                                    <div class="">
                                        <a href="Javascript:void(0)" class="text-danger float-right"  onclick="Cart.removeProduct(this)" data-productid="PRODUCT_ID">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                </div>`;
