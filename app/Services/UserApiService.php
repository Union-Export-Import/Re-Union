<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiService {
    public static function manageUser($request, $user = null)
    {
        $user = $user && $user->id ? $user->id : null;
        // dd($user);

        User::updateOrcreate(
            [
                'id' => $user
            ],
            [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
