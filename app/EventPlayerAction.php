<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlayerAction extends Model
{
    protected $table = "event_player_actions"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'event_player_id',
        'event_action_id',
        'date',
        'status'
    ];
}
