<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReeferMonitoring extends Model
{
    //
    protected $appends = [
        'schedule4_at',
        'schedule8_at',
        'schedule12_at',
        'schedule16_at',
        'schedule20_at',
        'schedule24_at',
    ];

    public function container(){
        return $this->belongsTo('App\Container');
    }

    public function getSchedule4AtAttribute(){
        if($this->date!=''){
            return $this->date.' 04:00:00';
        }
        return null;
    }
    public function getSchedule8AtAttribute(){
        if($this->date!=''){
            return $this->date.' 08:00:00';
        }
        return null;
    }
    public function getSchedule12AtAttribute(){
        if($this->date!=''){
            return $this->date.' 12:00:00';
        }
        return null;
    }
    public function getSchedule16AtAttribute(){
        if($this->date!=''){
            return $this->date.' 16:00:00';
        }
        return null;
    }
    public function getSchedule20AtAttribute(){
        if($this->date!=''){
            return $this->date.' 20:00:00';
        }
        return null;
    }
    public function getSchedule24AtAttribute(){
        if($this->date!=''){
            return $this->date.' 23:59:59';
        }
        return null;
    }

}
