<?php
/**
 * @author Ibtisam
 * @date August 19, 2024
 *
 *
 *
 */
namespace App\Http\Controllers;
use App\Models\MenuItem;

use Illuminate\Http\Request;


/**
 * @OA\Info(
 *     title="Menu Item API",
 *     version="1.0.0",)
 *
 * @OA\Schema(
 *      schema="MenuItem",
 *      type="object",
 *      required={"name_item", "price", "availability", "category_id"},
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name_item", type="string", example="Pizza"),
 *      @OA\Property(property="description", type="string", example="Delicious cheese pizza"),
 *      @OA\Property(property="price", type="number", format="float", example=12.99),
 *      @OA\Property(property="availability", type="boolean", example=true),
 *      @OA\Property(property="image", type="string", example="pizza.jpg"),
 *      @OA\Property(property="category_id", type="integer", example=1)
 *  )
 *     */



class MenuItemController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/menu-items",
     *     operationId="getMenuitem",
     *     tags={"MenuItems"},
     *     summary="Get all menu items",
     *     description="Returns a list of all menu items",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MenuItem"),
     *             example={
     *                 {
     *                     "id": 5,
     *                     "name_item": "Margherita Pizza",
     *                     "description": "Classic cheese pizza with tomato sauce and basil.",
     *                     "price": 8.99,
     *                     "availability": true,
     *                     "image": "margherita.jpg",
     *                     "category_id": 1
     *                 },
     *                 {
     *                     "id": 6,
     *                     "name_item": "Pizza",
     *                     "description": "Delicious cheese pizza",
     *                     "price": 9.99,
     *                     "availability": true,
     *                     "image": "pizza.jpg",
     *                     "category_id": 1
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function getMenuitem()
    {
        return MenuItem::all();
    }


    /**
     * @OA\Get(
     *     path="/api/menu-items/{id}",
     *     operationId="getMenuItemById",
     *     tags={"MenuItems"},
     *     summary="Get a menu item by ID",
     *     description="Returns a single menu item by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the menu item to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     ),
     *
     * )
     */
    // get id
    public function getMenuItemById($id)
    {
        //return MenuItem::find($id);
        $menuItem = MenuItem::find($id);

        if (!$menuItem) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        return response()->json($menuItem, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/menu-items",
     *     operationId="createMenuItem",
     *     tags={"MenuItems"},
     *     summary="Create a new menu item",
     *     description="Adds a new menu item to the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Menu item created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MenuItem")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    public function createMenuItem(Request $request)
    {
      //  $menuItem = MenuItem::create($request->all());
      //  return response()->json($menuItem, 201);
        try {
            $validatedData = $request->validate([
                'name_item' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'availability' => 'required|boolean',
                'image' => 'nullable|string|max:255',
                'category_id' => 'required|exists:categories,category_id', // Ensure the category exists
            ]);

            $menuItem = MenuItem::create($validatedData);

            return response()->json([
                'message' => 'Menu item added successfully!',
                'menuItem' => $menuItem
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Menu item could not be added. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
