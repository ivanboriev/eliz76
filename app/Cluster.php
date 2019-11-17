<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $fillable = ['name', 'subject_id', 'order'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function shields()
    {
        return $this->hasMany(Shield::class);
    }


}
