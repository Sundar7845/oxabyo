<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FixtureResult extends Model
{
    protected $table = "fixture_results"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fixture_id', 
        'winner_id',
        'runner_id',
        'number_of_rounds_played',
        'status',
        'date'
    ];

    public function winner()
    {
        return $this->hasOne('App\EventPlayerDetail','id','winner_id');
    }
    
    public function looser()
    {
        return $this->hasOne('App\EventPlayerDetail','id','runner_id');
    }
}
