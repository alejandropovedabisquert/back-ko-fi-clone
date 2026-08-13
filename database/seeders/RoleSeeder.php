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

        $moderator = Role::updateOrCreate(
            ['name' => 'moderator'],
            [
                'display_name' => 'Moderator',
                'description' => 'Moderador del sitio',
                'active' => true,
                'system' => true,
            ]
        );

        // Admin => todos los permisos
        $admin->permissions()->sync(
            Permission::pluck('id')
        );

        $moderator->permissions()->sync(
            Permission::whereIn('name', [
                'posts.view',
                'posts.create',
                'posts.update',
                'posts.publish',
                'users.view',
                'users.create',
                'users.update',
                'users.delete',
            ])->pluck('id')
        );
    }
}