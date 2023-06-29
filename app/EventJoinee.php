<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventJoinee extends Model
{
    protected $table = "event_joinees"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 
        'joinee_id',
        'approved_by_id',
        'token',
        'status',
        'date',
        'notification_id',
    ];
}
