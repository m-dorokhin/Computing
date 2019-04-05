<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public function computing()
    {
        return $this->belongsToMany('App\Computing');
    }
}
