<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrganizerPaymentHistory extends Model
{
    protected $table = "event_organizer_payment_history"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'organizer_id',
        'event_id',
        'amount',
        'date_paid',
        'payment_status'
    ];
}
