<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maps extends Model
{
    protected $table = 'maps';
    protected $fillable = ['matchId', 'teamId', 'count', 'map'];
}