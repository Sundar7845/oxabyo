<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = "team_members";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'user_id',
        'team_joinee_id',
        'team_invite_id',
        'is_admin',
        'status'
    ];

    public function teams()
    {
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
