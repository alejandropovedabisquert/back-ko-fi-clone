<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrador',
                'description' => 'Acceso completo',
                'active' => true,
                'system' => true,
            ]
        );

        $editor = Role::updateOrCreate(
            ['name' => 'editor'],
            [
                'display_name' => 'Editor',
                'description' => 'Editor de contenido',
                'active' => true,
                'system' => true,
            ]
        );

        $user = Role::updateOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Usuario',
                'description' => 'Usuario estándar',
                'active' => true,
                'system' => true,
            ]
        );

        // Admin => todos los permisos
        $admin->permissions()->sync(
            Permission::pluck('id')
        );

        // Editor
        $editor->permissions()->sync(
            Permission::whereIn('name', [
                'posts.view',
                'posts.create',
                'posts.update',
                'posts.publish',
            ])->pluck('id')
        );

        // Usuario
        $user->permissions()->sync(
            Permission::whereIn('name', [
                'posts.view',
            ])->pluck('id')
        );
    }
}