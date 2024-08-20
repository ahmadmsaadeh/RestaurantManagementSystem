<?php

//all users login dynamically
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout',[AuthController::class, 'logout'])->name('logout');
    Route::post('forgetpassword', [AuthController::class, 'forgetpassword'])->name('forgetpassword');

    //here we have 2 type of user customer and staff ->
    // staff can't sign up directly the admin should give them there account so this one for customer

    //customer
    Route::post('register/registercustomer', [AuthController::class, 'registercustomer']);

    //staff
    Route::post('register/registerstaff', [AuthController::class, 'registerStaff'])->name('register.staff');

});
