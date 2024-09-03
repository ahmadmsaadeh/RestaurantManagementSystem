<?php
/**
 * @author Tala Yaseen
 */

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FeedbackController;

    Route::get('/feedbacks', [FeedbackController::class, 'getAllFeedback']);
    Route::post('/feedbacks', [FeedbackController::class, 'addFeedback']);
    Route::get('/feedbacks/{id}', [FeedbackController::class, 'getFeedback']);
    Route::put('/feedbacks/{id}', [FeedbackController::class, 'updateFeedback']);
    Route::delete('/feedbacks/{id}', [FeedbackController::class, 'deleteFeedback']);
    Route::get('feedbacks/item/{menu_item_id}', [FeedbackController::class, 'getItemFeedback']);
    Route::get('/feedbacks/user/{userId}', [FeedbackController::class, 'getFeedbacksByUser']);


    