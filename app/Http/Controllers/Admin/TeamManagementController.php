<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Team;
use App\User;
use App\Game;
use App\TeamMember;
use App\TeamGame;
use App\TeamMemberAction;

/* Services */
use App\Services\FileService;
use App\Services\TeamService;

class TeamManagementController extends Controller
{

    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $teams = Team::with(['users', 'games'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.team-management.index', compact('teams', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('user_role_id', '!=', 1)->orderBy('users.name', 'ASC')->get();
        $games = Game::orderBy('games.name', 'ASC')->get();

        return view('admin.team-management.create', compact('users', 'games'));
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

        $team = Team::create($input);

        TeamGame::create([
            'team_id'   => $team->id,
            'game_id'   => $request->game_id
        ]);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $team->id . '.' . $ext;

            $team->team_image = "oxabyo/teams/".$team->id."/".$filename;
            $team->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/teams/".$team->id
            );
        }

        return redirect()->route('team-management.members', $team->id)
            ->with('success', 'Team created successfully');

        // return redirect()->route('team-management.index')
        //     ->with('success', 'Team created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::with(['users', 'games'])
            ->find($id);

        $users = User::where('user_role_id', '!=', 1)->orderBy('users.name', 'ASC')->get();
        $games = Game::orderBy('games.name', 'ASC')->get();

        return view('admin.team-management.edit', compact('team', 'users', 'games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = Team::find($id);
        $team->fill($request->all());
        $team->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $team->id . '.' . $ext;

            $team->team_image = "oxabyo/teams/".$team->id."/".$filename;
            $team->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/teams/".$team->id
            );
        }

        TeamGame::updateOrCreate([
            'team_id'   => $team->id,
            'game_id'   => $request->game_id
        ]);
        
        return redirect()->route('team-management.index')
            ->with('success', 'Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teamMembers = TeamMember::where('team_id', $id)->get();
        foreach($teamMembers as $teamMember) {
            TeamMemberAction::where('team_member_id', $teamMember->id)->delete();
        }
        TeamMember::where('team_id', $id)->delete();
        TeamGame::where('team_id', $id)->delete();
        $team = Team::find($id);
        $team->delete();
        return redirect()->back()->with('success', 'Team deleted successfully');
    }

    /**
     * Hide the specific Team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideTeam($id)
    {
        $team = Team::find($id);
        $team->status = 0;
        $team->save();
        return redirect()->back()->with('success', 'Team hidden successfully');
    }

    /**
     * Unhide the specific Team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTeam($id)
    {
        $team = Team::find($id);
        $team->status = 1;
        $team->save();
        return redirect()->back()->with('success', 'Team unhide successfully');
    }

    /**
     * Add members to the team
     */
    public function members(Request $request, $id)
    {
        $search = trim($request->input('search'));
        
        $team = Team::find($id);

        $members = TeamMember::with(['users' => function ($query) use ($search) {
            $query->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')->select('id', 'name');
                });
            }, 'teams'])
            ->where('team_id', $id)
            ->paginate(10)
            ->appends(request()->query());

        $users = User::select('users.id', 'users.name')   
            ->whereNotIn('id',function($query) use ($id) {
                $query->select('user_id')->from('team_members')->where('team_members.team_id', $id);
            })
            ->where('user_role_id', '!=', 1)
            ->distinct('users.id')
            ->orderBy('users.name', 'ASC')
            ->get();
  

        return view('admin.team-management.add-members', compact('users', 'search', 'members', 'id', 'team'));
    }
}
