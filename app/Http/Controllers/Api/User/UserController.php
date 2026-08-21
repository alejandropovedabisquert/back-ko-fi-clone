<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ApiUpdateMeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Returns the authenticated user's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        // Devolver los datos del usuario autenticado por Sanctum
        return new UserResource($request->user());
    }

    /**
     * Updates the authenticated user's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMe(ApiUpdateMeRequest $request)
    {
        $user = $request->user();

        $user->fill($request->validated());

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Gets a user's data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBySlug(User $user)
    {
        return response()->json([
            'user' => new UserResource($user),
        ]);
    }
}
