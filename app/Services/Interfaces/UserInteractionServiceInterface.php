<?php

namespace App\Services\Interfaces;

/* Model */
use App\User;

interface UserInteractionServiceInterface
{
    /**
     * Get All User Friends
     * 
     *
     * @return
     */
    public function getAllUserFriends();
}