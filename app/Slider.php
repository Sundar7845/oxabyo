<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "sliders";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'position',
        'title',
        'image',
        'event_link',
        'status'
    ];

    public function events()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
