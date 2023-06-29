<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $table = "user_games";

    protected $fillable = [
        'user_id',
        'game_id',
        'is_played'
    ];
    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }
}
