<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\User\ApiUpdateMeRequest;
use App\Http\Requests\Requests\User\ApiUpdateRequest;
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
        return response()->json([$request->user()], 200);
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
     * Updates the authenticated user's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ApiUpdateRequest $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'You cannot update yourself with this route.'], 403);
        }

        $user->fill($request->validated());

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Gets a user's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserBySlug(Request $request)
    {
        $user = User::where('slug', $request->slug)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User retrieved successfully', 'user' => $user], 200);
    }
}
