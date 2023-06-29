<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\SubscriptionServiceInterface;

/* Repository */
use App\Repositories\UserSubscriptionPlanRepository;

class SubscriptionService implements SubscriptionServiceInterface
{

    /** @var UserSubscriptionPlanRepository */
    private $userSubscriptionPlanRepository;

    /**
     * SubscriptionService constructor.
     *
     * @param UserSubscriptionPlanRepository              $userSubscriptionPlanRepository
     */
    public function __construct(
        UserSubscriptionPlanRepository $userSubscriptionPlanRepository
    ) {
        $this->userSubscriptionPlanRepository = $userSubscriptionPlanRepository;
    }

    /**
     * Create a User Subscription Plan With Permissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function createSubscriptionPlanByUserId($data)
    {
        return $this->userSubscriptionPlanRepository->create($data);
    }

    /**
     * Find a subscription plan by user id
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findSubscriptionPlanByUserId($id)
    {
        return $this->userSubscriptionPlanRepository->findByUserId($id);
    }

    /**
     * Find a User Subscription Plan With Permissions
     * 
     * @param int   $id           - user.id
     *
     * @return UserSubscriptionPlan
     */
    public function findCurrentUserPermissions(int $id)
    {
        return $this->userSubscriptionPlanRepository->findCurrentUserPermissions($id);
    }
}
