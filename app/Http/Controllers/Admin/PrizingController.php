<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PricingPlan;


class PrizingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = trim($request->input('search'));

        $plans = PricingPlan::paginate(10);

        return view('admin.setup-prizing.index', compact('plans', 'search'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = PricingPlan::find($id);
        return view('admin.setup-prizing.edit', compact('plan'));
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

        $plan = PricingPlan::find($id);
        $plan->fill($request->all());
        $plan->save();
        return redirect()->route('admin.setup-prizing.index')
            ->with('success', 'plans updated successfully');
    }
}
