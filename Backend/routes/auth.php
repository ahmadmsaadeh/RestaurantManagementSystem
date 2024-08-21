<?php

//all users login dynamically
use App\Http\Controllers\LogInController;
use App\Http\Controllers\LogOutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('login', [LogInController::class, 'login'])->name('login');
    Route::post('logout',[LogOutController::class, 'logout'])->name('logout');
    Route::post('forgetpassword', [AuthController::class, 'forgetpassword'])->name('forgetpassword');

    //here we have 2 type of user customer and staff ->
    // staff can't sign up directly the admin should give them there account so this one for customer

    //customer
    Route::post('registercustomer', [AuthController::class, 'registercustomer']);

    //staff
    Route::post('registerstaff', [AuthController::class, 'registerStaff'])->name('register.staff');

});
