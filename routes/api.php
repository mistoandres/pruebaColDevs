<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\ReservasController;

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

Route::prefix('tours')->group(function () {
    Route::get('/', [ToursController::class, 'get']);
    Route::post('/create', [ToursController::class, 'create']);
    Route::get('/{id}', [ToursController::class, 'getById']);
    Route::put('/{id}', [ToursController::class, 'update']);
    Route::delete('/{id}', [ToursController::class, 'delete']);
});

Route::prefix('reservas')->group(function () {
    Route::post('/create', [ReservasController::class, 'create']);
    Route::get('/{usuario}', [ReservasController::class, 'getByUsuario']);
    Route::delete('/{id}', [ReservasController::class, 'delete']);
});
