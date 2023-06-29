<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardType extends Model
{
    protected $table = "reward_types";

    protected $fillable = [
        'key', 'full_name', 'short_name'
    ];
}
