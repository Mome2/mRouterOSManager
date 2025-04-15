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
            'name' => 'Super Admin',
            'slug' => 'super_admin',
            'description' => 'This is the super admin role',
        ]);

        $permissions = [
            [
                'name' => 'Full Access',
                'slug' => 'full_access',
                'group' => 'system',
                'description' => 'This is the admin permission',
            ],
            [
                'name' => 'Add Role',
                'slug' => 'add_role',
                'group' => 'roles',
                'description' => 'Can add roles',
            ],
            [
                'name' => 'Add Permission',
                'slug' => 'add_permission',
                'group' => 'permissions',
                'description' => 'Can add permissions',
            ],
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
            $role->permissions()->syncWithoutDetaching([$permission->id]);
        }

        $user->roles()->sync([$role->id]);
    }
}
