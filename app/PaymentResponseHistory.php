<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentResponseHistory extends Model
{
    protected $table = "payment_response_history";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'transaction_id',
        'json_response',
        'date_paid',
        'payment_status'
    ];
}
