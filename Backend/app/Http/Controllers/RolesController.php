<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;


class RolesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/roles/{role_name}",
     *     summary="Get role by name",
     *     tags={"Role Management"},
     *     @OA\Parameter(
     *         name="role_name",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The name of the role to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="role_name", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role not found")
     *         )
     *     )
     * )
     */
    public function getRoleByname(Request $request , $role_name){
        $roles = Role::where('role_name', $role_name)->get();
        if(!$roles){
            return response("can't find this Role", 404);
        }
        else{
            return response()->json(['role' => $roles], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Get all roles",
     *     tags={"Role Management"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all roles",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No roles found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No roles found")
     *         )
     *     )
     * )
     */

    public function getAllRoles()
    {
        $roles = Role::all();

        if ($roles->isEmpty()) {
            return response()->json(["error" => "No roles found"], 404);
        }

        return response()->json($roles, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/role/{role_id}",
     *     summary="Get role by ID",
     *     tags={"Role Management"},
     *     @OA\Parameter(
     *         name="role_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the role to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Role retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="role_name", type="string"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role not found")
     *         )
     *     )
     * )
     */
    public function getById($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        return response()->json(['role' => $role], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/roles/create/role",
     *     summary="Create a new role",
     *     tags={"Role Management"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="role_name", type="string", example="Admin"),
     *              @OA\Property(property="description", type="string", example="Administrator role with full permissions"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Role created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Role created successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Role creation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role could not be created")
     *         )
     *     )
     * )
     */

    public function createRole(Request $request){
            $validated = $request->validate([
                'role_name' => 'required|string|max:255|unique:roles,role_name',
                'description' => 'nullable|string|max:1000',
            ]);

            $role = new Role();
            $role->role_name = $validated['role_name'];
            $role->description = $validated['description'] ?? null;
            $role->save();
            if($role){
                return response()->json(["role" => $role], 201);
            }else
                return response()->json(["error" => "Role could not be created"], 500);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/update/{role_id}",
     *     summary="Update an existing role",
     *     tags={"Role Management"},
     *     @OA\Parameter(
     *         name="role_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the role to update"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="role_name", type="string", example="Admin"),
     *              @OA\Property(property="description", type="string", example="Administrator role with full permissions"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Role updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Role updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Role update failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role could not be updated")
     *         )
     *     )
     * )
     */

    public function updateRole(Request $request ,$role_id){

      $role = Role::findOrfail($role_id);

      $validated = $request->validate([
        'role_name' => 'required|string|max:255|unique:roles,role_name',
        'description' => 'nullable|string|max:1000',
      ]);

        $role->role_name = $validated['role_name'];
        $role->description = $validated['description'] ?? null;

        if($role){
            $role-> update($validated);
            return response()->json(['success' => 'Role updated successfully!'], 201);
        }else
            return response()->json(["error" => "Role could not be updated"], 500);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/delete/{role_id}",
     *     summary="Delete a role",
     *     tags={"Role Management"},
     *     @OA\Parameter(
     *         name="role_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the role to delete"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Role deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Role not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Role not found")
     *         )
     *     )
     * )
     */

    public function deleteRole(Request $request,$role_id){
        $role = Role::findOrfail($role_id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }
        else{
            $role->delete();
            return response()->json("the role deleted successfully", 204);
        }
    }
}
