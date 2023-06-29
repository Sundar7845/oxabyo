<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlayerDetail extends Model
{
    protected $table = "event_player_details"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'event_player_team_id',
        'is_admin',
        'is_champion'
    ];

    public function players()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function live_comments()
    {
        return $this->hasMany('App\LiveComment','player_id','player_id')->where('can_hide', '0');
    }
}
