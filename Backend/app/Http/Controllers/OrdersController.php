<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
class OrdersController extends Controller
{


    public function createOrder(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,user_id',
            'reservation_id' => 'nullable|exists:reservations,ResID',
        ]);

        // Check if the user_id is associated with the reservation_id
        if (isset($validatedData['user_id']) && isset($validatedData['reservation_id'])) {
            $reservation = Reservation::where('ResID', $validatedData['reservation_id'])
                ->where('UserID', $validatedData['user_id'])
                ->first();

            if (!$reservation) {
                return response()->json(['error' => 'The specified user is not associated with this reservation'], 400);
            }
        }

        // Create the order with default status 'Open' and total=0
        $order = Order::create([
            'user_id' => $validatedData['user_id'] ?? null,
            'reservation_id' => $validatedData['reservation_id'] ?? null,
            'status' => 'Open',  // Set default status
            'total' => 0.00,  // Set default total
        ]);

        if (!$request->has('order_items') || empty($request->order_items)) {
            return response()->json(['error' => 'No items in the order'], 400);
        }

        if (!$order) {
            return response()->json(['error' => 'Order creation failed'], 500);
        }

        $total = 0.00;  // Initialize total

        if ($request->has('order_items')) {  /// ????

            foreach ($request->order_items as $item) {
                if (!isset($item['quantity']) || $item['quantity'] < 1) {
                    return response()->json(['error' => 'Invalid quantity for item'], 400);
                }
                // Fetch the price from the menu_items table
                $menuItem = MenuItem::find($item['menu_item_id']);

                if ($menuItem) {
                    $subtotal = $menuItem->price * $item['quantity']; //calculate subtotal for each item

                    // Store the order items
                    Order_item::create([
                        'order_id' => $order->order_id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                    ]);

                    // Add the subtotal to the total
                    $total += $subtotal;
                } else {
                    // Handle the case where the menu item does not exist
                    return response()->json(['error' => 'Invalid menu item ID'], 400);
                }
            }

            // Update the order with the total amount
            $order->update(['total' => $total]);
            $order->load('orderItems');
        }

        return response()->json(['message' => 'Order created successfully', 'order details' => $order], 201);
    }

    public function addMenuItemToOrder(Request $request, $orderId)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,menu_item_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the order
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Find the menu item
        $menuItem = MenuItem::find($validatedData['menu_item_id']);

        if (!$menuItem) {
            return response()->json(['error' => 'Menu item not found'], 404);
        }

        // Check if the order already has the menu item
        $orderItem = Order_item::where('order_id', $orderId)
            ->where('menu_item_id', $validatedData['menu_item_id'])
            ->first();

        if ($orderItem) {
            // Update the quantity and subtotal if the item exists
            $orderItem->quantity += $validatedData['quantity'];
            $orderItem->subtotal = $orderItem->quantity * $menuItem->price;
            $orderItem->save();
        } else {
            // Create a new order item if it does not exist
            Order_item::create([
                'order_id' => $orderId,
                'menu_item_id' => $validatedData['menu_item_id'],
                'quantity' => $validatedData['quantity'],
                'subtotal' => $validatedData['quantity'] * $menuItem->price,
            ]);
        }

        // Update the total of the order
        $total = Order_item::where('order_id', $orderId)->sum('subtotal');
        $order->total = $total;
        $order->save();

        return response()->json(['message' => 'Menu item added to order successfully'], 200);
    }
    public function updateOrderItemStatus(Request $request, $orderId, $itemId)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'status' => 'required|string|in:Pending,In-progress,Completed,Served', // Ensure status is one of the defined values
        ]);

        // Find the order item
        $orderItem = Order_item::where('order_id', $orderId)
            ->where('menu_item_id', $itemId) // Ensure 'order_item_id' matches the column name in your `order_items` table
            ->first();

        if (!$orderItem) {
            return response()->json(['error' => 'Order item not found'], 404);
        }

        // Update the status
        $orderItem->item_status = $validatedData['status'];
        $orderItem->save();

        return response()->json(['message' => 'Order item status updated successfully'], 200);
    }
}
