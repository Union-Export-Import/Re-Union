<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // use ResponserTrait;
    // public function login(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();


    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return $this->loginFailed('invalid email or password');
    //     } else {
    //         $token = $user->createToken('login-user')->plainTextToken;

    //         $user->token = $token;

    //         // return $this->respondCollection('success', $user);
    //         return $user->response
    //     }
    // }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = User::where('email', request(['email']))->first();

        return $this->respondWithToken($token, $user);
    }
}
