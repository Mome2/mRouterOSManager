<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'avatar' => 'adminavatar.png',
            'name' => 'Super',
            'surname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'display_name' => 'Super Admin',
            'description' => 'This is the super admin role',
        ]);

        $permission = Permission::create([
            'name' => 'Full',
            'display_name' => 'Full Access',
            'description' => 'This is the admin permission',
        ]);

        $role->permissions()->sync($permission->id);
        $user->roles()->sync($role->id);
    }
}
