<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlayerVote extends Model
{
    protected $table = "event_player_votes"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'event_player_id',
        'performance',
        'ynfluence',
        'monetization'
    ];
}
