<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventWatchedAudit extends Model
{
    protected $table = "event_watched_audit"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'event_id', 
        'is_watched'
    ];
}
