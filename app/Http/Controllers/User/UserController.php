<?php

namespace App\Http\Controllers\User;

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
        return response()->json($request->user());
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

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

        /**
     * Updates the authenticated user's data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ApiUpdateRequest $request, User $user)
    {
        // Esta linea la puedo quitar? probar
        $request->route('user');

        $user->fill($request->validated());

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}
