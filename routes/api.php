<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
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
        Route::post('register', RegisterController::class)->name('register');
        Route::post('login', LoginController::class)->name('login');
        Route::post('otp/generate', [AuthOtpController::class, 'generate'])->name('otp.generate');
        Route::post('otp/login', [AuthOtpController::class, 'loginWithOtp'])->name('otp.login');
    });

    Route::middleware('web')->group(function () {
        Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
        Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', LogoutController::class)->name('logout');
        Route::post('update_sellers', [SellerController::class, 'activate'])->name('seller.activate');
        //Shops
        Route::get('shop_clients/{shop}', [ShopController::class, 'shop_clients'])->name('shop-clients');
        Route::get('shop_products/{shop}', [ShopController::class, 'shop_products'])->name('shop-products');
        Route::get('user_shops', [ShopController::class, 'user_shops'])->name('user-shops');
        Route::middleware('owner')->group(function () {
            Route::apiResource('shops', ShopController::class)->except('index');
            //Sellers
            Route::get('shop_sellers/{shop}', [ShopController::class, 'shop_sellers'])->name('shop-sellers');
            Route::post('sellers', [SellerController::class, 'store'])->name('seller.store');
            Route::delete('sellers/{seller}', [SellerController::class, 'destroy'])->name('seller.destroy');
        });
        //Clients
        Route::apiResource('clients', ClientController::class)->except('index');
        //Debts
        Route::apiResource('debts', DebtController::class)->except('index');
        //Products
        Route::apiResource('products', ProductController::class)->except('index');
        //Contacts
        Route::post('import_contacts', [ContactController::class, 'import'])->name('import-contacts');
        Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contact.update');
        Route::delete('contacts/{contact}', [ContactController::class, 'delete'])->name('contact.delete');
        //Search
        Route::get('main_search', [SearchController::class, 'main_search'])->name('main_search');
        Route::get('search_contacts', [ContactController::class, 'search_contact'])->name('search-contact');
        Route::get('search_debt', [DebtController::class, 'search_debt'])->name('search-debt');
        Route::get('search_clients', [ClientController::class, 'search_client'])->name('search-client');

    });
});
