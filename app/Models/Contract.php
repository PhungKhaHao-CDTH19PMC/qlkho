<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['code'])) {
            $arr_code = json_decode($req['code']);
            if (is_array($arr_code) && !empty($arr_code)) {
               $query->whereIn('code', $arr_code); 
            } 
        };
        return $query;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
