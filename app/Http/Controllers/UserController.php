<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\TUsers\AddUser;
use app\http\requests\TUsers\ForceDeleteUser;
use app\http\requests\TUsers\RestoreUser;
use app\http\requests\TUsers\DeleteUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index()
   {
      //
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(AddUser $request)
   {
      /**@var \Illuminate\Http\Request $request */

      User::create([
         'name' => $request->name,
         'surname' => $request->surname,
         'username' => $request->username,
         'email' => $request->email,
         'phone' => $request->phone,
         'password' => Hash::make('12345678'),
      ]);
      return redirect()->route('Super.index.users')
         ->with('success', 'User created successfully.');
   }

   /**
    * Display the specified resource.
    */
   public function show(User $user)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(DeleteUser $request)
   {
      /**@var \Illuminate\Http\Request $request */
      User::destroy($request->input('id'));
      return redirect()->route('Super.index.users')
         ->with('success', 'User deleted successfully.');
   }

   /**
    * Restore the specified resource from storage.
    */
   public function restore(RestoreUser $request)
   {
      /**@var \Illuminate\Http\Request $request */
      User::withTrashed()->restore($request->input('id'));
      return redirect()->route('Super.index.users')
         ->with('success', 'User restored successfully.');
   }

   /**
    * Force delete the specified resource from storage.
    */
   public function forceDelete(ForceDeleteUser $request)
   {
      /**@var \Illuminate\Http\Request $request */
      User::withTrashed()->forceDelete($request->input('id'));
      return redirect()->route('Super.index.users')
         ->with('success', 'User permanently deleted.');
   }
}
