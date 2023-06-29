<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "groups";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_admin_id',
        'game_id',
        'name',
        'description',
        'group_image',
        'group_color',
        'status'
    ];

    public function games()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'group_admin_id', 'id');
    }

    public function group_members_count()
    {
        return $this->hasMany('App\GroupMember', 'group_id', 'id');
    }    
    public function members()
    {
        return $this->hasMany('App\GroupMember', 'group_id', 'id');
    }
}
