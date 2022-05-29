<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Admin\Product as ProductResource;
use App\Http\Resources\Admin\ProductCombination as ProductCombinationResource;

class AvailableQty extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'product_combination_id' => $this->product_combination_id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'product_combination' => new ProductCombinationResource($this->whenLoaded('product_combination')),
            'product_type' => $this->product_type,
            'warehouse_id' => $this->warehouse_id,
            'stock_in' => $this->stock_in,
            'stock_out' => $this->stock_out,
            'remaining_stock' => $this->remaining,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
        ];
    }
}
