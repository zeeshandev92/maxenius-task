<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransferProductController;
use Illuminate\Support\Facades\Route;


Route::middleware(['verify.shopify', 'billable'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/ebay-products', [HomeController::class, 'ebayProducts'])->name('ebay.get-products');

    
    Route::resource('transfer-product', TransferProductController::class)->only(['index', 'store']);
});
