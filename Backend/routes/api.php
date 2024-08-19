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

require base_path('routes/order.php');

require base_path('routes/auth.php');
require base_path('routes/user.php');
require base_path('routes/role.php');

