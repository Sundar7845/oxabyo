<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Auth;
use Mail;
use Carbon\Carbon;

use App\User;
use App\Game;
use App\Group;
use App\GroupGame;
use App\GroupMember;
use App\GroupInvite;
use App\GroupJoin;
use App\GroupActions;
use App\GroupMemberActions;
use App\Message;
use App\MessageRecipient;
use App\Notification;
use App\EventChampion;
use App\Services\FileService;
use App\Services\AlgoService;
use App\Traits\SubscriptionTrait;

class GroupController extends Controller
{
    use SubscriptionTrait;
    
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        FileService $fileService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
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

        $myFriends = User::join('user_friends', 'user_friends.friend_id', 'users.id')
            ->where('user_friends.is_connected', 1)
            ->where('user_id', $user->id)
            ->pluck('user_friends.friend_id')->toArray();

        $search = trim($request->input('search'));

        $memberCount = $request->membercount;

        $groups = Group::with(['users', 'games', 'members']);
        if ($search) {
            $groups = $groups->where('name', 'LIKE', "%$search%");
        }

        if ($request->input('group_created_by') && $request->input('group_joined_by')) {
            $groups = $groups->where('group_admin_id', $user->id)->orWhereHas('members', function ($query) use ($user) {
                $query->where('group_members.user_id', $user->id);
            });
        } else if ($request->input('group_created_by')) {
            $groups = $groups->where('group_admin_id', $user->id);
        } else if ($request->input('group_joined_by')) {
            $groups = $groups->whereHas('members', function ($query) use ($user) {
                $query->where('group_members.user_id', $user->id);
            });
        }

        if ($request->input('group_created_by_friends') && $request->input('group_joined_by_friends')) {

            $groups = $groups->whereIn('group_admin_id', $myFriends)
                ->orWhereHas('members', function ($query) use ($myFriends) {
                    $query->whereIn('group_members.user_id', $myFriends);
                });
        } else if ($request->input('group_created_by_friends')) {
            $groups = $groups->whereIn('group_admin_id', $myFriends);
        } else if ($request->input('group_joined_by_friends')) {
            $groups = $groups->whereHas('members', function ($query) use ($myFriends) {
                $query->whereIn('group_members.user_id', $myFriends);
            });
        }
        // $groups = Group::with(['users', 'games', 'group_members_count'])->get();

        if ($memberCount) {
            $groups = $groups->withCount('members')->has('members', $memberCount);
        }

        $groups = $groups->get();
        foreach ($groups as $group) {
            if ($group->group_image) {
                $group->group_image = $this->fileService->fetchS3File($group->group_image);
            }
        }

        if ($request->ajaxCall) {
            return view('includes.group_table', compact('groups', 'search'))->render();
        }

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $games = Game::get();

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

        $getTotalNumberOfGroupCreated = Group::where('group_admin_id',Auth()->user()->id)
            ->wherebetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();
        $subscriptionStatus = $this->validateSubscriptionUserPermission(
            "group_create", 
            $getTotalNumberOfGroupCreated,
            $currentPlan
        );

        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }

        return view('groups.create',  compact('games', 'users'));
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
        $data['group_admin_id'] = Auth::user()->id;
        $group = Group::create($data);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $group->id . '.' . $ext;

            $group->group_image = "oxabyo/group/" . $group->id . "/" . $filename;
            $group->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/group/" . $group->id
            );
        }

        $group_members = [];
        $group_members[] = [
            'group_id' => $group->id,
            'user_id' =>  auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now()
        ];
        Notification::create([
            'sender_user_id'=>Auth()->user()->id,
            'receiver_user_id'=>Auth()->user()->id,
            'title'=>'Group Creation',
            'message'=>"You created the Group " . $group->name,
            'is_read'=>0
        ]); 
        
        foreach ($request->groupUsers as $user) {
            $group_members[] = [
                'group_id' => $group->id,
                'user_id' => $user,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $group_members ? GroupMember::insert($group_members) : '';

        return redirect()->route('groups.index');
    }

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

            $group->group_image = "oxabyo/groups/" . $group->id . "/" . $filename;
            $group->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/groups/" . $group->id

            );
        }



        return redirect()->route('groups.index')->with('success', 'Group updated successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $group = Group::find($id);

        if ($group->group_image) {
            $group->group_image = $this->fileService->fetchS3File($group->group_image);
        }

        $members = GroupMember::with(['users', 'groups'])
            ->where('group_id', $id)
            ->get();

        $groupMemberArray = [];

                
            // Fetch heighest score from the user
            $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
            $socialScore = $this->algoService->fetchHeighestSocialScore();
            $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();
 
        foreach ($members as $member) {
            if ($member->users->profile_image) {
                $member->users->profile_image = $this->fileService->fetchS3File($member->users->profile_image);
            }
            $groupMemberArray[] = $member->users->id;

            $member->wins = EventChampion::where('winner_id', $member->users->id)->count();
            $member->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $member->users->id);
            $member->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $member->users->id);
            $member->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $member->users->id);
        $member->oxarate = ceil(($member->performance + $member->social + $member->monetization) / 3);
        }
	
	$messages = Message::join(
            'message_recipients',
            'message_recipients.message_id',
            'messages.id'
        )->join('users', 'users.id', 'messages.created_by_id')
            ->where('group_id', $id)

            ->orderBy('message_recipients.created_at', 'ASC')
            ->get();

        foreach ($messages as $message) {
            if ($message->group_image) {
                $message->group_image = $this->fileService->fetchS3File($message->group_image);
            }
        }

        $isContactAdminVisible = false;
        $isEditButtonVisible = false;
        $isJoinButtonVisible = false;
        if ($group->group_admin_id != auth()->user()->id) {
            $isContactAdminVisible = true;
        }
        $isMember = GroupMember::where('user_id', Auth()->user()->id)
            ->where('group_id', $id)
            ->first();
        if ($group->group_admin_id != auth()->user()->id && !$isMember) {
            $isJoinButtonVisible = true;
        }
        if ($group->group_admin_id == auth()->user()->id || ($isMember && $isMember->is_admin)) {
            $isEditButtonVisible = true;
        }

        $isEnableSendComment = false;

        if (in_array(auth()->user()->id, $groupMemberArray)) {
            $isEnableSendComment = true;
        }

        return view('groups.show', compact(
            'group',
            'members',
            'messages',
            'isContactAdminVisible',
            'isEditButtonVisible',
            'isJoinButtonVisible',
            'isEnableSendComment'

        ));
    }
    
    /**
     * Make a Group member as Admin
     * 
     * @param int   $id           - group.id
     *
     * @return
     */
    public function addAdmin(int $id)
    {
        GroupMember::where('id', $id)->update([
            'is_admin' => 1
        ]);


        $groupActions = GroupActions::where('key', 'add-admin')->first();

        GroupMemberActions::create([
            'group_member_id' => $id,
            'group_action_id' => $groupActions->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);

    }

    /**
     * Remove a Group member from Admin
     * 
     * @param int   $id           - group.id
     *
     * @return
    */
    public function removeAdminFromGroupMember(int $id)
    {

        GroupMember::where('id', $id)->update([
            'is_admin' => 0
        ]);

        $groupActions = GroupActions::where('key', 'remove-admin')->first();

        GroupMemberActions::create([
            'group_member_id' => $id,
            'group_action_id' => $groupActions->id,
            'date' => now(),
            'status' => 1
        ]);
        return json_encode([
            'success' => true
        ]);

    }

    /**
     * Make a group member as Admin
     * 
     * @param int   $id           - group.id
     *
     * @return
     */
    public function banGroupMember(int $id)
    {
        $groupAction = GroupActions::where('key', 'ban')->first();

        GroupMemberActions::create([
            'group_member_id' => $id,
            'group_action_id' => $groupAction->id,
            'date'  => now(),
            'status' => 1
        ]);
        GroupMember::where('id', $id)->update([
            //'is_admin' => 1,
            'status' => 0

        ]);
        return json_encode([
            'success' => true
        ]);

    }

    /**
     * Remove a group member from Admin
     * 
     * @param int   $id           - group.id
     *
     * @return
     */

    public function unbanGroupMember(int $id)
    {
        $groupAction = GroupActions::where('key', 'unban')->first();

        GroupMemberActions::create([
            'group_member_id' => $id,
            'group_action_id' => $groupAction->id,
            'date'  => now(),
            'status' => 1
        ]);
        GroupMember::where('id', $id)->update([
            'status' => 1
        ]);


        return json_encode([
            'success' => true
        ]);
        return redirect()->back()->with('success', 'Group Unban successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $group = Group::with(['games'])
            ->find($id);

        // Permission for edit option
        $isMember = Group::where('group_admin_id', Auth()->user()->id)
            ->where('id', $id)
            ->first();

        // if ($group  && ($group->group_admin_id == auth()->user()->id || ($isMember && $isMember->is_admin))) {
        if ($group->group_image) {
            $group->group_image = $this->fileService->fetchS3File($group->group_image);
        }

        $members = GroupMember::with(['users', 'groups'])
            ->where('group_id', $id)
            ->get();

        // $users = User::leftjoin('user_friends', 'user_friends.friend_id', 'users.id')
        //     ->where(function ($query) {
        //         $query->where('user_friends.user_id',   Auth()->user()->id)
        //         ->where('user_role_id', '!=', 1)
        //         ->where('user_friends.is_connected',1)
        //         ->where('user_friends.is_blocked',0);
        //     })
        //     ->orWhere('users.id', Auth()->user()->id) 
        //     ->select('users.*')
        //     ->orderBy('users.name', 'ASC')
        //     ->get();

        $users = User::join('user_friends', 'user_friends.friend_id', 'users.id')
            ->where('users.id', '!=', Auth()->user()->id)
            ->where('user_friends.user_id',   Auth()->user()->id)
                ->where('user_role_id', '!=', 1)
                ->where('user_friends.is_connected', 1)
                ->where('user_friends.is_blocked', 0)
                ->whereNotIn('users.id', function ($query) use ($group) {
                    $query->select('user_id')
                    ->from('group_members')
                    ->where('group_id', $group->id);
                })
                ->select('users.*')
                ->orderBy('users.name', 'ASC')
                ->get();

        $games = Game::OrderBy('name', 'ASC')->get();

            
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

        $isEditButtonVisible = true;
        return view('groups.edit', compact('group', 'members', 'users', 'games', 'isEditButtonVisible'));
        //  }
        return redirect()->back()->with('error', 'Unautherized access to this page');
    }

    public function invite(Request $request, $id)
    {
        $data = $request->all();
        $group = Group::find($id);
        $data['group_admin_id'] = Auth::user()->id;
        $users = User::whereIn('id', $data['invite'])->get();

        Log::info($data['invite']);
        Log::info($users);

        foreach ($users as $user) {
            // Store the invited user into the database
            $groupInvite = GroupInvite::updateOrCreate([
                'invitee_id' =>  $user->id,
                'invite_sent_by' => Auth()->user()->id,
                'group_id' => $group->id,
                'is_invite_sent' => 1,
                'invite_sent_date' => now()
            ]);
            $groupInvite->token = hash('sha256', Str::random(100));
            $groupInvite->save();

            $data = [];
            $data['group_name'] = $group->name;
            $data['user_name'] = Auth::user()->name;
            $data['link'] = $groupInvite->token;
            $email = $user->email;

            $notification = Notification::create([
                'sender_user_id'   => Auth()->user()->id,
                'receiver_user_id' =>  $user->id,
                'title'            => 'Group Invite',
                'message'          => $data['user_name'] . " invited you to join the Group " . $data['group_name'] ,
                'accept_href'      => url(route('groups-activation', ['token' => $data['link']])),
                'decline_href'     => url(route('groups-activation-decline', ['token' => $data['link']])),
                'is_read'          => 0
            ]);

            $groupInvite->notification_id=  $notification->id;
            $groupInvite->save();
            try {
                Mail::send('emails.invite-group', ['data' => $data], function ($message) use ($email) {
                    $message->to($email);
                    $message->sender(env('MAIL_FROM_ADDRESS'));
                    $message->subject('Group Invite');
                });
            } catch (\Exception $e) {

                Log::info($e);
            }
        }
        return redirect()->back()->with('success', 'group players invited successfully');
    }

    public function groupsActivation(Request $request, $token)
    {
        $groupInvite = GroupInvite::where('token', $token)
            ->first();
        // echo ($token);
        //exit();
        if ($groupInvite) {
            $groupInvite->invite_accept_date = now();
            $groupInvite->is_invite_accept = 1;
            $groupInvite->token = null;
            $groupInvite->save();

            GroupMember::updateOrCreate([
                'group_id' => $groupInvite->group_id,
                'user_id' => $groupInvite->invitee_id,
                // 'group_invite_id' => $groupInvite->id
            ]);
            if($groupInvite->notification_id) {
                Notification::where('id',$groupInvite ->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('groups.show', $groupInvite->group_id)->with('success', 'You have successfully Access to the group');
        }

        return redirect()->route('dashboard')->with('success', 'group players Accept successfully');
    }
    /**
     * Group Decline
     */

    public function groupDeclineActivation(Request $request)
    {

        $groupInvite = GroupInvite::where('token', $request->token)
            ->first();
        if ($groupInvite) {
            $groupInvite->invite_reject_date = now();
            $groupInvite->is_invite_accept = 0;
            $groupInvite->token = null;
            $groupInvite->save();
        }
        return redirect()->route('dashboard')->with('success', 'group players decline successfully');
        return view('home')->with('success', 'Team players decline successfully');
    }


    public function joinGroups(Request $request, $id)
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

        $getTotalNumberOfGroupJoined = GroupJoin::where('join_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();

        $subscriptionStatus = $this->validateSubscriptionUserPermission("group_join", $getTotalNumberOfGroupJoined, $currentPlan);

        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }
            
        $group = Group::find($id);

        $user = User::where('id', $group->group_admin_id)->first();

        // Store the invited user into the database
        $groupJoin = GroupJoin::updateOrCreate([
            'approved_by_id' => $user->id,
            'join_id' => Auth()->user()->id,
            'group_id' => $group->id,
            'request_sent_date' => now()
        ]);
        $groupJoin->token = hash('sha256', Str::random(100));
        $groupJoin->save();

        $data = [];
        $data['group_name'] = $group->name;
        $data['user_name'] = Auth::user()->name;
        $data['link'] = $groupJoin->token;
        $email = $user->email;

        $notification = Notification::create([
            'sender_user_id'   => Auth()->user()->id,
            'receiver_user_id' =>  $user->id,
            'title'            => 'Group Join',
            'message'          => 'Approve '. $data['user_name'] . " joinning request to Group " . $data['group_name'] ,
            'accept_href'      => url(route('groups-join-approve', ['token' => $data['link']])),
            'decline_href'     => url(route('groups-join-decline', ['token' => $data['link']])),
            'is_read'          => 0
        ]);

        $groupJoin->notification_id=  $notification->id;
        $groupJoin->save();
        try {
            Mail::send('emails.Join-group', ['data' => $data], function ($message) use ($email) {
                $message->to($email);
                $message->sender(env('MAIL_FROM_ADDRESS'));
                $message->subject('Group Join');
            });
        } catch (\Exception $e) {
            Log::info($e);
        }
        return redirect()->back()->with('success', 'Group join request sent successfully');
    }

    public function joinAccept(Request $request, $token)
    {
        $groupJoin = GroupJoin::join('groups', 'groups.id', 'groups_join.group_id')
            ->join('users', 'users.id', 'groups_join.join_id')
            ->where('groups_join.token', $token)
            ->where('approved_by_id', auth()->user()->id)
            ->select('groups_join.id', 'users.name as user_name', 'groups.name as group_name',
                'group_id', 'join_id',  'notification_id')
            ->first();
        
        if ($groupJoin) {

            GroupJoin::where('id', $groupJoin->id)
                ->update([
                    'request_approved_date' => now(),
                    'token' => null,
                ]);

            GroupMember::updateOrCreate([
                'group_id' => $groupJoin->group_id,
                'user_id' => $groupJoin->join_id
            ]);
 

            Notification::updateOrCreate([
                'sender_user_id' => Auth()->user()->id,
                'receiver_user_id'=> $groupJoin->join_id,
                'title'  => "Group Join",
                'message' =>  "You joined the group " . $groupJoin->group_name,
                'is_read' => 0
            ]);

            Notification::updateOrCreate([
                'sender_user_id' => Auth()->user()->id,
                'receiver_user_id'=> $groupJoin->join_id,
                'title'  => "Group Join",
                'message' => $groupJoin->user_name . " joined the Group ". $groupJoin->group_name,
                'is_read' => 0
            ]);

            if($groupJoin->notification_id) {
                Notification::where('id', $groupJoin ->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Group players joined successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');

        // return view('home')->with('success', 'group players joined successfully');
    }


    /**
     * Group Decline
     */

    public function joinDecline(Request $request)
    {
        $groupjoin = GroupJoin::where('token', $request->token)
            ->where('approved_by_id', auth()->user()->id)
            ->first();
        if ($groupjoin) {
            $groupjoin->token = null;
            $groupjoin->token = 0;
            $groupjoin->save();

            return redirect()->route('dashboard')->with('success', 'Group player request declined successfully');
            //return view('home')->with('success', 'Group players decline successfully');
        }
        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');

        //return view('home')->with('success', 'Group players decline successfully');
    }
    
    public function sendMessage(Request $request, $id)
    {
        $data = $request->all();
        $message = Message::create([
            'created_by_id' => Auth()->user()->id,
            'subject' => 'group Message',
            'message_body' => $data['group_message'],
            'status' => 1
        ]);
        MessageRecipient::create([
            'sender_user_id' => Auth()->user()->id,
            'message_id' => $message->id,
            'group_id' => $id
        ]);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $message->id . '.' . $ext;

            $message->group_image = "oxabyo/messages/" . $message->id . "/" . $filename;
            $message->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/messages/" . $message->id
            );
        }

        if ($request->ajaxCall) {

            $messages = Message::join(
                'message_recipients',
                'message_recipients.message_id',
                'messages.id'
            )->join('users', 'users.id', 'messages.created_by_id')
                ->where('group_id', $id)
                ->orderBy('message_recipients.created_at', 'ASC')
                ->get();


            foreach ($messages as $message) {
                if ($message->group_image) {
                    $message->group_image = $this->fileService->fetchS3File($message->group_image);
                }
            }

            return view('groups.message', compact('messages'))->render();
        }

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function getAllComments(Request $request, $id)
    {
        $messages = Message::join(
            'message_recipients',
            'message_recipients.message_id',
            'messages.id'
        )->join('users', 'users.id', 'messages.created_by_id')
            ->where('group_id', $id)
            ->orderBy('message_recipients.created_at', 'ASC')
            ->get();


        foreach ($messages as $message) {
            if ($message->group_image) {
                $message->group_image = $this->fileService->fetchS3File($message->group_image);
            }
        }

        return view('groups.message', compact('messages'))->render();
    }
}
