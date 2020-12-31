<?php

namespace App\Services;

use App\Models\UacLog;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserApiService
{


    public static function manageUser($request, $hashed_random_password, $user = null)
    {
        $user_id = $user && $user->id ? $user->id : null;
        // dd($user);

        try {
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
                    'account_status' => config('enums.account_status')['INIT'],
                ]
            );
            $user->roles()->sync($request->roles);
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:

            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1062) {
                return config('enums.users')['DUP'];// houston, we have a duplicate entry problem
            }
            // Return the response to the client..
        }

        // $user->permissions()->sync($request->permissions);

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
