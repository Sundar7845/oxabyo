<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $group_members = [];

        foreach ($request->users as $user) {
            $group_members[] = [
                'group_id' => $request->group_id,
                'user_id' => $user,
                'created_at' => now(),
                'updated_at' => now()
            ];
       }
       
       GroupMember::insert($group_members);
        
        return redirect()->back()->with('success', 'Group members added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function show(GroupMember $groupMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupMember $groupMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupMember  $groupMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupMember $groupMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groupMember = GroupMember::find($id);
        $groupMember->delete();
        return redirect()->back()->with('success', 'Group member removed successfully');
    }

    /**
     * Hide the specific Group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideGroup($id)
    {
        $group = GroupMember::find($id);
        $group->status = 0;
        $group->save();
        return redirect()->back()->with('success', 'Group member deactivated successfully');
    }

    /**
     * Unhide the specific Group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {
        $group = GroupMember::find($id);
        $group->status = 1;
        $group->save();
        return redirect()->back()->with('success', 'Group member activated successfully');
    }
}
