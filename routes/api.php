<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    Route::middleware('guest:sanctum')->group(function () {
        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);
    });

    Route::middleware('web')->group(function () {
        Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
        Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', LogoutController::class);
        Route::post('update_sellers', [SellerController::class, 'activate']);
        Route::get('shop_clients/{shop}', [ShopController::class, 'shop_clients']);
        Route::get('shop_products/{shop}', [ShopController::class, 'shop_products']);
        //Shops
        Route::middleware('owner')->group(function () {
            Route::apiResource('shops', ShopController::class)->except('index');
            //Sellers
            Route::get('shop_sellers/{shop}', [ShopController::class, 'shop_sellers']);
            Route::post('sellers', [SellerController::class, 'store']);
            Route::delete('sellers/{seller}', [SellerController::class, 'destroy']);
        });
        //Clients
        Route::apiResource('clients', ClientController::class)->except('index');
        //Debts
        Route::apiResource('debts', DebtController::class)->except('index');
        //Products
        Route::apiResource('products', ProductController::class)->except('index');
        //Contacts
        Route::post('import_contacts', [ContactController::class, 'import'])->name('import');
    });
});
