<?php
/**
 * @file Controller for handling table-related operations.
 *
 * @author Ahmad Saadeh
 */

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Table",
 *     type="object",
 *     title="Table",
 *     required={"TableID", "NumberOfChairs"},
 *
 *     @OA\Property(
 *         property="TableID",
 *         type="integer",
 *         description="The ID of the table.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="NumberOfChairs",
 *         type="integer",
 *         description="The number of chairs at this table.",
 *         example=10
 *     )
 * )
 */

class TablesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/tables",
     *     tags={"Tables"},
     *     summary="Get All Tables",
     *     description="Retrieve a list of all tables.",
     *     @OA\Response(
     *         response=200,
     *         description="A list of tables",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="TableID",
     *                     type="integer",
     *                     description="The ID of the Table",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="NumberOfChairs",
     *                     type="integer",
     *                     description="The number of chairs on this table",
     *                     example=10
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllTables(): JsonResponse
    {
        $tables = Table::all();
        return response()->json($tables, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tables/{id}",
     *     tags={"Tables"},
     *     summary="Get Table by ID",
     *     description="Retrieve the table with the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Table ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Table not found"
     *     )
     * )
     */
    public function getTable($table_id): JsonResponse
    {
        $table = Table::find($table_id);
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        return response()->json($table, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tables/{NumberOfChairs}",
     *     tags={"Tables"},
     *     summary="Add a new Table",
     *     description="Create a new table with a specified number of chairs.",
     *     @OA\Parameter(
     *         name="NumberOfChairs",
     *         in="path",
     *         description="Number of chairs on the table",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Table added"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid Number of Chairs"
     *     )
     * )
     */
    public function addTable($NumberOfChairs): JsonResponse
    {
        if ($NumberOfChairs <= 1) {
            return response()->json("Invalid Number of Chairs (Must be 2 or more).", 400);
        }

        $table = new Table();
        $table->NumberOfChairs = $NumberOfChairs;
        $table->save();

        return response()->json($table, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/tables/{id}",
     *     tags={"Tables"},
     *     summary="Delete a Table",
     *     description="Deletes a table by its ID if there are no active reservations from the specified date onwards.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Table ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Table deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Table cannot be deleted because it has active reservations",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Table cannot be deleted because it has active reservations")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Table not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Table not found")
     *         )
     *     )
     * )
     */
    public function deleteTable($table_id): JsonResponse
    {
        $table = Table::find($table_id);
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }
        $dateFrom = now();
        $reservations = Reservation::where('TableID', $table_id)
            ->where('Date', '>=', $dateFrom)
            ->get();
        if ($reservations->isNotEmpty()) {
            return response()->json(['error' => 'Table cannot be deleted because it has active reservations'], 400);
        }
        $table->delete();
        return response()->json(['message' => 'Table deleted successfully'], 200);
    }

}
