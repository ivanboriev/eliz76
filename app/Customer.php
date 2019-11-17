<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name','registry_number','contract_number',
        'address','price','contract_date','start_date','end_date'
    ];
    protected $dates = [
        'contract_date','start_date','end_date'
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
