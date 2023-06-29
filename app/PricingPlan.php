<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $table = 'pricing_plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'plan_name',
        'month_price',
        'year_price',
        'is_active'
    ];
}
