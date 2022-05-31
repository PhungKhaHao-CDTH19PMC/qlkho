<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['name'])) {
            $arr_name = json_decode($req['name']);
            if (is_array($arr_name) && !empty($arr_name)) {
               $query->whereIn('name', $arr_name); 
            } 
        };

        return $query;
    }
}
