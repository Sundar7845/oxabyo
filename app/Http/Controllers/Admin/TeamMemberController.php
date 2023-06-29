<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
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

        $team_members = [];

        foreach ($request->users as $user) {
            $team_members[] = [
                'team_id' => $request->team_id,
                'user_id' => $user,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        TeamMember::insert($team_members);

        return redirect()->back()->with('success', 'Team members added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function show(TeamMember $teamMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamMember $teamMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamMember $teamMember)
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
        $team = TeamMember::find($id);
        $team->delete();
        return redirect()->back()->with('success', 'Team member removed successfully');
    }

    /**
     * Hide the specific team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideTeam($id)
    {
        $team = TeamMember::find($id);
        $team->status = 0;
        $team->save();
        return redirect()->back()->with('success', 'Team member deactivated successfully');
    }

    /**
     * Unhide the specific team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTeam($id)
    {
        $team = TeamMember::find($id);
        $team->status = 1;
        $team->save();
        return redirect()->back()->with('success', 'Team member activated successfully');
    }

    /**
     * Hide the specific team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addTeamAdmin($id)
    {
        $team = TeamMember::find($id);
        $team->is_admin = 1;
        $team->save();
        return redirect()->back()->with('success', 'Team admin added successfully');
    }

    /**
     * Unhide the specific team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeTeamAdmin($id)
    {
        $team = TeamMember::find($id);
        $team->is_admin = 0;
        $team->save();
        return redirect()->back()->with('success', 'Team admin removed successfully');
    }
}
