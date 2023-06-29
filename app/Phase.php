<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $table = "phases";

    protected $fillable = [
        'key', 'action', 'value'
    ];
}
