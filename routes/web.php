<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\HomeAdminController;
use App\Http\Controllers\Api\KategoriAdminController;
use App\Http\Controllers\Api\GetUserController;
use App\Http\Controllers\Api\BannerAdminController;
use App\Http\Controllers\Api\ChatAdminController;
use App\Http\Controllers\Api\StrukAdminController;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/produk', [HomeAdminController::class, 'index'])->name('index');
    Route::get('/create', [HomeAdminController::class, 'create'])->name('produk.create');
    Route::post('/store', [HomeAdminController::class, 'store'])->name('produk.store');
    Route::get('/edit/{id}', [HomeAdminController::class, 'edit'])->name('produk.edit');
    Route::post('/update/{id}', [HomeAdminController::class, 'update'])->name('produk.update');
    Route::delete('/delete/{id}', [HomeAdminController::class, 'delete'])->name('produk.delete');

    Route::get('/banner', [BannerAdminController::class, 'getBanner'])->name('getbanner');
    Route::get('/banner_create', [BannerAdminController::class, 'createbanner'])->name('banner.create');
    Route::post('/banner_store', [BannerAdminController::class, 'banner_store'])->name('banner.store');
    Route::get('/banner_edit/{id}', [BannerAdminController::class, 'banner_edit'])->name('banner.edit');
    Route::post('/banner_update/{id}', [BannerAdminController::class, 'banner_update'])->name('banner.update');
    Route::delete('/banner_delete/{id}', [BannerAdminController::class, 'banner_delete'])->name('banner.delete');

    Route::get('/kategori', [KategoriAdminController::class, 'getKategori'])->name('getkategori');
    Route::get('/kategori_create', [KategoriAdminController::class, 'createkategori'])->name('kategori.create');
    Route::post('/kategori_store', [KategoriAdminController::class, 'kategori_store'])->name('kategori.store');
    Route::get('/kategori_edit/{id}', [KategoriAdminController::class, 'kategori_edit'])->name('kategori.edit');
    Route::post('/Kategori_update/{id}', [KategoriAdminController::class, 'kategori_update'])->name('kategori.update');
    Route::delete('/kategori_delete/{id}', [KategoriAdminController::class, 'kategori_delete'])->name('kategori.delete');

    Route::get('/getuser', [GetUserController::class, 'getUser'])->name('getuser');
    Route::get('/chat/{userId}', [ChatAdminController::class, 'showChat'])->name('chat');
    Route::post('send-message/admin', [ChatAdminController::class, 'sendMessageFromAdmin'])->name('sendMessageAdmin');
    Route::get('/check-new-messages', [ChatAdminController::class, 'checkNewMessages'])->name('check-new-messages');
});