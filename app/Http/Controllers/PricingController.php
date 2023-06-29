<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\PricingPlan;
use App\SubscriptionPermission;

class PricingController extends Controller
{
    public function pricing(Request $request)
    {

        $subscriptionPermissionsForNoob = SubscriptionPermission::where('pricing_plan_id', 1)->get()->keyBy('permission_id');
        $subscriptionPermissionsForGeek = SubscriptionPermission::where('pricing_plan_id', 2)->get()->keyBy('permission_id');
        $subscriptionPermissionsForPro = SubscriptionPermission::where('pricing_plan_id', 3)->get()->keyBy('permission_id');

        $plans = PricingPlan::get();

        $permissions = Permission::get();


        

        return view('pricing.g_pricing',compact('plans','permissions','subscriptionPermissionsForNoob','subscriptionPermissionsForGeek','subscriptionPermissionsForPro'));
    }
}
