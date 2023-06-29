<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamAction extends Model
{
    protected $table = "team_actions";

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
