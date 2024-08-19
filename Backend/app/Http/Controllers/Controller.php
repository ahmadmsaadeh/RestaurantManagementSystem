<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Alaa API",
 *    description="An API",
 *    version="1.0.0",
 * )
 *
 * @OA\Tag(
 *      name="Role Management",
 *      description="API Endpoints related to Role Management"
 *  )
 *
 * @OA\Tag(
 *      name="User Management",
 *      description="API Endpoints related to User Management"
 *  )
 * @OA\Tag(
 *       name="Auth Management",
 *       description="API Endpoints related to Auth Management"
 *   )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}
