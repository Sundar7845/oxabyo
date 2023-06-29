<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerType extends Model
{
    protected $table = "player_types"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description', 
        'status'
    ];
}
