<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackerIp extends Model
{

    protected $table = 'tracker_ips';
    protected $fillable = ['ip'];
    public $timestamps = false;
}
