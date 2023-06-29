<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPayment extends Model
{
    protected $table = "event_payments"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'event_id',
        'organizer_id',
        'total_payment_amount',
        'payment_amount_oxabyo',
        'payment_amount_organizer',
        'date_paid',
        'payment_status'
    ];
}
