<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPointMapping extends Model
{
    protected $table = "event_point_mappings";

    protected $fillable = [
        'reward_type_id', 'category_id', 'key', 'value', 'points', 'is_active'
    ];
}
