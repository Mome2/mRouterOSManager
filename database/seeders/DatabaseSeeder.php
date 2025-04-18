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
      $defaultuser = User::create([
         'avatar' => 'adminavatar.png',
         'name' => 'Super',
         'surname' => 'Admin',
         'username' => 'admin',
         'email' => 'admin@example.com',
         'password' => Hash::make('admin'),
      ]);

      $defaultrole = Role::create([
         'name' => 'Super Admin',
         'slug' => 'super_admin',
         'description' => 'This is the super admin role',
      ]);

      $defaultpermission = Permission::create([
         'name' => 'Full Access',
         'slug' => 'full_access',
         'group' => 'system',
         'description' => 'This is the admin permission',
      ]);

      $defaultrole->permissions()->sync([$defaultpermission->id]);
      $defaultuser->roles()->sync([$defaultrole->id]);
   }
}
