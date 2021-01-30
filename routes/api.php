<?php

use App\Http\Controllers\Api\v1\AssetApiController;
use App\Http\Controllers\Api\V1\AssetTypeApiController;
use App\Http\Controllers\Api\v1\CustomerApiController;
use App\Http\Controllers\Api\v1\LoginApiController;
use App\Http\Controllers\Api\v1\PermissionApiController;
use App\Http\Controllers\Api\v1\RoleApiController;
use App\Http\Controllers\Api\v1\SupplierApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use App\Models\Asset;
use App\Models\Permission;
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
Route::group([], function () {
    // Route::post('user-update/{id}',[UserApiController::class,'update']);
    Route::post('login', [LoginApiController::class, 'login']);
    Route::post('change-password', [UserApiController::class, 'oldPasswordChange']);
    Route::resource('users/union/admin/team', UserApiController::class);
    //Forget Api
    Route::post('forget-password', [UserApiController::class, 'forgetPassword']);

    Route::middleware(['auth:sanctum'])->group(function () {
        //Role
        Route::get('me', [UserApiController::class, 'myProfile']);

        Route::apiResource('roles', RoleApiController::class);
        Route::post('roles/query', [RoleApiController::class, 'query']);

        //Permission
        Route::apiResource('permissions', PermissionApiController::class);
        Route::post('permissions/query', [PermissionApiController::class, 'query']);

        //User
        Route::resource('users', UserApiController::class);
        Route::post('users/query', [UserApiController::class, 'query']);


        //Customer
        Route::resource('customers', CustomerApiController::class);

        //Supplier
        Route::resource('suppliers', SupplierApiController::class);

        //AssetType
        Route::resource('asset_types', AssetTypeApiController::class);

        //Asset
        Route::resource('assets', AssetApiController::class);

    });
});
