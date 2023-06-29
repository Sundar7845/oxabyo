<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOxabyoPaymentHistory extends Model
{
    protected $table = "event_oxabyo_payment_history"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'event_id',
        'amount',
        'date_paid',
        'payment_status'
    ];
}
