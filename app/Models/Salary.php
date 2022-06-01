<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'salaries';
    protected $fillable = [
        'name',
        'salary_payable',
    ];
    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['name'])) {
            $arr_user = json_decode($req['name']);
            if (is_array($arr_user) && !empty($arr_user)) {
               $query->whereIn('id', $arr_user); 
            } 
        };
        return $query;
    }
}
