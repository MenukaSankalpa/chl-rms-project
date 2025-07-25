<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    //
    protected $fillable = array('url','method','ip','user_id','request_json','guard');
}
