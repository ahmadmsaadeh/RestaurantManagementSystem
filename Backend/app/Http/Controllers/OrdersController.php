<?php
//author: Jood Hamdallah

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrdersController extends Controller
{
 /**
 * @OA\Post(
 *     path="/api/createOrder",
 *     summary="Create a new order",
 *     tags={"Orders"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"order_items"},
 *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user placing the order"),
 *                 @OA\Property(property="reservation_id", type="integer", example=1, description="ID of the reservation for the order"),
 *                 @OA\Property(
 *                     property="order_items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         required={"menu_item_id", "quantity"},
 *                         @OA\Property(property="menu_item_id", type="integer", example=1, description="ID of the menu item"),
 *                         @OA\Property(property="quantity", type="integer", example=2, description="Quantity of the menu item")
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Order created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Order created successfully"),
 *             @OA\Property(
 *                 property="order details",
 *                 type="object",
 *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
 *                 @OA\Property(property="reservation_id", type="integer", example=2, description="ID of the reservation"),
 *                 @OA\Property(property="status", type="string", example="Open", description="Current status of the order"),
 *                 @OA\Property(property="total", type="number", format="float", example=25.98, description="Total amount for the order"),
 *                 @OA\Property(property="order_id", type="integer", example=3, description="ID of the created order"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-19T16:01:16.000000Z", description="Order creation timestamp"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-19T16:01:17.000000Z", description="Order last update timestamp"),
  *                @OA\Property(
  *                  property="order_items",
  *                    type="array",
  *                     @OA\Items(
  *                         type="object",
  *                          @OA\Property(property="order_item_id", type="integer", example=2, description="ID of the order item"),
  *                          @OA\Property(property="order_id", type="integer", example=3, description="ID of the related order"),
  *                          @OA\Property(property="menu_item_id", type="integer", example=2, description="ID of the menu item"),
  *                          @OA\Property(property="quantity", type="integer", example=2, description="Quantity of the menu item"),
  *                          @OA\Property(property="subtotal", type="number", format="float", example=25.98, description="Subtotal for this item"),
  *                          @OA\Property(property="item_status", type="string", example="Pending", description="Status of the item"),
  *                          @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-19T16:01:17.000000Z", description="Item creation timestamp"),
  *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-19T16:01:17.000000Z", description="Item last update timestamp")
  *                      )
  *                  )
  *             )
 *         )
 *     ), @OA\Response(
  *      response=400,
  *      description="Invalid input",
  *      @OA\JsonContent(
  *         @OA\Property(
  *              property="error",
  *              type="string",
  *            example="Invalid input"
  *          ),
  *         @OA\Examples(
  *              example="invalid_menu_item_id",
  *              value={"error": "Invalid menu item ID"},
  *              summary="Invalid Menu Item ID"
  *          ),
  *          @OA\Examples(
  *              example="invalid_quantity",
  *             value={"error": "Invalid quantity for item"},
  *              summary="Invalid Quantity"
  *          ),
  *          @OA\Examples(
  *            example="user_not_associated",
  *             value={"error": "The specified user is not associated with this reservation"},
  *              summary="User Not Associated"
  *          )
  *      )
  *         ),@OA\Response(
 *         response=500,
 *         description="Order creation failed",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Order creation failed")
 *         )
 *     )
 * )
 *

     * @OA\Put(
     *     path="/api/orders/{orderId}/addMenuItem",
     *     summary="Add a menu item to an existing order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"menu_item_id", "quantity"},
     *                 @OA\Property(property="menu_item_id", type="integer", example=1, description="ID of the menu item"),
     *                 @OA\Property(property="quantity", type="integer", example=2, description="Quantity of the menu item")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item added to the order successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Menu item added to order successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order or menu item not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Order not found"),
     *             @OA\Examples(
     *                 example="order_not_found",
     *                 value={"error": "Order not found"},
     *                 summary="Order Not Found"
     *             ),
     *             @OA\Examples(
     *                 example="menu_item_not_found",
     *                 value={"error": "Menu item not found"},
     *                 summary="Menu Item Not Found"
     *             )
     *         )
     *     )
     * )
     */


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
