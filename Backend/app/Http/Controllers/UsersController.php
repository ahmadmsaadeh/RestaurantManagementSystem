<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

//push it
class UsersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"User Management"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all users"
     *     )
     * )
     */

    public function getAllUsers()
    {
        $users = User::all();
        if(!$users){
            return response("can't get all users", 404);
        }else{
            return response($users, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get user by id",
     *     tags={"User Management"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the user to get it"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User got successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User got successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid user id")
     *         )
     *     )
     * )
     */

    public function getUserById($user_id)
    {
        $users = User::find($user_id);
        if (!$users) {
            return response("invalid user id", 404);
        } else {
            return response($users, 200);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/users/role/{role_id}",
     *     summary="get the user by role id for admin to see all staff or customers by id",
     *     tags={"User Management"},
     *     @OA\Parameter(
     *         name="role_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the role to be got"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User got successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User got successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid role id")
     *         )
     *     )
     * )
     */
    public function getUserByRoleId(Request $request, $role_id)
    {
        $role = Role::with('users')->find($role_id);
        if (!$role) {
            return response("invalid role id", 404);
        }
        return response()->json($role, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="users can update there information",
     *     tags={"User Management"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the user to be updated"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="username", type="string", example="alaa"),
     *              @OA\Property(property="email", type="string", example="alaa.has@example.com"),
     *              @OA\Property(property="password", type="string", example="1212121212"),
     *              @OA\Property(property="lastname", type="string", example="alaa"),
     *              @OA\Property(property="firstname", type="string", example="hasan")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid user id")
     *         )
     *     )
     * )
     */

    public function edit(User $user)
    {
        return view('user_update', ['user' => $user]);
    }

    public function updateUser($id, Request $request)
    {
        $user = User::findOrFail($id);
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:10',
                'lastname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
            ]);

            $user->update($validated);

            return response()->json(['success' => 'User updated successfully!'], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Update failed'], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user account by ID",
     *     description="This endpoint deletes a user account by its ID.",
     *     tags={"User Management"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the user to be deleted"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid user id")
     *         )
     *     )
     * )
     */

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'Invalid user id'], 404);

        } else {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }
    }
}
