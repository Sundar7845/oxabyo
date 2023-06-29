<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupGame extends Model
{
    protected $table = "group_games";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'game_id',
        'status'
    ];

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }
}