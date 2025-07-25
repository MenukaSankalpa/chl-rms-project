<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulkEdit extends Model
{
    //
    public function bulk_edit_rows(){
        return $this->hasMany('App\BulkEditRow','bulk_edit_id','id');
    }
}
