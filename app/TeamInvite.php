<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $table = "team_invites";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invitee_id',
        'invite_sent_by',
        'team_id',
        'is_invite_sent',
        'is_invite_accept',
        'invite_sent_date',
        'invite_accept_date',
        'invite_reject_date',
        'token',
        'notification_id'
    ];
}
