<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function createOrder(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,user_id',
            'reservation_id' => 'nullable|exists:reservations,ResID',
            'order_items' => 'required|array',
            'order_items.*.menu_item_id' => 'required|exists:menu_items,menu_item_id',
            'order_items.*.quantity' => 'required|integer|min:1',
        ]);

        // Initialize total and order items
        $total = 0;
        $orderItems = [];

        foreach ($validatedData['order_items'] as $item) {
            // Find the menu item by its ID
            $menuItem = MenuItem::find($item['menu_item_id']);

            if (!$menuItem) {
                return response()->json([
                    'message' => 'Menu item not found',
                ], 404);
            }

            // Calculate subtotal
            $subtotal = $item['quantity'] * $menuItem->price;
            $total += $subtotal;
            $orderItems[] = [
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $menuItem->price,
                'subtotal' => $subtotal,
            ];
        }

        // Create the order
        $order = Order::create([
            'user_id' => $validatedData['user_id'] ?? null,
            'reservation_id' => $validatedData['reservation_id'] ?? null,
            'total' => $total, // Set total to sum of subtotals
            'status' => 'Open', // Default status
        ]);

        // Store order items
        foreach ($orderItems as $item) {
            $order->orderItems()->create([
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Return the created order with a 201 status code
        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }

}
