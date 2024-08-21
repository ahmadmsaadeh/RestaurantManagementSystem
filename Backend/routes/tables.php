<?php

/**
 * @file Routes for handling table-related operations.
 *
 * @author Ahmad Saadeh
 */

use App\Http\Controllers\TablesController;
use Illuminate\Support\Facades\Route;

Route::get('/tables', [TablesController::class, 'getAllTables']);
Route::get('/tables/{id}', [TablesController::class, 'getTable']);
Route::post('/tables/{NumberOfChairs}', [TablesController::class, 'addTable']);
Route::delete('/tables/{id}', [TablesController::class, 'deleteTable']);
