<?php

namespace App\Repositories\Interfaces;

interface UserSubscriptionPlanRepositoryInterface
{
    /**
     * Create a new UserSubscriptionPlan
     * 
     * @param array $data         - [ key => value ]
     *
     * @return UserSubscriptionPlan
     */
    public function create($data);

    /**
     * Update UserSubscriptionPlan
     * 
     * @param int   $id           - UserSubscriptionPlan.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Find a UserSubscriptionPlan
     * 
     * @param int   $id           - UserSubscriptionPlan.id
     *
     * @return UserSubscriptionPlan
     */
    public function find(int $id);

    /**
     * Find a UserSubscriptionPlan By User Id
     * 
     * @param int   $id           - User.id
     *
     * @return UserSubscriptionPlan
     */
    public function findByUserId(int $id);

    /**
     * Find a UserSubscriptionPlanWithPermissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findCurrentUserPermissions(int $id);
}
