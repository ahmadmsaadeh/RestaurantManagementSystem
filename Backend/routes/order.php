<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/createOrder', [OrdersController::class, 'createOrder']);
Route::get('/orders/{id}', [OrdersController::class, 'getOrder']);
Route::get('/orders', [OrdersController::class, 'listOrders']);
Route::put('/orders/{id}', [OrdersController::class, 'updateOrder']);




