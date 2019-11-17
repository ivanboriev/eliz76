<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shield extends Model
{
    protected $fillable = ['name', 'cluster_id', 'order', 'group_name', 'min', 'max'];
    protected $casts = ['isolate_data' => 'array','phase_data' => 'array', 'uzo_data' => 'array', 'automate_data' => 'array'];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
