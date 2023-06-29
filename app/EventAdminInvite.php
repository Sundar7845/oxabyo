<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventAdminInvite extends Model
{
    protected $table = "event_admin_invites"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'invitee_id',
        'invite_sent_by',
        'is_invite_accept',
        'token',
        'status',
        'date',
        'notification_id',
    ];
}
