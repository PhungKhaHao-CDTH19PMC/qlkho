<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public function user_permision()
    {
        return $this->hasMany(User_permision::class,'permission_id','id');
    }
}
