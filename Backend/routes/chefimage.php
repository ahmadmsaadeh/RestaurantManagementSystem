<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/chef', [UsersController::class, 'getChefByRole']);
Route::get('/chef/{id}', [UsersController::class, 'getChefById']);
