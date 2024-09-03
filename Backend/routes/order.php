<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Staff + Admin --> swaggers done
Route::post('/orders/createOrder', [OrdersController::class, 'createOrder']);
Route::put('/orders/{orderId}/addItem', [OrdersController::class, 'addMenuItemToOrder']);
Route::patch('/orders/{orderId}/items/{itemId}/status', [OrdersController::class, 'updateOrderItemStatus']);
Route::patch('/orders/{orderId}/status', [OrdersController::class, 'updateOrderStatus']);


Route::get('/orders', [OrdersController::class, 'listOrders']);
Route::get('/orders/{orderId}', [OrdersController::class, 'getOrderById']);
Route::get('/orders/user/{userId}', [OrdersController::class, 'getOrderByUserId']);
Route::get('/orders/reservation/{reservationId}', [OrdersController::class, 'getOrderByReservationId']);
Route::get('/orders/date/{date}', [OrdersController::class, 'getOrderByDate']);
Route::get('/orders/date-range/{startDate}/{endDate}', [OrdersController::class, 'getOrdersByDateRange']);
Route::get('/orders/status/{status}', [OrdersController::class, 'getOrderByStatus']);

/////filterrrr
Route::get('/orders/filter', [OrdersController::class, 'getFilteredOrders']);


Route::get('/orders/items/status/{status}', [OrdersController::class, 'getOrderItemsByStatus']);
Route::get('/orders/{orderId}/items', [OrdersController::class, 'getOrderItems']);

Route::delete('/orders/{orderId}', [OrdersController::class, 'deleteOrder']);
Route::delete('/orders/{orderId}/items/{itemId}', [OrdersController::class, 'removeMenuItemFromOrder']);




