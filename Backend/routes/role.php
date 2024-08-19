<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//push it

//for Admin:
//Here we can get the role name to see the user role
Route::get('/roles/{role_name}', [RolesController::class, 'getRoleByname']);

//get all roles
Route::get('/roles', [RolesController::class, 'getAllRoles']);

//get role by id
Route::get('/roles/role/{role_id}', [RolesController::class, 'getById']);

//create role
Route::post('/roles/create/role', [RolesController::class, 'createRole']);

//delete role
Route::delete('/roles/delete/{role_id}', [RolesController::class, 'deleteRole']);

//update role
Route::put('/roles/update/{role_id}', [RolesController::class, 'updateRole']);
