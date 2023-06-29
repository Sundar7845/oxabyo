<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFriend extends Model
{
    protected $table = "user_friends";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'friend_id',
        'is_blocked',
        'is_connected',
        'is_like',
        'is_abuse',
        'token',
        'status',
        'notification_id'
    ];
}
