<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
        $category = $resource->category->name ?? null;
        $asset = $resource->asset->asset_name ?? null;
        unset($resource->category);
        unset($resource->asset);
        $product_prices = ProductPriceResource::collection($resource->productPrices);
        unset($resource->productPrices);
        $resource->product_prices = $product_prices;
        $resource->category = $category;
        $resource->asset = $asset;
        return $resource;
    }
}
