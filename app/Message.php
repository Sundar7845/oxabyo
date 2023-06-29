<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";

    protected $fillable = [
        'created_by_id', 
        'subject',
        'message_body',
        'group_image',
        'status'
    ];
}
