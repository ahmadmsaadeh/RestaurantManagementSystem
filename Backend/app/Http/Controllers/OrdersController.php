<?php
//author: Jood Hamdallah

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     required={"id", "user_id", "reservation_id", "order_date", "status"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="reservation_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="order_date",
 *         type="string",
 *         format="date",
 *         example="2024-08-21"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         example="Open"
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="float",
 *         example=59.56
 *     )
 * )
 */

class OrdersController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/orders/createOrder",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"order_items"},
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID of the user placing the order"
     *                 ),
     *                 @OA\Property(
     *                     property="reservation_id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID of the reservation for the order"
     *                 ),
     *                 @OA\Property(
     *                     property="order_items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         required={"menu_item_id", "quantity"},
     *                         @OA\Property(
     *                             property="menu_item_id",
     *                             type="integer",
     *                             example=1,
     *                             description="ID of the menu item"
     *                         ),
     *                         @OA\Property(
     *                             property="quantity",
     *                             type="integer",
     *                             example=2,
     *                             description="Quantity of the menu item"
     *                         )
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
     *                 property="order_details",
     *                 type="object",
     *                 @OA\Property(property="order_id", type="integer", example=3, description="ID of the created order"),
     *                 @OA\Property(property="reservation_id", type="integer", example=2, description="ID of the reservation"),
     *                 @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="order_status", type="string", example="Open", description="Current status of the order"),
     *                 @OA\Property(property="total", type="number", format="float", example=25.98, description="Total amount for the order"),
     *                 @OA\Property(
     *                     property="order_items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="item_name", type="string", example="Burger", description="Name of the menu item"),
     *                         @OA\Property(property="price", type="number", format="float", example=12.99, description="Price of the menu item"),
     *                         @OA\Property(property="quantity", type="integer", example=2, description="Quantity of the menu item"),
     *                         @OA\Property(property="subtotal", type="number", format="float", example=25.98, description="Subtotal for this item"),
     *                         @OA\Property(property="item_status", type="string", example="Pending", description="Status of the item")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input"
     *             ),
     *             @OA\Examples(
     *                 example="invalid_menu_item_id",
     *                 value={"error": "Invalid menu item ID"},
     *                 summary="Invalid Menu Item ID"
     *             ),
     *             @OA\Examples(
     *                 example="invalid_quantity",
     *                 value={"error": "Invalid quantity for item"},
     *                 summary="Invalid Quantity"
     *             ),
     *             @OA\Examples(
     *                 example="user_not_associated",
     *                 value={"error": "The specified user is not associated with this reservation"},
     *                 summary="User Not Associated"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Order creation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Order creation failed")
     *         )
     *     )
     * )
     */


    public function createOrder(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

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

            foreach ($request->order_items as $item) {
                if (!isset($item['quantity']) || $item['quantity'] < 1) {
                    return response()->json(['error' => 'Invalid quantity for item'], 400);
                }
                // Fetch the price from the menu_items table
                $menuItem = MenuItem::find($item['menu_item_id']);

                if ($menuItem) {
                    $subtotal = $this->calculateSubtotal($menuItem->price, $item['quantity']);

                    // Store the order items
                    Order_item::create([
                        'order_id' => $order->order_id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                    ]);

                    // Add the subtotal to the total
                    $total = $this->calculateTotal($total, $subtotal);
                } else {
                    // Handle the case where the menu item does not exist
                    return response()->json(['error' => 'Invalid menu item ID'], 400);
                }
            }

            // Update the order with the total amount
            $order->update(['total' => $total]);
            $order->load('orderItems');


         // Format the response data
        $response = [
            'order_id' => $order->order_id,
            'reservation_id' => $order->reservation_id,
            'user_id' => $order-> user_id,
            'order_status' => $order->status,
            'order_items' => $order->orderItems->map(function ($item) {
                return [
                    'item_name' => $item->menuItem->name_item, // Assuming MenuItem model has a 'name' attribute
                    'price' => $item->menuItem->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'item_status' => $item->item_status
                ];
            }),
            'total' => $order->total,
        ];

        return response()->json([
            'message' => 'Order created successfully',
            'order_details' => $response,
        ], 201);


       // return response()->json(['message' => 'Order created successfully', 'order details' => $order], 201);
    }   //done

    /**
     * @OA\Put(
     *     path="/api/orders/{orderId}/addItem",
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
     *                 @OA\Property(
     *                     property="menu_item_id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID of the menu item"
     *                 ),
     *                 @OA\Property(
     *                     property="quantity",
     *                     type="integer",
     *                     example=2,
     *                     description="Quantity of the menu item"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item added to the order successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Menu item added to order successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order or menu item not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order not found"
     *             ),
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

    public function addMenuItemToOrder(Request $request, $orderId): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $order = Order::find($orderId);  // Find the order

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,menu_item_id',
            'quantity' => 'required|integer|min:1',
        ]);


        // Find the menu item
        $menuItem = MenuItem::find($validatedData['menu_item_id']);

        // Check if the order already has the menu item
        $orderItem = Order_item::where('order_id', $orderId)
            ->where('menu_item_id', $validatedData['menu_item_id'])
            ->first();

        if ($orderItem) {
            // Update the quantity and subtotal if the item exists
            $orderItem->quantity += $validatedData['quantity'];
            $orderItem->subtotal = $this->calculateSubtotal($orderItem->quantity,$menuItem->price);
            $orderItem->save();
        } else {
            // Create a new order item if it does not exist
            Order_item::create([
                'order_id' => $orderId,
                'menu_item_id' => $validatedData['menu_item_id'],
                'quantity' => $validatedData['quantity'],
                'subtotal' => $this->calculateSubtotal($menuItem->price,$validatedData['quantity']),
            ]);
        }

        // Update the total of the order
        $total = Order_item::where('order_id', $orderId)->sum('subtotal');
        $order->total = $total;
        $order->save();

        $order->load('reservation', 'orderItems.menuItem');

        // Format the response data
        $response = [
            'order_id' => $order->order_id,
            'reservation_id' => $order->reservation_id,
            'order_items' => $order->orderItems->map(function ($item) {
                return [
                    'item_name' => $item->menuItem->name_item, // Assuming MenuItem model has a 'name' attribute
                    'price' => $item->menuItem->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            }),
            'total' => $order->total,
        ];

        return response()->json([
            'message' => 'Menu item added to order successfully',
            'order_details' => $response,
        ], 200);

    }  //done

    /**
     * @OA\Patch(
     *     path="/api/orders/{orderId}/items/{itemId}/status",
     *     summary="Update the status of an order item",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             example=2
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         required=true,
     *         description="ID of the menu item",
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"status"},
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="The new status of the order item",
     *                     enum={"Pending", "In-progress", "Completed", "Served"},
     *                     example="In-progress"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order item status updated successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order or item not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order not found"
     *
     *         ),
     *         @OA\Examples(
     *
     *                 example="Order not found",
     *                 value={"error": "Order not found"},
     *                 summary="Order does not exist in the system"
     *             ),
     *             @OA\Examples(
     *                 example="Item not found",
     *                 value={"error": "Item not found in the menu"},
     *                 summary="The specified menu item does not exist"
     *             ),
     *             @OA\Examples(
     *                 example="Order item not found in this order",
     *                 value={"error": "Order item doesn’t exist in this order"},
     *                 summary="The item does not exist in the specified order"
     *             )
     *         )
     *     ),
     *    @OA\Response(
     *          response=422,
     *          description="Bad request, invalid input",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Validation failed"
     *              )
     *          )
     *      )
     * )
     */

    public function updateOrderItemStatus(Request $request, $orderId, $itemId): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

       $order=Order::find($orderId);
       if(!$order){
           return response()->json(['error' => 'Order not found'], 404);
       }

       $item=MenuItem::find($itemId);
       if(!$item){
           return response()->json(['error' => 'Item not found in the menu'], 404);
       }


        // Find the order item
        $orderItem = Order_item::where('order_id', $orderId)
            ->where('menu_item_id', $itemId)
            ->first();

        if (!$orderItem) {
            return response()->json(['error' => 'Order item doesn\'t exist in this order'], 404);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'status' => 'required|string|in:Pending,In-progress,Completed,Served',
        ]);



        // Update the status
        $orderItem->item_status = $validatedData['status'];
        $orderItem->save();

        return response()->json(['message' => 'Order item status updated successfully'], 200);
    }   //done

    /**
     * @OA\Patch(
     *     path="/api/orders/{orderId}/status",
     *     summary="Update the status of an order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),@OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"status"},
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="The new status of the order",
     *                     enum={"Open", "Served", "Closed"},
     *                     example="Open"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order status updated successfully"
     *             )
     *         )
     *     ),@OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order not found"
     *           )
     *        )
     *     ),@OA\Response(
     *          response=422,
     *          description="Bad request, invalid input",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Validation failed"
     *              )
     *          )
     *      )
     * )
     */

    public function updateOrderStatus(Request $request, $orderId): JsonResponse
    {

        $request->headers->set('Accept', 'application/json');
        $order=Order::find($orderId);

        if(!$order){
            return response()->json(['error' => 'Order not found'], 404);
        }
        $validatedData = $request->validate([
            'status' => 'required|string|in:Open,Served,Closed',
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        return response()->json(['Message' => 'Order status updated successfully'], 200);

    }  //done

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="List all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="List of orders",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Order")
     *         )
     *     )
     * )
     */
    public function listOrders(): JsonResponse
    {
        $orders = Order::with(['user', 'reservation'])->get()->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'table_no' => $order->reservation->TableID ?? null, // Table number from the reservation
                'reservation_no' => $order->reservation_id ?? null,
                'customer_name' => $order->user->username ?? 'Guest',
                'user_id' => $order->user->user_id ?? null,
                // Format the order_date and order_time using Carbon
                'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
                'order_time' => Carbon::parse($order->order_time)->format('H:i:s'),
                'order_total' => $order->total,
                'status' => $order->status,
            ];
        });

        return response()->json($orders);
    }



    /**
     * @OA\Get(
     *     path="/api/orders/{orderId}",
     *     summary="Get an order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Order details"
     *             ),
     *             @OA\Property(
     *                 property="order",
     *                 ref="#/components/schemas/Order"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order not found"
     *             )
     *         )
     *     )
     * )
     */
    public function getOrderById($orderId): JsonResponse
    {
        // Find the order by ID, including the related user and reservation
        $order = Order::with(['user', 'reservation'])->find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Format the response using the relationships and desired structure
        $response = [
            'order_id' => $order->order_id,
            'table_no' => $order->reservation->TableID ?? null, // Table number from the reservation
            'reservation_no' => $order->reservation_id ?? null,
            'customer_name' => $order->user->username ?? 'Guest',
            'user_id' => $order->user->user_id ?? null,
            'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
            'order_time' => Carbon::parse($order->order_date)->format('H:i:s'), // Adjusted to use order_date for consistency
            'order_total' => $order->total,
            'status' => $order->status,
        ];

        // Return the custom formatted response
        return response()->json($response, 200);
    }
    //done

    /**
     * @OA\Get(
     *     path="/api/orders/user/{userId}",
     *     summary="Get orders by user ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of orders for the user",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Order details"
     *             ),
     *             @OA\Property(
     *                 property="orders",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Order")
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found or no orders for the user",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Order not found"
     *               ),
     *              @OA\Examples(
     *                  example="User not found",
     *                  value={"error": "User not found"},
     *                  summary="This user is not registered in the system"
     *              ),
     *              @OA\Examples(
     *                  example="No orders for this user",
     *                  value={"error": "No orders for this user"},
     *                  summary="No orders exist for the specified user"
     *               )
     *
     *        )
     *     )
     * )
     */

    public function getOrderByUserId($user_id): JsonResponse
    {
        $userExists = User::where('user_id', $user_id)->exists();

        if (!$userExists) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $orders = Order::where('user_id', $user_id)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders for this user'], 404);
        }

        // Transform the orders to match the required JSON structure
        $formattedOrders = $orders->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'table_no' => $order->reservation->TableID ?? null, // Table number from the reservation
                'reservation_no' => $order->reservation_id ?? null,
                'customer_name' => $order->user->username ?? 'Guest',
                'user_id' => $order->user->user_id ?? null,
                // Format the order_date and order_time using Carbon
                'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
                'order_time' => \Carbon\Carbon::parse($order->order_time)->format('H:i:s'),
                'order_total' => $order->total,
                'status' => $order->status,
            ];
        });

        return response()->json($formattedOrders, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/orders/reservation/{reservationId}",
     *     summary="Get orders by reservation ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="reservationId",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of orders for this reservation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Order details"
     *             ),
     *             @OA\Property(
     *                 property="orders",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Order")
     *             )
     *         )
     *     ),@OA\Response(
     *     response=404,
     *     description="Order or item not found",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             type="string",
     *             example="Order not found"
     *         ),
     *         @OA\Examples(
     *             example="Order not found",
     *             value={"error": "Order not found"},
     *             summary="There is no order with this ID"
     *         ),
     *         @OA\Examples(
     *             example="Item not found in this order",
     *             value={"error": "Item not found in this order"},
     *             summary="The specified item is not in this order"
     *         )
     *     )
     * )
     * )
     */
    public function getOrderByReservationId($reservationId): JsonResponse
    {
        $reservationExists = Reservation::where('ResID', $reservationId)->exists();

        if (!$reservationExists) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        $orders = Order::where('reservation_id', $reservationId)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders for this reservation'], 404);
        }

        // Transform the orders to match the required JSON structure
        $formattedOrders = $orders->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'table_no' => $order->reservation->TableID ?? null, // Table number from the reservation
                'reservation_no' => $order->reservation_id ?? null,
                'customer_name' => $order->user->username ?? 'Guest',
                'user_id' => $order->user->user_id ?? null,
                // Format the order_date and order_time using Carbon
                'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
                'order_time' => \Carbon\Carbon::parse($order->order_time)->format('H:i:s'),
                'order_total' => $order->total,
                'status' => $order->status,
            ];
        });

        return response()->json($formattedOrders, 200);
    }



    /**
     * @OA\Get(
     *     path="/api/orders/date/{date}",
     *     summary="Get orders by date",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="date",
     *         in="path",
     *         required=true,
     *         description="Date to fetch orders for",
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2024-08-22"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of orders for the specified date",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Order details"
     *             ),
     *             @OA\Property(
     *                 property="orders",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Order")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid date format",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid date format. Use YYYY-MM-DD."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No orders found for the specified date",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No orders found for this date"
     *             )
     *         )
     *     )
     * )
     */

    public function getOrderByDate($date): JsonResponse
    {
        $validator = Validator::make(['order_date' => $date], [
            'order_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD.'], 400);
        }

        // Fetch orders by date
        $orders = Order::whereDate('order_date', $date)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found for this date'], 404);
        }

        return response()->json(['Message' => 'Order details', 'orders' => $orders], 200);

    } //done

    ////need swagger for this::
    public function getOrdersByDateRange($startDate, $endDate): JsonResponse
    {
        // Validate the date format
        $validator = Validator::make(['startDate' => $startDate, 'endDate' => $endDate], [
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD.'], 400);
        }

        // Fetch orders within the date range including endDate
        $orders = Order::with(['user', 'reservation'])
            ->whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate)
            ->get()
            ->map(function ($order) {
                return [
                    'order_id' => $order->order_id,
                    'table_no' => $order->reservation->TableID ?? null,
                    'reservation_no' => $order->reservation_id ?? null,
                    'customer_name' => $order->user->username ?? 'Guest',
                    'user_id' => $order->user->user_id ?? null,
                    // Format the order_date and order_time
                    'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
                    'order_time' => Carbon::parse($order->order_time)->format('H:i:s'),
                    'order_total' => $order->total,
                    'status' => $order->status,
                ];
            });
        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found for the selected date range.'], 404);
        }
        return response()->json($orders);
    }










    /**
     * @OA\Get(
     *     path="/api/orders/status/{status}",
     *     summary="Get orders by status",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         required=true,
     *         description="Status of the orders to fetch",
     *         @OA\Schema(
     *             type="string",
     *             example="Open"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of orders with the specified status",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Order details"
     *             ),
     *             @OA\Property(
     *                 property="orders",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Order")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid status. Allowed values are Open, Served, Closed."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No orders found with the specified status",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No orders found in this status"
     *             )
     *         )
     *     )
     * )
     */

    public function getOrderByStatus($status): JsonResponse
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|string|in:Open,Served,Closed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid status. Allowed values are Open, Served, Closed.'], 400);
        }

        $orders = Order::with(['user', 'reservation'])
            ->where('status', $status)
            ->get()
            ->map(function ($order) {
                return [
                    'order_id' => $order->order_id,
                    'table_no' => $order->reservation->TableID ?? null, // Table number from the reservation
                    'reservation_no' => $order->reservation_id ?? null,
                    'customer_name' => $order->user->username ?? 'Guest',
                    'user_id' => $order->user->user_id ?? null,
                    'order_date' => Carbon::parse($order->order_date)->format('d-m-Y'),
                    'order_time' => \Carbon\Carbon::parse($order->order_time)->format('H:i:s'),
                    'order_total' => $order->total,
                    'status' => $order->status,
                ];
            });

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found in this status'], 404);
        }
        return response()->json($orders);
       // return response()->json([$orders], 200);
    }



    /**
     * @OA\Get(
     *     path="/api/orders/items/status/{status}",
     *     summary="Get order items by status",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         required=true,
     *         description="Status of the order items to fetch",
     *         @OA\Schema(
     *             type="string",
     *             example="Pending"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of order items with the specified status",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Items in this status"
     *             ),
     *             @OA\Property(
     *                 property="Items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="item_name", type="string", example="Burger"),
     *                     @OA\Property(property="price", type="number", format="float", example=5.99),
     *                     @OA\Property(property="image", type="string", example="/images/burger.jpg"),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="order_id", type="integer", example=1),
     *                     @OA\Property(property="reservation_id", type="integer", example=10),
     *                     @OA\Property(property="user_name", type="string", example="john_doe"),
     *                     @OA\Property(property="subtotal", type="number", format="float", example=11.98),
     *                     @OA\Property(property="status", type="string", example="Pending")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid status. Allowed values are Pending, In-progress, Completed, Served."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No items found with the specified status",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No items found in this status"
     *             )
     *         )
     *     )
     * )
     */

    public function getOrderItemsByStatus($status): JsonResponse
    {
        $validator = Validator::make(['item_status' => $status], [
            'item_status' => 'required|string|in:Pending,In-progress,Completed,Served',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid status. Allowed values are Pending,In-progress,Completed,Served'], 400);
        }
        $orderItems = Order_item::where('item_status', $status)->get();

        if ($orderItems->isEmpty()) {
            return response()->json(['error' => 'No items found in this status'], 404);
        }

        $formattedItems = $orderItems->map(function ($item) {
            return [
                'item_name' => $item->menuItem->name_item, // Assuming MenuItem model has a 'name_item' attribute
                'menu_item_id' => $item->menuItem->menu_item_id ,
                'price' => $item->menuItem->price,
                'image' => $item->menuItem->image,
                'quantity' => $item->quantity,
                'order_id' => $item->order_id,
                'reservation_id' => $item->order->reservation_id,
                'user_name' => $item->order->user->username,
                'subtotal' => $item->subtotal,
                'status' => $item->item_status,
            ];
        });

        return response()->json(['Message' => 'Items in this status', 'Items' => $formattedItems], 200);

    }   //**** items done

    /**
     * @OA\Get(
     *     path="/api/orders/{orderId}/items",
     *     summary="Get order items by order ID",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order to fetch items for",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of items for the specified order",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="Message",
     *                 type="string",
     *                 example="Items of this order"
     *             ),
     *             @OA\Property(
     *                 property="Items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="item_name", type="string", example="Burger"),
     *                     @OA\Property(property="price", type="number", format="float", example=5.99),
     *                     @OA\Property(property="image", type="string", example="/images/burger.jpg"),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="order_id", type="integer", example=1),
     *                     @OA\Property(property="reservation_id", type="integer", example=10),
     *                     @OA\Property(property="user_name", type="string", example="john_doe"),
     *                     @OA\Property(property="subtotal", type="number", format="float", example=11.98),
     *                     @OA\Property(property="status", type="string", example="Pending")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="number",
     *                 format="float",
     *                 example=23.97
     *             )
     *         )
     *     ),@OA\Response(
     *         response=404,
     *         description="Order not found or no items in the order",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No such order with this id"
     *             ),
     *
     *                 @OA\Examples(
     *                     example="Order not found",
     *                     value={"error": "No such order with this id"},
     *                     summary="No order found with the provided ID"
     *                 ),
     *                 @OA\Examples(
     *                     example="No items in this order",
     *                     value={"error": "No items in this order"},
     *                     summary="The specified order has no items"
     *                 )
     *             )
     *
     *     )
     * )
     */

    public function getOrderItems($orderId): JsonResponse
    {
        $order=Order::find($orderId);

        if(!$order){
            return response()->json(['error' => 'No such orders with this id'], 404);
        }

        $orderItems = Order_item::where('order_id', $orderId)->get();

        if ($orderItems->isEmpty()) {
            return response()->json(['error' => 'No items in this order'], 404);
        }

        $formattedItems = $orderItems->map(function ($item) {
            return [
                'menu_item_id' => $item->menuItem->menu_item_id,
                'item_name' => $item->menuItem->name_item, // Assuming MenuItem model has a 'name_item' attribute
                'price' => $item->menuItem->price,
                'image' => $item->menuItem->image,
                'quantity' => $item->quantity,
                'order_id' => $item->order_id,
                'reservation_id' => $item->order->reservation_id,
                'user_name' => $item->order->user->username,
                'subtotal' => $item->subtotal,
                'status' => $item->item_status,

            ];
        });

        return response()->json(['Message' => 'Items of this order', 'Items' => $formattedItems,'total' => $order->total], 200);


    }     //******** items done

    /**
     * @OA\Delete(
     *     path="/api/orders/{orderId}",
     *     summary="Delete an order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Order not found"
     *             )
     *         )
     *     )
     * )
     */

    public function deleteOrder($orderId): JsonResponse
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Delete the order (this will also delete related order_items due to ON DELETE CASCADE)
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }     /// delete


    /**
     * @OA\Delete(
     *     path="/api/orders/{orderId}/items/{itemId}",
     *     summary="Remove a menu item from an order",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order  which to remove the item from it",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         required=true,
     *         description="ID of the menu item to remove from the order",
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item removed from the order successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Menu item removed from order successfully"
     *             ),
     *             @OA\Property(
     *                 property="order_details",
     *                 type="object",
     *                 @OA\Property(
     *                     property="order_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="reservation_id",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="order_items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="item_id", type="integer", example="2"),
     *                         @OA\Property(property="item_name", type="string", example="Burger"),
     *                         @OA\Property(property="price", type="number", format="float", example=5.99),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="subtotal", type="number", format="float", example=11.98)
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="number",
     *                     format="float",
     *                     example=11.98
     *                 )
     *             )
     *         )
     *     ),@OA\Response(
     *     response=404,
     *     description="Order or item not found",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             type="string",
     *             example="Order not found"
     *         ),
     *         @OA\Examples(
     *             example="Order not found",
     *             value={"error": "Order not found"},
     *             summary="There is no order with this ID"
     *         ),
     *        @OA\Examples(
     *              example="Menu item not found",
     *              value={"error": "Menu item not found"},
     *              summary="There is no menu item with this ID"
     *          ),
     *         @OA\Examples(
     *             example="Item not found in this order",
     *             value={"error": "Item not found in this order"},
     *             summary="The specified item is not in this order"
     *            )
     *         )
     *       )
     *    )
     * )
     */

    public function removeMenuItemFromOrder($orderId, $menuItemId): JsonResponse
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $menuItem=MenuItem::find($menuItemId);
        if(!$menuItem){
            return response()->json(['error' => 'Menu item not found'], 404);
        }


        $orderItem = Order_item::where('order_id', $orderId)
            ->where('menu_item_id', $menuItemId)
            ->first();

        if (!$orderItem) {
            return response()->json(['error' => 'Item not found in this order'], 404);
        }

        // Delete the order item
        $orderItem->delete();

        // Recalculate the total of the order
        $total = Order_item::where('order_id', $orderId)->sum('subtotal');
        $order->total = $total;
        $order->save();

        $order->load('reservation', 'orderItems.menuItem');

        $response = [
            'order_id' => $order->order_id,
            'reservation_id' => $order->reservation_id,
            'order_items' => $order->orderItems->map(function ($item) {
                return [
                    'item_id' => $item->menuItem->menu_item_id,
                    'item_name' => $item->menuItem->name_item,
                    'price' => $item->menuItem->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            }),
            'total' => $order->total,
        ];

        return response()->json([
            'message' => 'Menu item removed from order successfully',
            'order_details' => $response,
        ], 200);
    } // delete

    private function calculateSubtotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }

    private function calculateTotal(float $currentTotal, float $subtotal): float
    {
        return round($currentTotal + $subtotal, 5);
    }


}
