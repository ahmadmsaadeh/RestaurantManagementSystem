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

