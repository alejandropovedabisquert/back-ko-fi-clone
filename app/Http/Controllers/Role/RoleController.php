<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Listado de roles.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        return Role::with('permissions')->get();
    }

    /**
     * Crear rol.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        return Role::create($request->validated());
    }

    /**
     * Mostrar rol.
     */
    public function show(Role $role)
    {
        return response()->json(
            $role->load('permissions')
        );
    }

    /**
     * Actualizar rol.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->update($request->validated());

        return $role;
    }

    /**
     * Eliminar rol.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if ($role->users()->exists()) {
            return response()->json([
                'message' => 'Este rol tiene usuarios asignados.'
            ], 422);
        }

        $role->delete();

        return response()->json([
            'message' => 'Rol eliminado.'
        ]);
    }

    /**
     * Sincronizar permisos.
     */
    public function syncPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->permissions()->sync(
            $validated['permissions'] ?? []
        );

        return response()->json([
            'message' => 'Permisos actualizados correctamente.'
        ]);
    }
}
