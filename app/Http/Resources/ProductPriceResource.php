<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
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
        $product_color = new ColorResource($resource->productColor ?? null);
        $product_size = new SizeResource($resource->productSize ?? null);
        
        unset($resource->productColor);
        unset($resource->productSize);

        $resource->product_color = $product_color;
        $resource->product_size = $product_size;
        return $resource;
    }
}
