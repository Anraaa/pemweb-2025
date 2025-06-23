<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{id}', [TestController::class, 'show'])->name('tests.show');
Route::post('/tests', [TestController::class, 'store'])->name('tests.store');
Route::put('/tests/{id}', [TestController::class, 'update'])->name('tests.update');
Route::delete('/tests/{id}', [TestController::class, 'destroy'])->name('tests.destroy');

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/decrypts', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');