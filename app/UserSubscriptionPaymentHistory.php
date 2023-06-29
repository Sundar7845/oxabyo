<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionPaymentHistory extends Model
{
    protected $table = "user_subscription_payment_history";

    protected $fillable = [
        'user_id', 
        'pricing_plan_id', 
        'user_subscription_plan_id',
        'number_of_plans', 
        'is_month', 
        'is_year', 
        'invoice_amount', 
        'start_date',
        'end_date', 
        'date_subscribed', 
        'date_unsubscribed', 
        'date_paid', 
        'payment_status', 
        'plan_status'
    ];
}
