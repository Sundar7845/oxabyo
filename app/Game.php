<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = "games";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'status'
    ];

    public function user_games()
    {
        return $this->belongsTo('App\UserGame',  'id', 'game_id')->where('user_games.user_id', auth()->id());
    }
}
