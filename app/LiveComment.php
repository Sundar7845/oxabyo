<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveComment extends Model
{
    protected $table = "live_comments"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id', 
        'created_by_id',
        'event_id',
        'player_id',
        'can_hide'
    ];

    public function comments()
    {
        return $this->belongsTo('App\Comment','comment_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by_id','id');
    }

}
