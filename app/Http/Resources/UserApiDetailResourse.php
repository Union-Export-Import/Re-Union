<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserApiDetailResourse extends JsonResource
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

        $roles = RoleResource::collection($resource->roles);
        $permissions = RoleResource::collection($resource->roles);

        unset($resource->roles);
        
        $resource->roles = $roles;
        $resource->permissions = $permissions;
        return $resource;
    }
}
