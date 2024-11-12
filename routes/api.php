<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Api\Http\Controllers\ProdutoController;
use App\Domain\Api\Http\Controllers\ApiStatusController;

Route::get('/', [ApiStatusController::class, 'status'])->name('api.status');

Route::prefix('products')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('products.index');
    Route::get('/{codigo}', [ProdutoController::class, 'show'])->name('products.show');
    Route::get('/products/search', [ProdutoController::class, 'search'])->name('products.search');
    Route::put('/{codigo}', [ProdutoController::class, 'update'])->name('products.update');
    Route::delete('/{codigo}', [ProdutoController::class, 'destroy'])->name('products.destroy');
});
