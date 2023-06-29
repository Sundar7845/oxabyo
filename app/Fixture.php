<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $table = "fixtures"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'event_phase_id',
        'challenger1_id',
        'challenger2_id',
        'date',
        'time'
    ];

    public function fixture_results()
    {
        return $this->hasOne('App\FixtureResult','fixture_id','id');
    }

    public function challenger1()
    {
        return $this->hasOne('App\EventPlayerDetail','id','challenger1_id');
    }

    public function challenger2()
    {
        return $this->hasOne('App\EventPlayerDetail','id','challenger2_id');
    }
}
