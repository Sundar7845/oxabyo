<?php 

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\UserSubscriptionPlanRepositoryInterface;

/* Model */
use App\UserSubscriptionPlan;

class UserSubscriptionPlanRepository implements UserSubscriptionPlanRepositoryInterface
{
    /**
     * Create a new UserSubscriptionPlan
     * 
     * @param array $data         - [ key => value ]
     *
     * @return UserSubscriptionPlan
     */
    public function create($data)
    {
        return UserSubscriptionPlan::create($data); 
    }

    /**
     * Update UserSubscriptionPlan
     * 
     * @param int   $id           - UserSubscriptionPlan.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return UserSubscriptionPlan::where('id', $id)->update($data);
    }

    /**
     * Find a UserSubscriptionPlan
     * 
     * @param int   $id           - UserSubscriptionPlan.id
     *
     * @return UserSubscriptionPlan
     */
    public function find(int $id)
    {
        return UserSubscriptionPlan::find($id);
    }

    /**
     * Find a UserSubscriptionPlan By User Id
     * 
     * @param int   $id           - User.id
     *
     * @return UserSubscriptionPlan
     */
    public function findByUserId(int $id)
    {
        return UserSubscriptionPlan::where('user_id', $id)->first();
    }

    /**
     * Find a UserSubscriptionPlanWithPermissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findCurrentUserPermissions(int $id)
    {
        return UserSubscriptionPlan::with([
            'pricing_plan',
            'subscription_permissions',
            'subscription_permissions.permissions'
        ])->first();
    }
}
