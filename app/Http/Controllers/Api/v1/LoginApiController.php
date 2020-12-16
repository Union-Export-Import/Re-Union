<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    use ResponserTrait;
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // return $user;
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->respondErrorTokenExpire('invalid email or password');
        } else if ($user && Hash::check($request->password, $user->password) &&  $user->is_password_changed == false) {
            return $this->respondCreateMessageOnly('guest');
        } else{
            $token = $user->createToken('login-user')->plainTextToken;

            $user->token = $token;

            return $this->respondCollection('success', $user);
        }
    }
}
