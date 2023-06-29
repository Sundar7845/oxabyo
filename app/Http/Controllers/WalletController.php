<?php

namespace App\Http\Controllers;

use App\EventJoinee;
use App\Group;
use App\GroupJoin;
use App\Team;
use App\TeamJoinee;
use Illuminate\Http\Request;
use App\UserSubscriptionPlan;
use Carbon\Carbon;
use App\Traits\SubscriptionTrait;


class WalletController extends Controller
{
    use SubscriptionTrait;
    public function wallet(Request $request)
    {
        $userId = auth()->id();



        $subscriptionPlans = UserSubscriptionPlan::join(
            'pricing_plans',
            'pricing_plans.id',
            'user_subscription_plans.pricing_plan_id')
        ->join('subscription_permissions', 'subscription_permissions.pricing_plan_id', 'pricing_plans.id')
        ->join('permissions', 'permissions.id', 'subscription_permissions.permission_id')
            ->where('user_id', $userId)
            ->get()->keyBy('key');
          
            $currentPlan = $this->getCurrentUserPermission();
            $now = Carbon::now();
            $now2 = Carbon::now();
            if ($currentPlan->pricing_plan->key != 'noob') {
                $startOfMonth = $currentPlan->start_date;
                $endOfMonth = $currentPlan->end_date;
            } else {
                $startOfMonth = $now->startOfMonth('Y-m-d');
                $endOfMonth = $now2->endOfMonth()->format('Y-m-d');
            }
            $getTotalNumberOfTeamJoined = TeamJoinee::where('joinee_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();

            $getTotalNumberOfTeamCreated = Team::where('admin_user_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();
       
            $getTotalNumberOfEventJoined = EventJoinee::where('event_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();

            $getTotalNumberOfGroupJoined = GroupJoin::where('join_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();

            $getTotalNumberOfGroupCreated = Group::where('group_admin_id',Auth()->user()->id)
            ->wherebetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();
        //    dd( $subscriptionPlans,$getTotalNumberOfTeamJoined,$getTotalNumberOfTeamCreated,$getTotalNumberOfEventJoined,
        //    $getTotalNumberOfGroupJoined,$getTotalNumberOfGroupCreated,$currentPlan);

        return view('wallet.wallet', compact('subscriptionPlans','getTotalNumberOfTeamJoined','getTotalNumberOfTeamCreated','getTotalNumberOfEventJoined',
        'getTotalNumberOfGroupJoined', 'getTotalNumberOfGroupCreated'));
    }
}
