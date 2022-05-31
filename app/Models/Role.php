<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // public function scopeQueryData($query, $req)
    // {      
    //     if (!empty($req['name'])) {
    //         $arr_name = json_decode($req['name']);
    //         if (is_array($arr_name) && !empty($arr_name)) {
    //            $query->whereIn('name', $arr_name); 
    //         } 
    //     };

    //     return $query;
    // }

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['id'])) {
            $arr_role = json_decode($req['id']);
            if (is_array($arr_role) && !empty($arr_role)) {
               $query->whereIn('id', $arr_role); 
            } 
        };
        return $query;
    }
    public function listPermission()
    {
        return $this->belongsToMany(Permission::class,'role_has_permissions','role_id','permission_id','id','id');
    }
}
