<?php

namespace App\Services;

use App\Models\Role;

class RoleApiService
{
    public static function manageRole($request , $role = null)
    {
        $role_id = $role && $role->id ? $role->id : null;

        $user = Role::updateOrcreate(
            [
                'id' => $role_id,
            ],
            [
                'title' => $request->title,
            ]
        );
        $user->permissions()->sync($request->permissions);
    }
}

