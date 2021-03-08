<?php

use App\Http\Controllers\Api\v1\AssetApiController;
use App\Http\Controllers\Api\v1\AssetTypeApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\CustomerApiController;
use App\Http\Controllers\Api\v1\LoginApiController;
use App\Http\Controllers\Api\v1\PermissionApiController;
use App\Http\Controllers\Api\v1\ProductApiController;
use App\Http\Controllers\Api\v1\RoleApiController;
use App\Http\Controllers\Api\v1\SaleApiController;
use App\Http\Controllers\Api\v1\SendEmailApiController;
use App\Http\Controllers\Api\v1\SupplierApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use App\Http\Controllers\UacLogController;
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
    Route::resource('users/union/admin/team', UserApiController::class);
    //Forget Api
    Route::post('forget-password', [UserApiController::class, 'forgetPassword']);

    Route::middleware(['auth:sanctum', 'gate'])->group(function () {
        //Change Password
        Route::post('change-password', [UserApiController::class, 'oldPasswordChange']);
        //Role
        Route::get('me', [UserApiController::class, 'myProfile']);

        Route::apiResource('roles', RoleApiController::class);
        Route::post('roles/query', [RoleApiController::class, 'query']);

        //Permission
        Route::apiResource('permissions', PermissionApiController::class);
        Route::post('permissions/query', [PermissionApiController::class, 'query']);

        //User
        Route::resource('users', UserApiController::class);
        Route::post('uacLogs/query', [UacLogController::class, 'query']);

        Route::post('users/query', [UserApiController::class, 'query']);

        //Customer
        Route::resource('customers', CustomerApiController::class);
        Route::post('customers/query', [CustomerApiController::class, 'query']);

        //Supplier
        Route::resource('suppliers', SupplierApiController::class);
        Route::post('suppliers/query', [SupplierApiController::class, 'query']);

        //AssetType
        Route::resource('asset_types', AssetTypeApiController::class);
        Route::post('asset_types/query', [AssetTypeApiController::class, 'query']);

        //Asset
        Route::resource('assets', AssetApiController::class);
        Route::post('assets/query', [AssetApiController::class, 'query']);

        //Product
        Route::resource('products', ProductApiController::class);
        //Product Price Delete
        Route::post('products/delete', [ProductApiController::class, 'productPriceDelete']);
        Route::post('products/query', [ProductApiController::class, 'query']);

        Route::resource('categories', CategoryApiController::class);
        Route::post('categories/query', [CategoryApiController::class, 'query']);

        //Sale Product
        Route::resource('sales', SaleApiController::class);

        Route::post('sales/completePayment', [SaleApiController::class, 'completePayment']);

        //Send Email
        Route::post('send_email', [SendEmailApiController::class, 'sendEmail']);
    });
});

Route::get('test', function () {
    return "Hello Testing CI/CD again & again";
});
