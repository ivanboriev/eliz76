<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equip extends Model
{
    protected $fillable = [
        'name', 'factory_number', 'type', 'check_date', 'next_check_date'
    ];
    protected $dates = ['created_at', 'updated_at', 'check_date', 'next_check_date'];
}
