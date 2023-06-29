<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamJoinee extends Model
{
    protected $table = "team_joinees";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'joinee_id',
        'approved_by_id',
        'team_id',
        'request_sent_date',
        'request_approved_date',
        'token',
        'status',
        'notification_id'
    ];
}
