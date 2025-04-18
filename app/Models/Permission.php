<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
   use SoftDeletes;

   /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
   protected $fillable = ['name', 'slug', 'group', 'description'];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
   protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


   /**
    * The attributes that should be cast.
    *
    * @return array<string, string>
    */
   protected function casts(): array
   {
      return [
         'created_at' => 'datetime:Y-m-d H:i:s',
         'updated_at' => 'datetime:Y-m-d H:i:s',
         'deleted_at' => 'datetime:Y-m-d H:i:s',
      ];
   }

   public function roles()
   {
      return $this->belongsToMany(Role::class);
   }
}
