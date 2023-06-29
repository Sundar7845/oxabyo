<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "events"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organizer_id',
        'player_id', 
        'player_type_id', 
        'event_type_id',
        'game_id',
        'name',
        'description',
        'rules',
        'image',
        'cover',
        'prize_money',
        'match_date',
        'match_hour',
        'time_zone',
        'oxarate_min',
        'performance_rating_min',
        'ynfluence_rating_min',
        'monetization_rating_min',
        'ticket',
        'allow_players_streaming',
        'number_of_rounds',
        'max_num_players',
        'is_champion_invite',
        'status'
    ];
    
    public function players()
    {
        return $this->belongsTo('App\User', 'player_id', 'id');
    }

    public function player_types()
    {
        return $this->belongsTo('App\PlayerType', 'player_type_id', 'id');
    }

    public function event_types()
    {
        return $this->belongsTo('App\EventType', 'event_type_id', 'id');
    }

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }

    public function organizer()
    {
        return $this->belongsTo('App\User', 'organizer_id', 'id');
    }

    public function event_players()
    {
        return $this->belongsTo('App\EventPlayerDetail', 'id', 'event_id');
    }
}
