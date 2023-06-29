<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPhase extends Model
{
    protected $table = "event_phases"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'phase_id',
        'match_date',
        'match_time',
        'active_phase',
        'status'
    ];

    public function fixtures()
    {
        return $this->hasMany('App\Fixture','event_phase_id','id');
    }

    public function phases()
    {
        return $this->belongsTo('App\Phase','phase_id','id');
    }
}
