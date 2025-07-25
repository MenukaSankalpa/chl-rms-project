<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    //
    public function vessel(){
        return $this->belongsTo('App\Vessel','vessel_id','id');
    }
}
