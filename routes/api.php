<?php

use App\Http\Controllers\Api\FishMenuController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Fish Menu API Routes (public)
Route::prefix('menu')->group(function () {
    Route::get('/', [FishMenuController::class, 'index'])->name('api.menu.index');
    Route::get('/catch-of-day', [FishMenuController::class, 'catchOfDay'])->name('api.menu.catch-of-day');
    Route::get('/{menuId}', [FishMenuController::class, 'show'])->name('api.menu.show');
});

// Stock Management API Routes (protected - requires authentication)
Route::middleware(['auth:sanctum'])->prefix('stock')->group(function () {
    Route::get('/{menuItemId}', [StockController::class, 'show'])->name('api.stock.show');
    Route::put('/{menuItemId}', [StockController::class, 'update'])->name('api.stock.update');
    Route::get('/{menuItemId}/history', [StockController::class, 'history'])->name('api.stock.history');
    Route::post('/batch', [StockController::class, 'batchUpdate'])->name('api.stock.batch');
});
