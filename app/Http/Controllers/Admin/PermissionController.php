<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\PricingPlan;
use App\SubscriptionPermission;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $subscriptionPermissions = SubscriptionPermission::join(
        //     'permissions', 
        //     'permissions.id', 
        //     'subscription_permissions.permission_id'
        // )->join('pricing_plans', 'pricing_plans.id', 'subscription_permissions.pricing_plan_id')
        // ->get();

        $subscriptionPermissionsForNoob = SubscriptionPermission::where('pricing_plan_id', 1)->get()->keyBy('permission_id');
        $subscriptionPermissionsForGeek = SubscriptionPermission::where('pricing_plan_id', 2)->get()->keyBy('permission_id');
        $subscriptionPermissionsForPro = SubscriptionPermission::where('pricing_plan_id', 3)->get()->keyBy('permission_id');

        $plans = PricingPlan::get();

        $permissions = Permission::get();

        return view('admin.permission.index', compact('plans', 'subscriptionPermissionsForNoob', 'permissions',
            'subscriptionPermissionsForGeek', 'subscriptionPermissionsForPro'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Permission::create($input);

        return redirect()->route('admin.permission.index')
            ->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $permission = Permission::find($id);
        $permission->fill($request->all());
        $permission->save();
        return redirect()->route('admin.permission.index')
            ->with('success', 'plans updated successfully');
    }


    public function destroy()
    {
    }
}