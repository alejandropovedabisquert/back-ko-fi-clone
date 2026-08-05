<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // USERS
            ['name' => 'users.view', 'display_name' => 'Ver usuarios'],
            ['name' => 'users.create', 'display_name' => 'Crear usuarios'],
            ['name' => 'users.update', 'display_name' => 'Editar usuarios'],
            ['name' => 'users.delete', 'display_name' => 'Eliminar usuarios'],

            // POSTS
            ['name' => 'posts.view', 'display_name' => 'Ver posts'],
            ['name' => 'posts.create', 'display_name' => 'Crear posts'],
            ['name' => 'posts.update', 'display_name' => 'Editar posts'],
            ['name' => 'posts.delete', 'display_name' => 'Eliminar posts'],
            ['name' => 'posts.publish', 'display_name' => 'Publicar posts'],

            // ROLES
            ['name' => 'roles.view', 'display_name' => 'Ver roles'],
            ['name' => 'roles.create', 'display_name' => 'Crear roles'],
            ['name' => 'roles.update', 'display_name' => 'Editar roles'],
            ['name' => 'roles.delete', 'display_name' => 'Eliminar roles'],

            // PERMISSIONS
            ['name' => 'permissions.view', 'display_name' => 'Ver permisos'],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
