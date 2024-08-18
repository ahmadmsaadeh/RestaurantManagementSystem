<?php
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/feedbacks', [FeedbackController::class, 'getAllFeedback']);
    Route::post('/feedbacks', [FeedbackController::class, 'addFeedback']);
    Route::get('/feedbacks/{id}', [FeedbackController::class, 'getFeedback']);
    Route::put('/feedbacks/{id}', [FeedbackController::class, 'updateFeedback']);
    Route::delete('/feedbacks/{id}', [FeedbackController::class, 'deleteFeedback']);
});
