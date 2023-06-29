<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlayerTeam extends Model
{
    protected $table = "event_player_teams"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'team_id'
    ];
}
