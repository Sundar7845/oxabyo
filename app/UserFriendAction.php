<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFriendAction extends Model
{
    protected $table = "user_friend_actions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_friend_id',
        'user_action_id',
        'date',
        'status'
    ];
}
