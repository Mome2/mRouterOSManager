<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\TPermissions\AddPermission;
use App\Http\Requests\TPermissions\EditPermission;
use App\Http\Requests\TPermissions\DeletePermission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      $permissions = Permission::paginate(10);
      return view('superdashboard.permissions.index', compact('permissions'));
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      return view('superdashboard.permissions.create');
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(AddPermission $request)
   {
      Permission::create($request->validated());
      return redirect()->route('superdashboard.permissions.index')->with('success', 'Permission created successfully.');
   }

   /**
    * Display the specified resource.
    */
   public function show(Permission $permission)
   {
      return view('superdashboard.permissions.show', compact('permission'));
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Permission $permission)
   {
      return view('superdashboard.permissions.edit', compact('permission'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(EditPermission $request, Permission $permission)
   {
      $permission->update($request->validated());
      return redirect()->route('superdashboard.permissions.index')->with('success', 'Permission updated successfully.');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(DeletePermission $request, Permission $permission)
   {
      $permission->delete();
      return redirect()->route('superdashboard.permissions.index')->with('success', 'Permission deleted successfully.');
   }

   /**
    * Restore the specified resource from storage.
    */
   public function restore(Permission $permission)
   {
      $permission->restore();
      return redirect()->route('superdashboard.permissions.index')->with('success', 'Permission restored successfully.');
   }

   /**
    * Force delete the specified resource from storage.
    */
   public function forceDelete(Permission $permission)
   {
      $permission->forceDelete();
      return redirect()->route('superdashboard.permissions.index')->with('success', 'Permission permanently deleted.');
   }
}
