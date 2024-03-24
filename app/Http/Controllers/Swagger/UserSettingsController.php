<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/settings",
     *     operationId="getUserSettings",
     *     tags={"UserSettings"},
     *     summary="Get user settings",
     *     description="Returns the current user's settings including personal information and preferences",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="telegram", type="string", example="@johndoe"),
     *             @OA\Property(property="dark_mode", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index() {
        // Your existing method implementation
    }

    /**
     * @OA\Put(
     *     path="/user/settings",
     *     operationId="updateUserSettings",
     *     tags={"UserSettings"},
     *     summary="Update user settings",
     *     description="Updates the current user's settings including personal information and preferences",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="User settings to update",
     *         @OA\JsonContent(
     *             required={},
     *             @OA\Property(property="email", type="string", format="email", example="john.new@example.com"),
     *             @OA\Property(property="telegram", type="string", example="@johnnew"),
     *             @OA\Property(property="new_password", type="string", format="password", example="newPassword123"),
     *             @OA\Property(property="current_password", type="string", format="password", example="currentPassword123"),
     *             @OA\Property(property="dark_mode", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Settings updated successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Settings updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(Request $request) {
        // Your existing method implementation
    }
}
