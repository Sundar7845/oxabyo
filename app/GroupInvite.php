<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupInvite extends Model
{
    protected $table = "groups_invite";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invitee_id',
        'invite_sent_by',
        'group_id',
        'is_invite_sent',
        'is_invite_accept',
        'invite_sent_date',
        'invite_accept_date',
        'invite_reject_date',
        'token',
        'notification_id'
    ];
}