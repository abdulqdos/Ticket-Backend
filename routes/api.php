<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});


Route::prefix('customers')->as('api.customer.')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::middleware('auth:sanctum')->group(function () {
            Route::put('/{customer}/edit', [AuthController::class, 'update'])->name('update');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });
});
