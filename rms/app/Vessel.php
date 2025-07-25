<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    //
    public function voyage(){
        return $this->hasMany('App\Voyage','vessel_id','id');
    }
}
