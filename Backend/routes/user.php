<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//List of users if need:
Route::get('/users', [UsersController::class, 'getAllUsers']);

//Here we get user by id, to get all information and use it as needed
Route::get('/users/{id}', [UsersController::class, 'getUserById']);

//Here we get the user by role id for admin to see all staff or customers by id
Route::get('/users/role/{role_id}', [UsersController::class, 'getUserByRoleId']);

//Here the users can update there information
Route::put('/users/{id}', [UsersController::class, 'updateUser']);

//Here can delete there accounts directly
Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);
