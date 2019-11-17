<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name','numerable', 'consumer','cable_id','shield_id','automate_name','automate_category','automate_nominal','enter','diff','pred','uzo','order'
    ];

    public function shield()
    {
        return $this->belongsTo(Shield::class);
    }

    public function cable()
    {
        return $this->hasOne(Cable::class);
    }
}
