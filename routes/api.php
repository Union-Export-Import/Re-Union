<?php

use App\Http\Controllers\Api\v1\PermissionApiController;
use App\Http\Controllers\Api\v1\RoleApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([],function () {
    //User
    Route::resource('users', UserApiController::class);
    // Route::post('user-update/{id}',[UserApiController::class,'update']);
    //Permission
    Route::apiResource('permissions', PermissionApiController::class);

    //Role
    Route::apiResource('roles', RoleApiController::class);
});
