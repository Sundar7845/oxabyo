<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Session;
use Auth, Log;
use Carbon\Carbon;

/* Models */
use App\Permission;

/* Services */
use App\Services\SubscriptionService;

trait SubscriptionTrait
{

    /** @var SubscriptionService */
    private $subscriptionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function setCurrentUserSubscription()
    {
        $currentPlan = $this->subscriptionService->findCurrentUserPermissions(Auth()->user()->id);
        Session::put('user_current_plan', $currentPlan);
    }

    public function getCurrentUserPermission()
    {

        if (!Session::get('user_current_plan')) {
            $this->setCurrentUserSubscription();
        }

        return Session::get('user_current_plan');
    }

    public function regenerateCurrentUserPermission()
    {

        $this->setCurrentUserSubscription();

        return Session::get('user_current_plan');
    }

    public function validateSubscriptionUserPermission($key, $getTotalNumberOfCreated, $currentPlan)
    {
        if ($currentPlan->pricing_plan->key != 'noob') {
            // if inactive, then thrown an error
            if ($currentPlan->end_date < Carbon::now()) {
                Log::info("Your maximum subscription limit is reached.Please upgrade your plan : " . Auth()->user()->id);
                return true;
            }
        }
        // Validate the permissions that are in the plan
        if ($currentPlan->is_year) {
            $planCount = 12;
        } else {
            $planCount = 1;
        }
        $permission = Permission::where("key", $key)->first();
        $currentPermission = $currentPlan->subscription_permissions->where('permission_id', $permission->id)->first();
        $currentPermissionValue = (int) $currentPermission->value * $planCount;
        if (!$currentPermission->is_unlimited && $getTotalNumberOfCreated >= $currentPermissionValue) {
            Log::info("Your maximum subscription limit is reached. Please upgrade your plan : ". Auth()->user()->id);
            return true;
        }
        return false;
    }
}
