<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // PANEL
            [
                'resource' => 'panel',
                'name' => 'panel.access',
                'display_name' => 'Access to the admin panel',
            ],

            // USERS
            [
                'resource' => 'users',
                'name' => 'users.view',
                'display_name' => 'View users',
            ],
            [
                'resource' => 'users',
                'name' => 'users.create',
                'display_name' => 'Create users',
            ],
            [
                'resource' => 'users',
                'name' => 'users.update',
                'display_name' => 'Edit users',
            ],
            [
                'resource' => 'users',
                'name' => 'users.delete',
                'display_name' => 'Delete users',
            ],

            // POSTS
            [
                'resource' => 'posts',
                'name' => 'posts.view',
                'display_name' => 'View posts',
            ],
            [
                'resource' => 'posts',
                'name' => 'posts.create',
                'display_name' => 'Create posts',
            ],
            [
                'resource' => 'posts',
                'name' => 'posts.update',
                'display_name' => 'Edit posts',
            ],
            [
                'resource' => 'posts',
                'name' => 'posts.delete',
                'display_name' => 'Delete posts',
            ],
            [
                'resource' => 'posts',
                'name' => 'posts.publish',
                'display_name' => 'Publish posts',
            ],

            // ROLES
            [
                'resource' => 'roles',
                'name' => 'roles.view',
                'display_name' => 'View roles',
            ],
            [
                'resource' => 'roles',
                'name' => 'roles.create',
                'display_name' => 'Create roles',
            ],
            [
                'resource' => 'roles',
                'name' => 'roles.update',
                'display_name' => 'Edit roles',
            ],
            [
                'resource' => 'roles',
                'name' => 'roles.delete',
                'display_name' => 'Delete roles',
            ],

            // PERMISSIONS
            [
                'resource' => 'permissions',
                'name' => 'permissions.view',
                'display_name' => 'View permissions',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}