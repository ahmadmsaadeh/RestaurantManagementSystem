<?php

namespace App\Http\Controllers;
use App\Models\MenuItem;

use Illuminate\Http\Request;

class MenuItemController extends Controller
{

    public function getMenuitem()
    {
        return MenuItem::all();
    }
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
