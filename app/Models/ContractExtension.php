<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class ContractExtension extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'renewal_date_start',
        'renewal_date_finish',
        'salary_factor',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function user()
    {   
        //id -> index 1 => bảng Insurance lk bảng Contract : Contract.id
        //id -> index 2 => bảng Customer lk bảng Contract : Customer.id
        return $this->hasOneThrough('App\Models\User', 'App\Models\Contract', 'id', 'id', 'contract_id', 'user_id');
    }
}
