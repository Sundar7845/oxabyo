<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitch extends Model
{
    protected $table = "twitch";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'twitch_user_id',
        'twitch_login',
        'twitch_display_name',
        'channel_name',
        'type',
        'online_status',
        'broadcaster_type',
        'description',
        'last_streaming',
        'followers',
        'subscribers',
        'last_cover',
        'status',
    ];

    public function getChannelNameAttribute($channel_name)
    {
        // $this->attributes['channel_name'] = $channel_name;
        return $this->attributes['channel_name'] = 'https://player.twitch.tv/?channel='.  $channel_name .'&parent='.env('TWITCH_ALLOW_HOST').'&muted=true';
    }
}
