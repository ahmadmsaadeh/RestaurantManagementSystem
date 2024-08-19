<?php

/**
 * @author Tala Yaseen
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="FeedbackResponse",
 *     type="object",
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="data", ref="#/components/schemas/FeedbackRequest")
 * )
 */
/**
 * @OA\Tag(
 *     name="Reports",
 *     description="Endpoints for generating various reports"
 * )
 */
class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/reports/sales-monthly",
     *     summary="Get Monthly Sales",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function getMonthlySales()
    {
        // Implementation
    }

    /**
     * @OA\Get(
     *     path="/reports/sales-yearly",
     *     summary="Get Yearly Sales",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function getYearlySales()
    {
        // Implementation
    }

    /**
     * @OA\Get(
     *     path="/reports/menu-item-count",
     *     summary="Get menu item orders count",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function getMenuItemOrders()
    {
        // Implementation
    }

    /**
     * @OA\Get(
     *     path="/reports/feedback-tracking",
     *     summary="Get feedback tracking (average per month)",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function getFeedbackAverage()
    {
        // Implementation
    }
}
