<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $user = User::updateOrCreate(
            [
                'email' => 'admin@email.com'
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        $user->roles()->syncWithoutDetaching([
            $adminRole->id
        ]);
    }
}