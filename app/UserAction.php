<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    protected $table = "user_actions";

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
