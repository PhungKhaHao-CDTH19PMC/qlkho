<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'fullname',
        'username',
        'password',
        'birthday',
        'citizen_identification',
        'email',
        'phone',
        'address',
        'role_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function guardName(){
        return "web";
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['fullname'])) {
            $arr_fullname = json_decode($req['fullname']);
            if (is_array($arr_fullname) && !empty($arr_fullname)) {
               $query->whereIn('fullname', $arr_fullname); 
            } 
        };

        if (!empty($req['phone'])) {
            $arr_phone = json_decode($req['phone']);
            if (is_array($arr_phone) && !empty($arr_phone)) {
               $query->whereIn('phone', $arr_phone); 
            } 
        };

        if (!empty($req['role_id'])) {
            $arr_role = json_decode($req['role_id']);
            if (is_array($arr_role) && !empty($arr_role)) {
               $query->whereIn('role_id', $arr_role); 
            } 
        };
        return $query;
    }
}
