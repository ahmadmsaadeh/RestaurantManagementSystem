<?php

/**
 * @author Tala Yaseen
 */
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *     schema="Feedback",
 *     type="object",
 *     title="Feedback",
 *     required={"order_id", "menu_item_id", "customer_id", "rating", "comments"},
 *     @OA\Property(property="order_id", type="integer", example=1),
 *     @OA\Property(property="menu_item_id", type="integer", example=1),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="rating", type="integer", example=5),
 *     @OA\Property(property="comments", type="string", example="Great service!"),
 *     @OA\Property(property="date_submitted", type="string", format="date-time", example="2024-08-18 10:00:00"),
 * )
 */

class FeedbackController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/feedbacks",
 *     summary="Get list of all feedbacks with customer and menu item details",
 *     description="Fetches all feedback entries with related customer username and menu item name. The customer username and menu item name are included if available.",
 *     tags={"Feedbacks"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="feedback_id", type="integer", example=1),
 *                 @OA\Property(property="order_id", type="integer", example=101),
 *                 @OA\Property(property="customer_name", type="string", example="John Doe"),
 *                 @OA\Property(property="menu_item_name", type="string", example="Cheeseburger"),
 *                 @OA\Property(property="rating", type="integer", example=5),
 *                 @OA\Property(property="comments", type="string", example="Delicious!"),
 *                 @OA\Property(property="date_submitted", type="string", format="date-time", example="2024-09-01 12:00:00")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
public function getAllFeedback()
{
    $feedbacks = Feedback::with(['customer', 'menuItem'])
        ->get()
        ->map(function ($feedback) {
            return [
                'feedback_id' => $feedback->feedback_id,
                'order_id' => $feedback->order_id,
                'customer_name' => optional($feedback->customer)->username, // Fetching username from related User model
                'menu_item_name' => optional($feedback->menuItem)->name_item, // Fetching item name from related MenuItem model
                'rating' => $feedback->rating,
                'comments' => $feedback->comments,
                'date_submitted' => $feedback->date_submitted,
            ];
        });

    return response()->json($feedbacks);
}

    public function addFeedback(Request $request)
    {
        $feedback = Feedback::create($request->all());
        return response()->json($feedback, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/feedbacks/{id}",
     *     summary="Get feedback by ID",
     *     tags={"Feedbacks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Feedback ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function getFeedback($id)
    {
        return Feedback::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/feedbacks/{id}",
     *     summary="Update feedback by ID",
     *     tags={"Feedbacks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Feedback ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Feedback")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Feedback updated successfully",
     *     )
     * )
     */
    public function updateFeedback(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update($request->all());
        return response()->json($feedback, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/feedbacks/{id}",
     *     summary="Delete feedback by ID",
     *     tags={"Feedbacks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Feedback ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Feedback deleted successfully",
     *     )
     * )
     */
    public function deleteFeedback($id)
    {
        Feedback::findOrFail($id)->delete();
        return response()->json(null, 204);
    }


    /**
 * @OA\Get(
 *     path="/api/feedbacks/item/{menu_item_id}",
 *     summary="Get feedback for a specific menu item",
 *     description="Fetches the average rating and comments for a specific menu item based on the menu item ID.",
 *     tags={"Feedbacks"},
 *     @OA\Parameter(
 *         name="menu_item_id",
 *         in="path",
 *         required=true,
 *         description="ID of the menu item for which feedback is being fetched",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="average_rating",
 *                 type="number",
 *                 format="float",
 *                 description="Average rating for the menu item",
 *                 example=4.5
 *             ),
 *             @OA\Property(
 *                 property="comments",
 *                 type="array",
 *                 description="List of comments for the menu item",
 *                 @OA\Items(
 *                     type="string",
 *                     example="The food was amazing!"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Menu item not found",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

 
public function getItemFeedback($menu_item_id)
{

    $feedbacks = Feedback::where('menu_item_id', $menu_item_id)->get();


    $averageRating = $feedbacks->avg('rating');


    return response()->json([
        'average_rating' => $averageRating,
        'comments' => $feedbacks->pluck('comments')
    ]);
}

/**
 * @OA\Get(
 *     path="/api/feedbacks/user/{userId}",
 *     summary="Get feedbacks by user ID",
 *     description="Fetches all feedback entries related to a specific user based on their user ID. The feedback includes details such as order ID, customer name, menu item name, rating, comments, and date submitted.",
 *     tags={"Feedbacks"},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         description="ID of the user to retrieve feedback for",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="feedback_id", type="integer", example=1),
 *                 @OA\Property(property="order_id", type="integer", example=101),
 *                 @OA\Property(property="customer_name", type="string", example="John Doe"),
 *                 @OA\Property(property="menu_item_name", type="string", example="Cheeseburger"),
 *                 @OA\Property(property="rating", type="integer", example=5),
 *                 @OA\Property(property="comments", type="string", example="Delicious!"),
 *                 @OA\Property(property="date_submitted", type="string", format="date-time", example="2024-09-01 12:00:00")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 *
 * Fetches all feedbacks associated with a given user ID. It joins feedback with the related customer and menu item details. If the customer or menu item is missing, it handles the null value using `optional()`.
 *
 * @param int $userId The ID of the user whose feedback is to be retrieved.
 * @return \Illuminate\Http\JsonResponse A JSON response containing the feedback data.
 */
public function getFeedbacksByUser($userId)
{
    $feedbacks = Feedback::where('customer_id', $userId)
        ->with(['customer', 'menuItem'])
        ->get()
        ->map(function ($feedback) {
            return [
                'feedback_id' => $feedback->feedback_id,
                'order_id' => $feedback->order_id,
                'customer_name' => optional($feedback->customer)->username, // Fetching username from related User model
                'menu_item_name' => optional($feedback->menuItem)->name_item, // Fetching item name from related MenuItem model
                'rating' => $feedback->rating,
                'comments' => $feedback->comments,
                'date_submitted' => $feedback->date_submitted,
            ];
        });

    return response()->json($feedbacks);
}


}
