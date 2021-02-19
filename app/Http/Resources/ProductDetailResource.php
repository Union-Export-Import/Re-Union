<?php

namespace App\Http\Resources;

use App\Models\ProductPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        $product_prices = ProductPriceResource::collection($resource->productPrices);
        unset($resource->productPrices);
        $resource->product_prices = $product_prices;
        return $resource;
    }
}
