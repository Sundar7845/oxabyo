<?php 

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\UserFriendRepositoryInterface;

/* Model */
use App\User;

class UserFriendRepository implements UserFriendRepositoryInterface
{
    /**
     * Get All User Friends
     * 
     *
     * @return
     */
    public function getAllUserFriends()
    {
        return User::join('user_friends', 'user_friends.friend_id', 'users.id')
            ->where('users.id', '!=', Auth()->user()->id)
            ->where('user_friends.user_id',   Auth()->user()->id)
            ->where('user_role_id', '!=', 1)
            ->where('user_friends.is_connected',1)
            ->where('user_friends.is_blocked',0)
            ->select('users.*')
            ->orderBy('users.name', 'ASC')
            ->get();
    }
}
