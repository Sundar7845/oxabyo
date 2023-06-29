<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use Mail;

/*Models */
use App\User;
use App\Game;
use App\Team;
use App\TeamMember;
use App\TeamGame;
use App\TeamInvite;
use App\TeamMemberAction;
use App\TeamAction;
use App\TeamJoinee;
use App\Notification;
use App\EventChampion;
use App\Permission;

/* Services */
use App\Services\TeamService;
use App\Services\FileService;
use App\Services\AlgoService;
use App\Traits\SubscriptionTrait;

class TeamController extends Controller
{
    use SubscriptionTrait;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var TeamService
     */
    private $teamService;

    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        FileService $fileService,
        TeamService $teamService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
        $this->teamService = $teamService;
        $this->algoService = $algoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();


        $myFriends = User::join('user_friends','user_friends.friend_id','users.id')
            ->where('user_friends.is_connected',1)
            ->where('user_id', $user->id)
            ->pluck('user_friends.friend_id')->toArray();
   

        $search = trim($request->input('search'));
        $memberCount = $request->membercount;
        $teams = Team::with(['users', 'games', 'members']);
        if ($search) {
            $teams = $teams->where('name', 'LIKE', "%$search%");
        }

        if ($request->input('team_created_by') && $request->input('team_joined_by')) {
            $teams = $teams->where('admin_user_id', $user->id)->orWhereHas('members', function ($query) use ($user) {
                $query->where('team_members.user_id', $user->id);
            });

        } else if ($request->input('team_created_by')) {
            $teams = $teams->where('admin_user_id', $user->id);
        } else if ($request->input('team_joined_by')) {
            $teams = $teams->whereHas('members', function ($query) use ($user) {
                $query->where('team_members.user_id', $user->id);
            });
        }

        if ($request->input('team_created_by_friends') && $request->input('team_joined_by_friends')) {

            $teams = $teams->whereIn('admin_user_id', $myFriends)
            ->orWhereHas('members', function ($query) use ($myFriends) {
                $query->whereIn('team_members.user_id', $myFriends);
            });

        } else if ($request->input('team_created_by_friends')) {
            $teams = $teams->whereIn('admin_user_id', $myFriends);
        } else if ($request->input('team_joined_by_friends')) {
            $teams = $teams->whereHas('members', function ($query) use ($myFriends) {
                $query->whereIn('team_members.user_id', $myFriends);
            });
        }

     
        if ($memberCount) {
            $teams = $teams->withCount('members')->has('members', $memberCount);
        }
        $teams = $teams->paginate(4)
            ->appends(request()->query());

        foreach ($teams as $team) {
            if ($team->team_image) {

                $team->team_image = $this->fileService->fetchS3File($team->team_image);
            }
        }

        if ($request->ajaxCall) {
            return view('teams.list', compact('teams', 'search'))->render();
        }
        return view('teams.index', compact('teams', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::leftjoin('user_friends', 'user_friends.friend_id', 'users.id')
            ->where(function ($query) {
                $query->where('user_friends.user_id',   Auth()->user()->id)
                ->where('user_role_id', '!=', 1)
                ->where('user_friends.is_connected',1)
                ->where('user_friends.is_blocked',0);
            })
            ->orWhere('users.id', Auth()->user()->id) 
            ->select('users.*')
            ->orderBy('users.name', 'ASC')
            ->get();

        $games = Game::orderBy('games.name', 'ASC')->get();

        $team = new Team();

        // this validate user permissions
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
        $getTotalNumberOfCreated = Team::where('admin_user_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();
        $subscriptionStatus = $this->validateSubscriptionUserPermission("team_create", $getTotalNumberOfCreated, $currentPlan);
        
        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }

        return view('teams.create', compact('users', 'games',  'team'));
    }
           
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['admin_user_id'] = Auth::user()->id;
        $team = $this->teamService->create($data);

        // Store Team Games
        if ($data['game_ids']) {
            $team_games = [];
            foreach ($data['game_ids'] as $game) {
                $team_games[] = [
                    'game_id' => $game,
                    'team_id' => $team->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            TeamGame::insert($team_games);
        }

        $data = [];
        $data['team_name'] = $team->name;

        Notification::updateOrCreate([
            'sender_user_id'=>Auth()->user()->id,
            'receiver_user_id'=>Auth()->user()->id,
            'title'=>'Team Creation',
            'message'=>"You created the Team " . $data['team_name'],
            'is_read'=>0
        ]); 
        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $team->id . '.' . $ext;

            $team->team_image = "oxabyo/teams/" . $team->id . "/" . $filename;
            $team->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/teams/" . $team->id
            );
        }

        $team_members = [];
        foreach ($request->teamUsers as $user) {
            $team_members[] = [
                'team_id' => $team->id,
                'user_id' => $user,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $team_members ? TeamMember::insert($team_members) : '';

        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::with(['users', 'games'])
            ->find($id);

        if ($team->team_image) {
            $team->team_image = $this->fileService->fetchS3File($team->team_image);
        }

        $members = TeamMember::with(['users', 'teams', 'users.friends'])
            ->where('team_id', $id)
            ->get();

        $games = TeamGame::with(['games'])->where('team_id', $id)
            ->get();

        // Fetch heighest score from the user
        $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
        $socialScore = $this->algoService->fetchHeighestSocialScore();
        $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        

        foreach ($members as $member) {
            if ($member->users->profile_image) {
                $member->users->profile_image = $this->fileService->fetchS3File($member->users->profile_image);
            }
            $member->wins = EventChampion::where('winner_id', $member->users->id)->count();
            $member->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $member->users->id);
            $member->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $member->users->id);
            $member->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $member->users->id);
            $member->oxarate = ceil(($member->performance + $member->social + $member->monetization) / 3);
        }

        $isContactAdminVisible = false;
        $isEditButtonVisible = false;
        $isJoinButtonVisible = false;
        if ($team->admin_user_id != auth()->user()->id) {
            $isContactAdminVisible = true;
        }
        $isMember = TeamMember::where('user_id', Auth()->user()->id)
            ->where('team_id', $id)
            ->first();
        if ($team->admin_user_id != auth()->user()->id && !$isMember) {
            $isJoinButtonVisible = true;
        }
        if ($team->admin_user_id == auth()->user()->id || ($isMember && $isMember->is_admin)) {
            $isEditButtonVisible = true;
        }

        return view('teams.show', compact(
            'team',
            'members',
            'games',
            'isContactAdminVisible',
            'isEditButtonVisible',
            'isJoinButtonVisible'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $team = $this->teamService->findWithUsers($id);
        $team = Team::with(['users', 'games'])
            ->find($id);

        // Permission for edit option
        $isMember = TeamMember::where('user_id', Auth()->user()->id)
            ->where('team_id', $id)
            ->first();
        if ($team  && ($team->admin_user_id == auth()->user()->id || ($isMember && $isMember->is_admin))) {
            if ($team->team_image) {
                $team->team_image = $this->fileService->fetchS3File($team->team_image);
            }

            $members = TeamMember::with(['users', 'teams'])
            ->where('team_id', $id)
            ->get();

            $users = User::join('user_friends', 'user_friends.friend_id', 'users.id')
            //->leftjoin('team_members', 'team_members.user_id', 'users.id')
            ->where('users.id', '!=', Auth()->user()->id)
            ->where('user_friends.user_id',   Auth()->user()->id)
                ->where('user_role_id', '!=', 1)
                ->where('user_friends.is_connected', 1)
                ->where('user_friends.is_blocked', 0)
                ->whereNotIn('users.id', function ($query) use ($team) {
                    $query->select('user_id')
                    ->from('team_members')
                    ->where('team_id', $team->id);
                })
                ->select('users.*')
                ->orderBy('users.name', 'ASC')
                ->get();

            $games = Game::orderBy('games.name', 'ASC')->get();
            
                
            // Fetch heighest score from the user
            $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
            $socialScore = $this->algoService->fetchHeighestSocialScore();
            $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

            foreach ($members as $member) {
                if ($member->users->profile_image) {
                    $member->users->profile_image = $this->fileService->fetchS3File($member->users->profile_image);
                }

                $member->wins = EventChampion::where('winner_id', $member->users->id)->count();
                $member->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $member->users->id);
                $member->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $member->users->id);
                $member->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $member->users->id);
            $member->oxarate = ceil(($member->performance + $member->social + $member->monetization) / 3);
            }

            $teamGames = TeamGame::where('team_id', $team->id)->get();

            return view('teams.edit', compact('team', 'members', 'users', 'games', 'teamGames'));
        }

        return redirect()->back()->with('error', 'Unautherized access to this page');
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

            $team->team_image = "oxabyo/teams/" . $team->id . "/" . $filename;
            $team->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/teams/" . $team->id
            );
        }

        // Store Team Games
        $data = $request->all();
        if ($data['game_ids']) {
            $team_games = [];
            foreach ($data['game_ids'] as $game) {
                $teamGame = TeamGame::where('team_id', $team->id)
                    ->where('game_id', $game)
                    ->first();
                if (!$teamGame) {
                    $team_games[] = [
                        'game_id' => $game,
                        'team_id' => $team->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            TeamGame::insert($team_games);
            TeamGame::where('team_id', $team->id)
                ->whereNotIn('game_id', $data['game_ids'])
                ->delete();
        }

        return redirect()->route('teams.index')->with('success', 'Team updated successfully');
        //return redirect()->back()->with('success', 'Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function assignTeamAsAdmin(int $id)
    {
        $this->teamService->assignTeamAsAdmin($id);

        $teamAction = TeamAction::where('key', 'make-admin')->first();

        TeamMemberAction::create([
            'team_member_id' => $id,
            'team_action_id' => $teamAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);

        // return redirect()->back()->with('success', 'Team admin added successfully');
    }

    /**
     * Remove a Team member from Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function removeAdminFromTeamMember(int $id)
    {
        $this->teamService->removeAdminFromTeamMember($id);

        $teamAction = TeamAction::where('key', 'remove-admin')->first();

        TeamMemberAction::create([
            'team_member_id' => $id,
            'team_action_id' => $teamAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);

        return json_encode([
            'success' => true
        ]);

        // return redirect()->back()->with('success', 'Team admin removed successfully');
    }

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function banTeamMember(int $id)
    {
        $this->teamService->banTeamMember($id);

        $teamAction = TeamAction::where('key', 'ban')->first();

        TeamMemberAction::create([
            'team_member_id' => $id,
            'team_action_id' => $teamAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);

        // return redirect()->back()->with('success', 'Team member banned successfully');
    }

    /**
     * Remove a Team member from Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function unbanTeamMember(int $id)
    {
        $this->teamService->unbanTeamMember($id);

        $teamAction = TeamAction::where('key', 'unban')->first();

        TeamMemberAction::create([
            'team_member_id' => $id,
            'team_action_id' => $teamAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);

        // return redirect()->back()->with('success', 'Team member unbanned successfully');
    }

    /**
     * 
     */
    public function inviteUsers(Request $request, $id)
    {
        $data = $request->all();
        $team = Team::find($id);
        $data['admin_user_id'] = Auth::user()->id;
        $users = User::whereIn('id', $data['inviteUsers'])->get();

        Log::info($data['inviteUsers']);
        Log::info($users);

        foreach ($users as $user) {
            // Store the invited user into the database
            $teamInvite = TeamInvite::updateOrCreate([
                'invitee_id' =>  $user->id,
                'invite_sent_by' => Auth()->user()->id,
                'team_id' => $team->id,
                'is_invite_sent' => 1,
                'invite_sent_date' => now()
            ]);
            $teamInvite->token = hash('sha256', Str::random(100));
            $teamInvite->save();

            $data = [];
            $data['team_name'] = $team->name;
            $data['user_name'] = Auth::user()->name;
            $data['link'] = $teamInvite->token;
            $email = $user->email;

            $notification=Notification::create([
                'sender_user_id' =>Auth()->user()->id,
                'receiver_user_id'=> $user->id,
                'title'  => "Team Invite",
                'message' => $data['user_name'] . " invited you to join the Team " . $data['team_name'],
                'accept_href' => url(route('team-activation', ['token' => $data['link']])),
                'decline_href' => url(route('team-activation-decline', ['token' => $data['link']])),
                'is_read' => 0
            ]);
    
            $teamInvite->notification_id=  $notification->id;
	    $teamInvite->save();
            
            try {
                Mail::send('emails.invite-team', ['data' => $data], function ($message) use ($email) {
                    $message->to($email);
                    $message->sender(env('MAIL_FROM_ADDRESS'));
                    $message->subject('Team Invite');
                });
            } catch (\Exception $e) {

                Log::info($e);
            }
        }

        return redirect()->back()->with('success', 'Team players invited successfully');
    }

    /**
     * 
     */
    public function teamActivation(Request $request)
    {
        $teamInvite = TeamInvite::where('token', $request->token)
            ->first();
        if ($teamInvite) {
            $teamInvite->invite_accept_date = now();
            $teamInvite->is_invite_accept = 1;
            $teamInvite->token = null;
            $teamInvite->save();

            TeamMember::updateOrCreate([
                'team_id' => $teamInvite->team_id,
                'user_id' => $teamInvite->invitee_id,
                'team_invite_id' => $teamInvite->id
            ]);
            if($teamInvite->notification_id) {
                Notification::where('id',  $teamInvite ->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('teams.show', $teamInvite->team_id)->with('success', 'You have successfully joined to the team');
        }
       
        return redirect()->route('dashboard')->with('success', 'Team players joined successfully');
    }

    /**
     * Team Decline
     */
    public function teamDeclineActivation(Request $request)
    {
        $teamInvite = TeamInvite::where('token', $request->token)
            ->first();
        if ($teamInvite) {
            $teamInvite->invite_reject_date = now();
            $teamInvite->is_invite_accept = 0;
            $teamInvite->token = null;
            $teamInvite->save();
	    
	    if($teamInvite->notification_id) {
                Notification::where('id',  $teamInvite ->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Team players decline successfully');

        //return view('home')->with('success', 'Team players decline successfully');
    }

    /**
     * Join Team
     */
    public function joinTeam(Request $request, $id)
    {

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

        $subscriptionStatus = $this->validateSubscriptionUserPermission("team_join", $getTotalNumberOfTeamJoined, $currentPlan);

        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }
        $team = Team::find($id);

        $user = User::where('id', $team->admin_user_id)->first();

        // Store the invited user into the database
        $teamJoinee = TeamJoinee::updateOrCreate([
            'joinee_id' => Auth()->user()->id,
            'approved_by_id' =>  $user->id,
            'team_id' => $team->id,
            'request_sent_date' => now()
        ]);
        $teamJoinee->token = hash('sha256', Str::random(100));
        $teamJoinee->save();

        $data = [];
        $data['team_name'] = $team->name;
        $data['user_name'] = Auth::user()->name;
        $data['link'] = $teamJoinee->token;
        $email = $user->email;

        $notification= Notification::create([
            'sender_user_id' =>Auth()->user()->id,
            'receiver_user_id'=> $user->id,
            'title'  => "Team Join",
            'message' => $data['user_name']. "joinning request to Team ".$data['team_name'] ,
            'accept_href' => url(route('team-join-accept', ['token' => $data['link']])),
            'decline_href' => url(route('team-join-decline', ['token' => $data['link']])),
            'is_read' => 0
        ]);

        $teamJoinee->notification_id= $notification->id;
	$teamJoinee->save();
	
        try {
            Mail::send('emails.join-team', ['data' => $data], function ($message) use ($email) {
                $message->to($email);
                $message->sender(env('MAIL_FROM_ADDRESS'));
                $message->subject('Team Join');
            });
        } catch (\Exception $e) {
            Log::info($e);
        }
        return redirect()->back()->with('success', 'Team join request sent successfully');
    }

    /**
     * 
     */
    public function acceptJoin(Request $request)
    {
        $teamJoinee = TeamJoinee::where('token', $request->token)
            ->where('approved_by_id', auth()->user()->id)
            ->first();
        if ($teamJoinee) {
            $teamJoinee->request_approved_date = now();
            $teamJoinee->token = null;
            $teamJoinee->save();

            TeamMember::updateOrCreate([
                'team_id' => $teamJoinee->team_id,
                'user_id' => $teamJoinee->joinee_id,
                'team_joinee_id' => $teamJoinee->id
            ]);

            if($teamJoinee->notification_id){

                Notification::where('id', $teamJoinee->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }
            return redirect()->route('dashboard')->with('success', 'Team players joined successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');
        
        // return view('home')->with('success', 'Team players joined successfully');
    }

    /**
     * Team Decline
     */
    public function declineJoin(Request $request)
    {
        $teamJoinee = TeamJoinee::where('token', $request->token)
            ->where('approved_by_id', auth()->user()->id)
            ->first();
        if ($teamJoinee) {
            $teamJoinee->token = null;
            $teamJoinee->status = 0;
            $teamJoinee->save();
	    
	    if($teamJoinee->notification_id) {
                Notification::where('id',  $teamJoinee->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Team player request declined successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');

        
       // return view('home')->with('success', 'Team players decline successfully');
    }
}
