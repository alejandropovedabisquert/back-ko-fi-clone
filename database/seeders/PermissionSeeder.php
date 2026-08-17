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
            ['name' => 'users.view', 'display_name' => 'View users'],
            ['name' => 'users.create', 'display_name' => 'Create users'],
            ['name' => 'users.update', 'display_name' => 'Edit users'],
            ['name' => 'users.delete', 'display_name' => 'Delete users'],

            // POSTS
            ['name' => 'posts.view', 'display_name' => 'View posts'],
            ['name' => 'posts.create', 'display_name' => 'Create posts'],
            ['name' => 'posts.update', 'display_name' => 'Edit posts'],
            ['name' => 'posts.delete', 'display_name' => 'Delete posts'],
            ['name' => 'posts.publish', 'display_name' => 'Publish posts'],

            // ROLES
            ['name' => 'roles.view', 'display_name' => 'View roles'],
            ['name' => 'roles.create', 'display_name' => 'Create roles'],
            ['name' => 'roles.update', 'display_name' => 'Edit roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete roles'],

            // PERMISSIONS
            ['name' => 'permissions.view', 'display_name' => 'View permissions'],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
