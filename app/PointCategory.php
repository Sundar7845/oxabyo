<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointCategory extends Model
{
    protected $table = "point_categories";

    protected $fillable = [
        'key', 'value', 'is_active'
    ];
}
