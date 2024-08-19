<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//TODO: Add Authentication For User
//TODO: If The UserType Is Staff The Routes Should Be Handled Another Way


//TODO: Add Middleware for this set of routes to be for customers
Route::get('/reservations', [ReservationController::class, 'getAllUsersReservations']);
Route::post('/reservations/{user_id}/{Date}/{time}/{numOfCustomers}/{ReservationType}', [ReservationController::class, 'addReservation']);
Route::patch('/reservations/{reservationID}', [ReservationController::class, 'updateReservation']);
Route::delete('/reservations/{reservationID}', [ReservationController::class, 'deleteReservation']);
Route::get('/reservations/date/{Date}', [ReservationController::class, 'getReservationByDate']);
Route::get('/reservations/date/{Date}/time/{time}', [ReservationController::class, 'getReservationByTime']);
Route::get('/reservations/id/{ReservationID}', [ReservationController::class, 'getReservationByID']);


//TODO: Add Middleware for this set of routes to be for stuff
Route::get('/staff/reservations', [ReservationController::class, 'getAllUsersReservations']);
Route::get('/staff/reservations/{user_id}', [ReservationController::class, 'getAllReservations']);
Route::get('/staff/reservations/date/{Date}', [ReservationController::class, 'getAllReservationByDate']);
Route::get('/staff/reservations/date/{Date}/time/{time}', [ReservationController::class, 'getAllReservationByTime']);
Route::get('/staff/reservations/id/{ReservationID}', [ReservationController::class, 'getReservationByID']);
Route::post('/staff/reservations/{user_id}/{Date}/{time}/{numOfCustomers}/{ReservationType}', [ReservationController::class, 'addReservationForStaff']);
Route::put('/staff/reservations/{reservationID}', [ReservationController::class, 'updateReservationForStaff']);
Route::delete('/staff/reservations/{reservationID}', [ReservationController::class, 'deleteReservationForStaff']);


