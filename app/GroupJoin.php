<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupJoin extends Model
{
    protected $table = "groups_join";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'join_id',
        'approved_by_id',
        'group_id',
        'request_sent_date',
        'request_approved_date',
        'token',
        'status',
        'notification_id'
    ];
}