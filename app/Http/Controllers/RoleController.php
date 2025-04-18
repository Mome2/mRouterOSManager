<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\TRoles\AddRole;
use App\Http\Requests\TRoles\EditRole;
use App\Http\Requests\TRoles\DeleteRole;
use App\Http\Requests\TRoles\RestoreRole;
use App\Http\Requests\TRoles\ForceDeleteRole;

class RoleController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $roles = Role::paginate(10);
      return view('superdashboard.roles.index', compact('roles'));
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      return view('superdashboard.roles.create');
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(AddRole $request)
   {
      Role::create($request->validated());
      return redirect()->route('superdashboard.roles.index')
         ->with('success', 'Role created successfully.');
   }

   /**
    * Display the specified resource.
    */
   public function show(Role $role)
   {
      return view('superdashboard.roles.show', compact('role'));
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Role $role)
   {
      return view('superdashboard.roles.edit', compact('role'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(EditRole $request, Role $role)
   {
      $role->update($request->validated());
      return redirect()->route('superdashboard.roles.index')
         ->with('success', 'Role updated successfully.');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(DeleteRole $request)
   {
      /**@var \Illuminate\Http\Request $request */
      Role::destroy($request->input('id'));
      return redirect()->route('superdashboard.roles.index')
         ->with('success', 'Role deleted successfully.');
   }

   /**
    * Restore the specified resource from storage.
    */
   public function restore(RestoreRole $request)
   {
      /**@var \Illuminate\Http\Request $request */
      Role::withTrashed()->restore($request->input('id'));
      return redirect()->route('superdashboard.roles.index')
         ->with('success', 'Role restored successfully.');
   }

   /**
    * Force delete the specified resource from storage.
    */
   public function forceDelete(ForceDeleteRole $request)
   {
      /**@var \Illuminate\Http\Request $request */
      Role::withTrashed()->forceDelete($request->input('id'));
      return redirect()->route('superdashboard.roles.index')
         ->with('success', 'Role permanently deleted.');
   }
}
