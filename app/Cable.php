<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
    protected $fillable = ['name', 'full_name', 'weight', 'count', 'voltage'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getVoltageAttribute()
    {
        return $this->weight >= 16 ? 2500 : 1000;
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->count . 'x' . $this->weight;
    }
}
