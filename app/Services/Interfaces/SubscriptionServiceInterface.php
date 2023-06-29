<?php

namespace App\Services\Interfaces;

interface SubscriptionServiceInterface
{
    /**
     * Create a User Subscription Plan With Permissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function createSubscriptionPlanByUserId($data);

    /**
     * Find a subscription plan by user id
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findSubscriptionPlanByUserId($id);

    /**
     * Find a User Subscription Plan With Permissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findCurrentUserPermissions(int $id);
}
