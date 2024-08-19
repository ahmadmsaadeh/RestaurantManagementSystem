<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        if(!$users){
            return response("can't get all users", 404);
        }else{
            return response($users, 200);
        }
    }

    public function getUserById($user_id)
    {
        $users = User::find($user_id);
        if (!$users) {
            return response("invalid user id", 404);
        } else {
            return response($users, 200);
        }
    }

    public function getUserByRoleId(Request $request, $role_id)
    {
        $role = Role::with('users')->find($role_id);
        if (!$role) {
            return response("invalid role id", 404);
        }
        return response()->json($role, 200);
    }

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
