<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Group;
use App\User;
use App\Game;
use App\GroupMember;

/* Services */
use App\Services\FileService;

class GroupManagementController extends Controller
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
        $groups = Group::with(['users', 'games'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.group-management.index', compact('groups', 'search'));
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

        return view('admin.group-management.create', compact('users', 'games'));
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

        $group = Group::create($input);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $group->id . '.' . $ext;

            $group->group_image = "oxabyo/groups/".$group->id."/" . $filename;
            $group->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/groups/".$group->id
            );
        }
        return redirect()->route('group-management.members', $group->id)
            ->with('success', 'Group created successfully');

        // return redirect()->route('group-management.index')
        //     ->with('success', 'Group created successfully');
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
        $group = Group::with(['users', 'games'])
            ->find($id);

        $users = User::where('user_role_id', '!=', 1)->orderBy('users.name', 'ASC')->get();
        $games = Game::orderBy('games.name', 'ASC')->get();

        return view('admin.group-management.edit', compact('group', 'users', 'games'));
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
        $group = Group::find($id);
        $group->fill($request->all());
        $group->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $group->id . '.' . $ext;

            $group->group_image = "oxabyo/groups/".$group->id. "/" . $filename;
            $group->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/groups/".$group->id
            );
        }

        return redirect()->route('group-management.index')
            ->with('success', 'Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GroupMember::where('group_id', $id)->delete();
        $group = Group::find($id);
        $group->delete();
        return redirect()->back()->with('success', 'Group deleted successfully');
    }

    /**
     * Hide the specific Group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideGroup($id)
    {
        $group = Group::find($id);
        $group->status = 0;
        $group->save();
        return redirect()->back()->with('success', 'Group hidden successfully');
    }

    /**
     * Unhide the specific Group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {
        $group = Group::find($id);
        $group->status = 1;
        $group->save();
        return redirect()->back()->with('success', 'Group unhide successfully');
    }

    /**
     * Add members to the group
     */
    public function members(Request $request, $id)
    {
        $search = trim($request->input('search'));

        $group = Group::find($id);

        $members = GroupMember::with(['users' => function ($query) use ($search) {
            $query->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')->select('id', 'name');
                });
            }, 'groups'])
            ->where('group_id', $id)
            ->paginate(10)
            ->appends(request()->query());

        $users = User::select('users.id', 'users.name')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('user_id')->from('group_members')->where('group_members.group_id', $id);
            })
            ->where('user_role_id', '!=', 1)
            ->where('users.id', '!=', $group->group_admin_id)
            ->distinct('users.id')
            ->orderBy('users.name', 'ASC')
            ->get();


        return view('admin.group-management.add-members', compact('users', 'search', 'members', 'id', 'group'));
    }
}
