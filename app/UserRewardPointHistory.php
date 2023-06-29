<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRewardPointHistory extends Model
{
    protected $table = "user_reward_point_history";

    protected $fillable = [
        'parent_id', 'user_id', 'event_id', 'reward_type_id', 'event_point_mapping_id', 'event_phase_id', 'fixture_id', 'points', 'status', 'expired_at'
    ];
}
