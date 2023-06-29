<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamGame extends Model
{
    protected $table = "team_games";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'game_id',
        'status'
    ];

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }
    
}
