<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupActions extends Model
{
    protected $table = "group_actions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'key'
    ];
}