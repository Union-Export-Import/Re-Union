<?php

namespace App\Services;

use App\Models\UacLog;
use App\Models\User;

class UserApiService
{

    public static function createUser($request, $hashed_random_password)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashed_random_password,
                'nrc' => $request->nrc,
                'phone_number' => $request->phone_number,
                'account_status' => config('enums.account_status')['INIT'],
            ]
        );
        $user->roles()->attach($request->roles);
        return $user;
    }
    public static function updateUser($request, $user)
    {
        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email ? $request->email : $user->email,
                'nrc' => $request->nrc,
                'phone_number' => $request->phone_number,
                'account_status' => $request->account_status,
            ]
        );
        $user->roles()->sync($request->roles);

        return $user;
    }

    public static function UacLogCreate($data, $type)
    {
        UacLog::create([
            'maker' => auth()->check() ? auth()->user()->name : "System",
            'payload' => $data,
            'type' => $type,
        ]);
    }
}
