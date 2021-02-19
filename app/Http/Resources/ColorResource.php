<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
        $resource->color ?? null;
        unset($resource->color_id);
        unset($resource->id);
        unset($resource->product_id);
        unset($resource->created_at);
        unset($resource->updated_at);

        return $resource;
    }
}
