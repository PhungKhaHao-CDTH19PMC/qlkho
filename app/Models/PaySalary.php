<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaySalary extends Model
{
    use HasFactory;
    protected $table = 'pay_salaries';
    protected $fillable = [
        'user_id',
        'salary_id',
        'working_day',
        'salary',
        'allowance',
        'total',
        'advance',
        'actual_salary',
        'month',
        'status'
    ];

    public function scopeQueryData($query, $req)
    {
        if (!empty($req['user_id'])) {
            $arr_user = json_decode($req['user_id']);
            if (is_array($arr_user) && !empty($arr_user)) {
                // dd($arr_user);
                foreach($arr_user as $arr)
                {
                    $query->orwhere('month','LIKE', "%$arr%"); 
                }
            } 
        };
        if(empty($req['user_id'])||$req['user_id']=="[]")
        {
            // dd($req['user_id']);
            $monthNow =substr(Carbon::now()->format('d-m-Y H:i:s'),4,7);
            $query->where('month','LIKE',"%$monthNow%")->get();
        }
        return $query;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salarys()
    {
        return $this->belongsTo(Salary::class,'salary_id','id');
    }

    public function getstatusAttribute($value) 
    {
        if($value == 0){
                return $this->status = 'Chưa xác nhận';
        }else{
                return $this->status = 'Đã xác nhận';
        }
    }

    // public function getmonthAttribute($value) 
    // {
    //     // dd( Carbon::parse($value)->format('m-Y'));
    //     return $this->updated_at = Carbon::parse($value)->format('m-Y');
    // }
}
