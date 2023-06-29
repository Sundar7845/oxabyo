<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\SubscriptionPermissions;


class SubscriptionPermission extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = trim($request->input('search'));

        $plans = SubscriptionPermissions::paginate(10);

        return view('admin.subscription.index', compact('plans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscription.create');
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
        SubscriptionPermissions::create($input);

        return redirect()->route('admin.subscription.index')
            ->with('success', 'PricingPlans created successfully');
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
        $plan = SubscriptionPermissions::find($id);
        return view('admin.subscription.edit', compact('plans'));
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

        $plan = SubscriptionPermissions::find($id);
        $plan->fill($request->all());
        $plan->save();
        return redirect()->route('admin.subscription.index')
            ->with('success', 'plans updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = SubscriptionPermissions::find($id);
        $plan->delete();
        return redirect()->route('admin.subscription.index')
            ->with('success', 'PricingPlans deleted successfully');
    }
}