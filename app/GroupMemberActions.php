<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMemberActions extends Model
{
    protected $table = "group_member_action";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_member_id',
        'group_action_id',
        'date',
        'status'
    ];
}