<?php

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
     *     path="/feedbacks",
     *     summary="Get list of feedbacks",
     *     tags={"Feedbacks"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function getAllFeedback()
    {
        return Feedback::all();
    }

    /**
     * @OA\Post(
     *     path="/feedbacks",
     *     summary="Create a new feedback",
     *     tags={"Feedbacks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Feedback")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Feedback created successfully",
     *     )
     * )
     */
    public function addFeedback(Request $request)
    {
        $feedback = Feedback::create($request->all());
        return response()->json($feedback, 201);
    }

    /**
     * @OA\Get(
     *     path="/feedbacks/{id}",
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
     *     path="/feedbacks/{id}",
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
     *     path="/feedbacks/{id}",
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
}
