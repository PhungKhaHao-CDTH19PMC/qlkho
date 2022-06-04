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
        'code',
        'user_id',
        'signing_date',
        'start_date',
        'finish_date',
        'content',
        'salary_id',
    ];

    protected $appends = ['count_renewal'];

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

    public function contractExtension()
    {
        return $this->hasMany('App\Models\ContractExtension');
    }

    public function getCountRenewalAttribute()
    {
        $count = $this->contractExtension()->count();
        return $count;
    }

}
