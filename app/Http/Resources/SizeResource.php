<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
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
        $resource->size ?? null;
        unset($resource->size_id);
        unset($resource->id);
        unset($resource->product_id);
        unset($resource->created_at);
        unset($resource->updated_at);
        return $resource;
    }
}
