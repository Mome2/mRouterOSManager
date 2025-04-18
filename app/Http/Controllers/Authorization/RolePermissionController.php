<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\Pivot\RolePermission;
use App\Http\Requests\Pivot\RemovePermissionRole;

class RolePermissionController extends Controller
{
   public function assign(RolePermission $request)
   {
      /** @var \Illuminate\Http\Request $request */
      $role = Role::findOrFail($request->input('role_id'));
      $permissionIds = $request->input('permission_ids');

      foreach ($permissionIds as $permissionId) {
         $role->permissions()->syncWithoutDetaching($permissionId);
      }

      return back()->with('success', 'Permissions Added successfully');
   }

   public function remove(RemovePermissionRole $request)
   {
      /** @var \Illuminate\Http\Request $request */
      $role = Role::findOrFail($request->input('role_id'));
      $permissionIds = $request->input('permission_ids');

      foreach ($permissionIds as $permissionId) {
         $role->permissions()->detach($permissionId);
      }


      return back()->with('success', 'Permission removed successfully');
   }
}
