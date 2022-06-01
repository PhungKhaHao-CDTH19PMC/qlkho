<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary;

class Contract extends Model
{
    use HasFactory;
    protected $table = 'contracts';
    protected $fillable = [
        'start_date',
        'finish_date',
        'user_id',
        'signing_date',
        'content',
        'renewal_number',
        'renewal_date',
        'salary_factor',
        'salary_id',
        'code'

    ];
    public function scopeQueryData($query, $req)
    {      
        if (!empty($req['user_id'])) {
            $arr_user = json_decode($req['user_id']);
            if (is_array($arr_user) && !empty($arr_user)) {
               $query->whereIn('user_id', $arr_user); 
            } 
        };
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
}
