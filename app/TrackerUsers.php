<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackerUsers extends Model
{
    protected $table = 'tracker_users';
    protected $fillable = ['id'];
    public $timestamps = false;

    public function TrackerActivity()
    {
        return $this->belongsToMany('App\TrackerActivity');
    }

    public function TrackerIp()
    {
        return $this->belongsToMany('App\TrackerIp');
    }
}
