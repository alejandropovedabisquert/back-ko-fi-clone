<?php

namespace Database\Seeders;

use App\Enums\AccountType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $admin = User::updateOrCreate(
            [
                'email' => 'admin@email.com',
                'name' => 'Administrador',
                'slug' => 'administrador',
                'account_type' => AccountType::USER,
                'password' => Hash::make('admin123'),
            ]
        );
        $moderatorRole = Role::where('name', 'moderator')->firstOrFail();

        $moderator = User::updateOrCreate(
            [
                'email' => 'mod@email.com',
                'name' => 'Moderator',
                'slug' => 'moderator',
                'account_type' => AccountType::USER,
                'password' => Hash::make('mod123'),
            ]
        );

        $admin->roles()->syncWithoutDetaching([
            $adminRole->id
        ]);
        $moderator->roles()->syncWithoutDetaching([
            $moderatorRole->id
        ]);
    }
}