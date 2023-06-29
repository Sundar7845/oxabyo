<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'user_role_id', 
        'username',
        'surename',
        'dob',
        'address',
        'city',
        'bio_data',
        'profile_image',
        'profile_color',
        'token',
        'activated',
        'last_logged_in_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function isAdmin($user)
    {
        return $user->roles()->first()->key == 'admin' ?? null;
    }

    public static function isUser($user)
    {
        return $user->roles()->first()->key == 'user' ?? null;
    }

    public function roles()
    {
        return $this->belongsTo('App\Role', 'user_role_id', 'id');
    }

    public function friends()
    {
        return $this->belongsTo('App\UserFriend', 'id', 'friend_id');
    }

    public function twitch()
    {
        return $this->hasOne('App\Twitch','user_id','id');
    }

  
}
