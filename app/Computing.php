<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computing extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function codes()
    {
        return $this->belongsToMany('App\Code');
    }
}
