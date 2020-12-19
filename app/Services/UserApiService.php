<?php

namespace App\Services;

use App\Models\UacLog;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserApiService
{


    public static function manageUser($request, $hashed_random_password, $user = null)
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
                'password' => $hashed_random_password,
                'nrc' => $request->nrc,
                'phone_number' => $request->phone_number,
                'account_status' => $request->status,
            ]
        );
        $user->roles()->sync($request->roles);
        // $user->permissions()->sync($request->permissions);

        return $user;

    }

    public static function UacLogCreate($data, $type)
    {
        UacLog::create([
            'maker' => auth()->user()->name,
            'payload' => $data,
            'type' => $type,
        ]);
    }
}
