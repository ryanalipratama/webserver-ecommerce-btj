<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\PaymentController;
// Register
Route::post("register", [ApiController::class, "register"]);

// Login
Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    // profil
    Route::get("profile", [ApiController::class, "profile"]);

    //  update
    Route::post("profile/update", [ApiController::class, "updateProfile"]);

    // logout
    Route::get("logout", [ApiController::class, "logout"]);

    // cart
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);
    Route::put('cart/{id}', [CartController::class, 'update']);

    // Rute untuk pengguna mengirim pesan ke admin
    Route::post('send-message/user', [ChatController::class, 'sendMessageFromUser']);

    
    // Rute untuk user mendapatkan pesan dengan admin
    Route::get('user-messages', [ChatController::class, 'getUserMessages']);

});

Route::middleware(['auth:sanctum'])->post('payment/create', [PaymentController::class, 'createTransaction']);

// Rute untuk admin mengirim pesan ke pengguna
Route::post('send-message/admin', [ChatController::class, 'sendMessageFromAdmin']);
// Rute untuk admin mendapatkan pesan dengan semua user
Route::get('admin-messages', [ChatController::class, 'getAdminMessages']);

// Banner
Route::get('banner', [BannerController::class, 'index']);
Route::post('banner', [BannerController::class, 'store']);
Route::post('banner/{id}', [BannerController::class, 'update']);
Route::delete('banner/{id}', [BannerController::class, 'destroy']);

// Produk
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::post('/produk/{id}', [ProdukController::class, 'update']);
Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
Route::get('/produk/by-category/{kategori_id}', [ProdukController::class, 'indexByCategory']);

// Kategori
Route::get('kategori', [KategoriController::class, 'index']);
Route::post('kategori', [KategoriController::class, 'store']);
Route::put('kategori/{id}', [KategoriController::class, 'update']);
Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);

// Midtrans Routes
Route::post('payment/notification', [PaymentController::class, 'paymentNotification']);


/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


