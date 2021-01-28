<div class="single-product shop-quick-view-ajax">
    <div class="ajax-modal-title">
        <h2>{{ $product->name }}</h2>
    </div>
    <div class="product modal-padding">
        <div class="row gutter-40 col-mb-50">
            <div class="col-md-6">
                <div class="product-image">
                    <div class="fslider" data-pagi="false">
                        <div class="flexslider">
                            <div class="slider-wrap">
                                @foreach($product->productImages as $productImage)
                                    <div class="slide">
                                        <a href="{{ asset('web/images/product_images/' . $productImage->image)}}" title="{{ $product->name }}">
                                        <img src="{{ asset('web/images/product_images/thumbnails/' . $productImage->image)}}" alt="{{ $product->name }}"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sale-flash badge badge-danger p-2">Sale!</div>
                </div>
            </div>
            <div class="col-md-6 product-desc">
                <div class="product-price">
                    @if($product->discount_amount > 0)
                        <del>₹ {{ $product->price }}</del>
                        <ins>₹ {{ $product->discount_amount }}</ins>
                    @else
                        <ins>₹ {{ $product->price }}</ins>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="line"></div>

                <!-- Product Single - Quantity & Cart Button
                ============================================= -->
                <form class="cart mb-0" style="display: none" method="post" enctype="multipart/form-data">
                    <div class="quantity">
                        <input type="button" value="-" class="minus">
                        <input type="text" step="1" min="1" name="quantity" value="1" title="Qty" class="qty" size="4">
                        <input type="button" value="+" class="plus">
                    </div>
                    <button type="button" class="add-to-cart button m-0">Add to cart</button>
                </form><!-- Product Single - Quantity & Cart Button End -->

                <div class="clear"></div>
                <div class="line"></div>
                <div style="text-align:justify; line-height:28px !important">{!! $product->description !!}</div>
                <div class="card product-meta mb-0" style="display: none">
                    <div class="card-body">
                        <span class="posted_in">Category: <a href="#" rel="tag">Shoes</a>.</span>
                        <span class="tagged_as">Tags: <a href="#" rel="tag">Barena</a>, <a href="#" rel="tag">Blazers</a>, <a href="#" rel="tag">Tailoring</a>, <a href="#" rel="tag">Unconstructed</a>.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
