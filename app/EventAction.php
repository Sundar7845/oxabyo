<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventAction extends Model
{
    protected $table = "event_actions"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'action'
    ];
}
