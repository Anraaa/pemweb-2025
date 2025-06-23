<?php

use App\Http\Controllers\TestController;

use Illuminate\Support\Facades\Route;

Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{id}', [TestController::class, 'show'])->name('tests.show');
Route::post('/tests', [TestController::class, 'store'])->name('tests.store');
Route::put('/tests/{id}', [TestController::class, 'update'])->name('tests.update');
Route::delete('/tests/{id}', [TestController::class, 'destroy'])->name('tests.destroy');