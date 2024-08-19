<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class RolesController extends Controller
{

    public function getRoleByname(Request $request , $role_name){
        $roles = Role::where('role_name', $role_name)->get();

        if(!$roles){
            return response("can't find this Role", 404);
        }
        else{
            return response()->json(['role' => $roles], 200);
        }
    }

    public function getAllRoles()
    {
        $roles = Role::all();

        if ($roles->isEmpty()) {
            return response()->json(["error" => "No roles found"], 404);
        }

        return response()->json($roles, 200);
    }

    public function getById($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["error" => "Role not found"], 404);
        }

        return response()->json(['role' => $role], 200);
    }

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
