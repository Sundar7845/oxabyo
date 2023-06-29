<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPermission extends Model
{
    protected $table = 'subscription_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pricing_plan_id', 'permission_id', 'value', 'is_unlimited', 'is_allowed'
    ];

    public function permissions()
    {
        return $this->belongsTo('App\Permission',  'permission_id', 'id');
    } 
}
