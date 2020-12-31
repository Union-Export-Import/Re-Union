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

        if ($user && Hash::check($request->password, $user->password) && $user->account_status == config('enums.account_status')['INIT']) {
            return $this->respondCreateMessageOnly(config('enums.account_status')['INIT']);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->respondErrorTokenExpire('invalid email or password');
        } else {
            $token = $user->createToken('login-user')->plainTextToken;

            $user->token = $token;

            return $this->respondCollection('success', $user);
        }
    }
}
