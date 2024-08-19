<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{user}', [Controller::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [Controller::class, 'updateUser'])->name('users.update');
require base_path('routes/auth.php');
require base_path('routes/user.php');
require base_path('routes/role.php');
