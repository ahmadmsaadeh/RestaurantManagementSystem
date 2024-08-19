<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/createOrder', [OrdersController::class, 'createOrder']);
Route::post('/orders/{orderId}/addItem', [OrdersController::class, 'addMenuItemToOrder']);
Route::patch('/orders/{orderId}/items/{itemId}/status', [OrdersController::class, 'updateOrderItemStatus']);
Route::get('/orders', [OrdersController::class, 'listOrders']);

Route::get('/orders', [OrdersController::class, 'listOrders']);
Route::get('/orders/{id}', [OrdersController::class, 'getOrder']);
Route::put('/orders/{id}', [OrdersController::class, 'updateOrder']);
Route::delete('/orders/{id}', [OrdersController::class, 'deleteOrder']);
Route::patch('/orders/{id}/status', [OrdersController::class, 'updateOrderStatus']);
Route::delete('/orders/{orderId}/items/{itemId}', [OrdersController::class, 'removeOrderItem']);

///patch:: update a specific attribute or a small part of the resource without sending the entire resource's data.



