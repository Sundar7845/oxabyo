<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRewardPoint extends Model
{
    protected $table = "user_reward_points";

    protected $fillable = [
        'user_id', 'reward_type_id', 'points'
    ];
}
