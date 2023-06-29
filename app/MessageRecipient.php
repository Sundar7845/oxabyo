<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRecipient extends Model
{
    protected $table = "message_recipients";

    protected $fillable = [
        'sender_user_id', 
        'receiver_user_id',
        'group_id',
        'message_id',
        'is_read'
    ];
}
