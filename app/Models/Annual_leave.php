<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annual_leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'finish_date',
        'user_id',
        'total_day',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['user_id'])) {
            $arr_user_id = json_decode($req['user_id']);
            if (is_array($arr_user_id) && !empty($arr_user_id)) {
               $query->whereIn('user_id', $arr_user_id); 
            } 
        };

        return $query;
    }
}
