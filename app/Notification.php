<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable=['sender_user_id','receiver_user_id','title','message','accept_href','decline_href','is_read'];
}
