<?php

namespace App\Services\Interfaces;

interface EventInviteServiceInterface
{
    public function inviteUsers($inviteUsers, $event, $isChampion);

    public function inviteEventAdmin($inviteEventAdmin, $event);

    public function inviteTeamEvents($inviteEventAdmin, $event);
}
