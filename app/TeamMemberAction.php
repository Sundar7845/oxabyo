<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMemberAction extends Model
{
    protected $table = "team_member_actions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_member_id',
        'team_action_id',
        'date',
        'status'
    ];
}
