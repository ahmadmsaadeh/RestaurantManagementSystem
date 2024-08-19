<?php

/**
 * @author Tala Yaseen
 */
use Illuminate\Support\Facades\Route;

Route::get('/reports/sales-monthly', 'App\Http\Controllers\ReportController@getMonthlySales');
Route::get('/reports/sales-yearly', 'App\Http\Controllers\ReportController@getYearlySales');
Route::get('/reports/menu-item-count', 'App\Http\Controllers\ReportController@getMenuItemOrderCount');
Route::get('/reports/feedback-tracking', 'App\Http\Controllers\ReportController@getFeedbackTracking');
