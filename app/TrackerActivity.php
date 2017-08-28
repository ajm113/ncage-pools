<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\QueryOptionsBuilder;

class TrackerActivity extends Model
{
    protected $table = 'tracker_activity';
    protected $fillable = ['id'];
    public $timestamps = false;

    public function TrackerEventType()
    {
        return $this->belongsToMany('App\TrackerEventType');
    }
}
