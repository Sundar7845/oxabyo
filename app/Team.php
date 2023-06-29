<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'admin_user_id',
        'name',
        'description',
        'team_image',
        'team_color',
        'status'
    ];

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','admin_user_id','id');
    }
    public function members()
    {
        return $this->hasMany('App\TeamMember','team_id','id');
    }
}
