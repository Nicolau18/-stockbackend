<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController; // 1. IMPORTA O CONTROLLER
use App\Http\Controllers\API\StockMovementController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\DashboardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 2. CRIA TODAS AS ROTAS AUTOMÁTICAS DO PRODUTO (index, store, update, destroy, etc.)
Route::apiResource('products', ProductController::class);

Route::apiResource('movements', StockMovementController::class)->only(['index', 'store']);

Route::apiResource('invoices', InvoiceController::class)->only(['index', 'store']);

Route::get('/dashboard/kpis', [DashboardController::class, 'getKPIs']);