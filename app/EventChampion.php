<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventChampion extends Model
{
    protected $table = "event_champions"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'winner_id',
        'runner_id',
        'number_of_rounds_played',
        'date'
    ];
}
