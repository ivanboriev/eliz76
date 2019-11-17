<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'address',
        'temp',
        'atm',
        'humidity',
        'isolate',
        'phase',
        'automate',
        'uzo',
        'engineer1',
        'engineer2',
        'photo_path',
        'customer_id',
        'isolate_equip',
        'phase_equip',
        'uzo_equip',
        'automate_equip',
        'contur_equip',
        'teplovizor_equip',
        'min',
        'max',
        'contur_temp'
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'isolate_equip' => 'array',
        'phase_equip' => 'array',
        'uzo_equip' => 'array',
        'automate_equip' => 'array',
        'contur_equip' => 'array',
        'teplovizor_equip' => 'array',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function clusters()
    {
        return $this->hasMany(Cluster::class);
    }
}
