<?php

/**
 * @author Tala Yaseen
 */

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Feedback;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reports/sales-monthly",
     *     summary="Get Monthly Sales",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="month", type="integer"),
     *                 @OA\Property(property="total", type="number", format="float")
     *             )
     *         )
     *     )
     * )
     */
    public function getMonthlySales()
    {
        $sales = Order::selectRaw('MONTH(order_date) as month, SUM(total) as total')
            ->groupBy('month')
            ->get();
        return response()->json($sales);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/sales-yearly",
     *     summary="Get Yearly Sales",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="year", type="integer"),
     *                 @OA\Property(property="total", type="number", format="float")
     *             )
     *         )
     *     )
     * )
     */
    public function getYearlySales()
    {
        $sales = Order::selectRaw('YEAR(order_date) as year, SUM(total) as total')
            ->groupBy('year')
            ->get();
        return response()->json($sales);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/menu-item-count",
     *     summary="Get menu item orders count",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="ordersCount", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function getMenuItemOrders()
    {
        $menuItems = MenuItem::select('name_item as name', DB::raw('COUNT(order_items.menu_item_id) as ordersCount'))
            ->join('order_items', 'menu_items.menu_item_id', '=', 'order_items.menu_item_id')
            ->groupBy('menu_items.name_item')
            ->get();
        return response()->json($menuItems);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/feedback-tracking",
     *     summary="Get feedback tracking (average per month)",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="month", type="integer"),
     *                 @OA\Property(property="averageScore", type="number", format="float")
     *             )
     *         )
     *     )
     * )
     */
    public function getFeedbackAverage()
    {
        $feedbacks = Feedback::selectRaw('MONTH(date_submitted) as month, AVG(rating) as averageScore')
            ->groupBy('month')
            ->get();
        return response()->json($feedbacks);
    }
}
