<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemListResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return
                    [
                    'product' => $this->product->slug,
                    'name' => $this->product->name,
                    'price' => $this->product->actual_price,
                    'qty' => $this->qty,
                    'image' => $this->product->productImages->count() > 0 ? $this->product->productImages->first()->productImage : asset('web/images/product_images/thumbnails/no_image.png'),
                    'is_pharma_product' => $this->product->isPharmaProduct(),
                    'status' => $this->status ? true : false
                    ];

    }
}
