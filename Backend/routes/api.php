<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require base_path('routes/order.php');

require base_path('routes/auth.php');
require base_path('routes/user.php');
require base_path('routes/role.php');

