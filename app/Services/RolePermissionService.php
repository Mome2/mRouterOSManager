<?php

namespace App\Services;

use App\Models\Role;

class RolePermissionService
{
   public function sync(Role $role, array $permissionIds): void
   {
      foreach ($permissionIds as $id) {
         $role->permissions()->syncWithoutDetaching($id);
      }
   }

   public function detach(Role $role, array $permissionIds): void
   {
      foreach ($permissionIds as $id) {
         $role->permissions()->detach($id);
      }
   }
}
