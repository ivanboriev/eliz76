<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Template extends Model
{
    protected $fillable = ['name','type','url','path'];
}
