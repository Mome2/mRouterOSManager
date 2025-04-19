<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Pivot\UserRole;
use App\Http\Requests\Pivot\RemoveRoleUser;


class UserRoleController extends Controller
{
   public function assign(UserRole $request)
   {
      /** @var \Illuminate\Http\Request $request */
      $user = User::findOrFail($request->input('user_id'));
      $roleIds = $request->input('role_ids');

      foreach ($roleIds as $roleId) {
         $user->roles()->syncWithoutDetaching($roleId);
      }

      return back()->with('success', 'Roles Added successfully');
   }

   public function remove(RemoveRoleUser $request)
   {
      /** @var \Illuminate\Http\Request $request */
      $user = User::findOrFail($request->input('user_id'));
      $roleIds = $request->input('role_ids');

      foreach ($roleIds as $roleId) {
         $user->roles()->detach($roleId);
      }

      return back()->with('success', 'Roles removed successfully');
   }
}
