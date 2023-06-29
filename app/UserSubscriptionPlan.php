<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionPlan extends Model
{
    protected $table = "user_subscription_plans";

    protected $fillable = [
        'user_id', 'pricing_plan_id', 'number_of_plans', 'is_month', 'is_year', 'invoice_amount', 'start_date',
        'end_date', 'date_subscribed', 'date_unsubscribed', 'date_paid', 'payment_status', 'plan_status'
    ];

    public function subscription_permissions()
    {
        return $this->hasMany('App\SubscriptionPermission', 'pricing_plan_id', 'pricing_plan_id');
    }

    public function pricing_plan()
    {
        return $this->belongsTo('App\PricingPlan', 'pricing_plan_id', 'id');
    }
}
