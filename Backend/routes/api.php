<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * @author Ibtisam
 *
 */

Route::get('/menu-items', [MenuItemController::class, 'getMenuitem']);
Route::get('/menu-items/{id}', [MenuItemController::class, 'getMenuItemById']);

Route::post('/menu-items', [MenuItemController::class, 'createMenuItem']);  // end
Route::post('/menu-items', [MenuItemController::class, 'createMenuItem']);

//new
Route::put('/menu-items/{id}', [MenuItemController::class, 'updateMenuItem']);
Route::delete('/menu-items/{id}', [MenuItemController::class, 'deleteMenuItem']);

//
Route::get('/menu-items/category/{category_id}', [MenuItemController::class, 'getMenuItemsByCategory']);
Route::get('/menu-items/ad/{availability}', [MenuItemController::class, 'getAvailableMenuItems']);
Route::get('/menu-items/price', [MenuItemController::class, 'getMenuItemPrice']);

Route::post('/menu-items/{id}/upload-image', [MenuItemController::class, 'uploadMenuItemImage']);
//Route::get('/menu-items/price', [MenuItemController::class, 'getMenuItemPrice']);



require base_path('routes/order.php');

require base_path('routes/feedback.php');
require base_path('routes/reports.php');
require base_path('routes/user.php');
require base_path('routes/role.php');
require base_path('routes/reservation.php');
require base_path('routes/tables.php');
