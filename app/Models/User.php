<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
   /** @use HasFactory<\Database\Factories\UserFactory> */
   use Notifiable, SoftDeletes;

   /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
   protected $fillable = [
      'avatar',
      'name',
      'surname',
      'username',
      'password',
      'email',
      'phone',
      'locale',
      'status',
      'two_factor_code',
      'two_factor_code_expiry',
      'two_factor_enabled',
   ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];

   /**
    * The attributes that should be cast.
    *
    * @return array<string, string>
    */
   protected function casts(): array
   {
      return [
         'email_verified_at' => 'datetime:Y-m-d H:i:s',
         'created_at' => 'datetime:Y-m-d H:i:s',
         'updated_at' => 'datetime:Y-m-d H:i:s',
         'deleted_at' => 'datetime:Y-m-d H:i:s',
         'password' => 'hashed',
      ];
   }

   public function roles()
   {
      return $this->belongsToMany(Role::class);
   }

   public function hasRole($role)
   {

      return $this->roles->pluck('slug')->contains(str($role)
         ->squish()
         ->lower()
         ->replaceMatches('/[^a-zA-Z0-9]+/', '_')
         ->replaceMatches('/[0-9]+/', '')
         ->trim('_'));
   }

   public function hasPermission($permission)
   {
      foreach ($this->roles as $role) {
         if ($role->permissions->contains('slug', $permission)) {
            return true;
         }
      }

      if ($this->hasPermission('full_access')) {
         return true;
      }

      return false;
   }

   public function generateTwoFactorCode(): void
   {
      $this->two_factor_code = rand(100000, 999999);
      $this->two_factor_expires_at = now()->addMinutes(10);
      $this->save();
   }

   public function resetTwoFactorCode(): void
   {
      $this->two_factor_code = null;
      $this->two_factor_expires_at = null;
      $this->save();
   }
}
