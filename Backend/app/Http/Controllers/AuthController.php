<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Register
     * @OA\Post (
     *     path="/api/auth/registercustomer",
     *     tags={"Auth Management"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="username",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                     @OA\Property(
     *                           property="firstname",
     *                           type="string"
     *                       ),
     *                     @OA\Property(
     *                           property="lastname",
     *                           type="string"
     *                       ),
     *                     @OA\Property(
     *                            property="phonenumber",
     *                            type="string"
     *                        ),
     *                 ),
     *                 example={
     *                     "username":"John1",
     *                     "email":"john@test.com",
     *                     "password":"johnjohn1",
     *                     "firstname":"john",
     *                     "lastname":"john",
     *                     "phonenumber":"0598985980"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=200),
     *                  @OA\Property(property="status", type="string", example="success"),
     *                  @OA\Property(property="message", type="string", example=null),
     *              ),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="user", type="object",
     *                      @OA\Property(property="id", type="number", example=1),
     *                      @OA\Property(property="username", type="string", example="John"),
     *                      @OA\Property(property="email", type="string", example="john@test.com"),
     *                      @OA\Property(property="email_verified_at", type="string", example=null),
     *                      @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *                      @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *                  ),
     *                  @OA\Property(property="access_token", type="object",
     *                      @OA\Property(property="token", type="string", example="randomtokenasfhajskfhajf398rureuuhfdshk"),
     *                      @OA\Property(property="type", type="string", example="Bearer"),
     *                      @OA\Property(property="expires_in", type="number", example=3600),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object",
     *                      @OA\Property(property="email", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The email has already been taken.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *      )
     * )
     */

public function registercustomer(Request $request)
{
    $validate = $this->validate($request, [
        'username' => 'required|string|min:2|max:255',
        'firstname' => 'required|string|min:2|max:255',
        'lastname' => 'required|string|min:2|max:255',
        'phonenumber' => 'required|string|min:10|max:15',
        'email' => 'required|string|email:rfc,dns|max:255|unique:users',
        'password' => 'required|string|min:6|max:255',
    ]);

    if (!$validate) {
        return response()->json([
            'meta' => [
                'code' => 404,
                'status' => 'can not create user',
                'message' => 'User did not created successfully!',
            ],]);
    } else {
        $user = User::create([
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'phonenumber' => $request['phonenumber'],
            'email' => $request['email'],
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'date_joined' => date('Y-m-d'),
        ]);
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User created successfully!',
            ],
            'data' => [
                'user' => $user]
        ], 200);
    }
}
}
