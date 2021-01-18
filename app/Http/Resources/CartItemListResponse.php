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
                    'image' => $this->product->productImages->first()->productImage,
                    'status' => $this->status ? true : false
                    ];

    }
}
