<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Listado de permisos.
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        return response()->json(
            Permission::orderBy('name')->get()
        );
    }

    /**
     * Mostrar un permiso.
     */
    public function show(Permission $permission)
    {
        $this->authorize('view', $permission);

        return response()->json($permission);
    }
}