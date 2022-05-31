<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_has_permission extends Model
{
    protected $table = 'role_has_permissions';
    use HasFactory;
    // public function Permission()
    // {
    //     return $this->belongsTo(Permission::class,'id','permission_id');
    // }
}
