<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiService
{
    public static function manageUser($request, $user = null)
    {
        $user_id = $user && $user->id ? $user->id : null;
        // dd($user);

        $user = User::updateOrcreate(
            [
                'id' => $user_id,
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nrc' => $request->nrc,
                'phone_number' => $request->phone_number,
            ]);

        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
    }
}
