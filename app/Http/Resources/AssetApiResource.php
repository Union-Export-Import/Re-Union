<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetApiResource extends JsonResource
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

        // dd($resource->asset_name);
        $asset_type = $resource->asset_type->asset_type;
        unset($resource->asset_type);
       $resource->asset_type = $asset_type;

        return $resource;
    }
}
