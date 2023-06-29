<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = "group_members";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id',
        'is_admin',
        'status'
    ];

    public function groups()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Insert multiple records.
     *
     * @param array $data
     *
     * @return bool
     */
    public function createMany(array $data): bool
    {
        return GroupMember::insert($data);
    }
}
