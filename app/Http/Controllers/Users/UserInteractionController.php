<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Auth;
use Mail;

/*Models */
use App\User;
use App\Game;
use App\Team;
use App\TeamMember;
use App\TeamGame;
use App\TeamInvite;
use App\UserAction;
use App\UserFriendAction;
use App\UserFriend;
use App\Notification;
use App\Group;
use App\Twitch;
use App\Event;
use App\EventChampion;

/* Services */
use App\Services\FileService;
use App\Services\UserInteractionService;
use App\Services\AlgoService;

class UserInteractionController extends Controller
{

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var UserInteractionService
     */
    private $userInteractionService;

    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        FileService $fileService,
        UserInteractionService $userInteractionService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
        $this->userInteractionService = $userInteractionService;
        $this->algoService = $algoService;
    }


    /**
     * Get Player details by Team Id
     */
    public function playerDetails($id)
    {
        $player = User::find($id);
        if ($player->profile_image) {
            $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
        }

        $members = TeamMember::with(['users', 'teams'])
            ->where('team_id', $id)
            ->get();

        foreach ($members as $member) {
            if ($member->users->profile_image) {
                $member->users->profile_image = $this->fileService->fetchS3File($member->users->profile_image);
            }
        }

        $userFriend = UserFriend::where([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ])->first();


        $allUserFriends = UserFriend::where([
            'friend_id' => $id
        ])->get();
        $totalLikes = $allUserFriends->where('is_like', 1)->count();
        $totalFriends = $allUserFriends->where('is_connected', 1)->count();
        $teamsCreated = Team::where('admin_user_id', $id)->count();

        $teamsJoined = Team::with(['members'])
            ->whereHas('members', function ($query) use ($id) {
                $query->where('team_members.user_id', $id);
            })->count();

        $totalTeams = $teamsJoined + $teamsCreated;
        $totalTeamJoined = $teamsJoined;
        $totalTeamCreated = $teamsCreated;

        $twitch = Twitch::where('user_id', $player->id)->select('*', 'channel_name as channel_name1')->first();

        $groupCreated = Group::where('group_admin_id', $player->id)->count();

        $groupJoined = Group::with(['members'])
            ->whereHas('members', function ($query) use ($id) {
                $query->where('group_members.user_id', $id);
            })->count();

        $eventPlayed = Event::with(['event_players'])
            ->whereHas('event_players', function ($query) use ($id) {
                $query->where('event_player_details.user_id', $id);
            })->count();       

        $eventOrganized = Event::where('organizer_id', $id)->count();

        $totalGroups = $groupJoined +  $groupCreated;

        $lastEventPlayed = Event::with(['event_players', 'games', 'event_types'])
            ->whereHas('event_players', function ($query) use ($id) {
                $query->where('event_player_details.user_id', $id);
            })
            ->latest('events.created_at')
            ->first();

        $wins = EventChampion::where('winner_id', $id)->count();

        if ($lastEventPlayed && $lastEventPlayed->image) {
            $lastEventPlayed->image = $this->fileService->fetchS3File($lastEventPlayed->image);
        }

        // Fetch heighest score from the user
        $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
        $socialScore = $this->algoService->fetchHeighestSocialScore();
        $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        $performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $id);
        $social = $this->algoService->calculatePerformanceScore($socialScore, 2, $id);
        $monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $id);
        $oxarate = ceil(($performance + $social + $monetization) / 3);
        
        return view('teams.player-detail', compact(
            'player', 
            'members', 
            'userFriend',
            'totalLikes',
            'totalFriends',
            'totalTeams',
            'totalTeamJoined',
            'totalTeamCreated',
            'twitch',
            'groupCreated',
            'groupJoined',
            'eventPlayed',
            'eventOrganized',
            'lastEventPlayed',
            'wins',
            'totalGroups',
            'performance',
            'social',
            'monetization',
            'oxarate'
        ));
    }

    /**
     * 
     */
    public function connectUser(Request $request, $id)
    {
        $friend = User::find($id);

        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_connected = 0;
        $userFriend->status = 0;
        $userFriend->token = hash('sha256', Str::random(100));
        $userFriend->save();

        $userAction = UserAction::where('key', 'connect')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        $data = [];
        $data['user_name'] = Auth::user()->name;
        $data['link'] = $userFriend->token;
        $email = $friend->email;

       $notification= Notification::create([
            'sender_user_id' => Auth()->user()->id,
            'receiver_user_id'=> $friend->id,
            'title'  => "New Connection",
            'message' =>  "Approve " . $data['user_name'] . " connection request",
            'accept_href' => url(route('users.approve-connection', ['token' => $data['link']])),
            'decline_href' => url(route('users.decline-connection', ['token' => $data['link']])),
            'is_read' => 0
        ]);

        $userFriend->notification_id= $notification->id;
        $userFriend->save();

        try {
            Mail::send('emails.user-connection-request', ['data' => $data], function ($message) use ($email) {
                $message->to($email);
                $message->sender(env('MAIL_FROM_ADDRESS'));
                $message->subject('New Connection');
            });
        } catch (\Exception $e) {
            Log::info($e);
        }

        return json_encode([
            'success' => true
        ]);
    }


    public function addUserasFriend(Request $request, $id)
    {
        $friend = User::find($id);

        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_connected = 0;
        $userFriend->status = 0;
        $userFriend->token = hash('sha256', Str::random(100));
        $userFriend->save();

        $userAction = UserAction::where('key', 'connect')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        $data = [];
        $data['user_name'] = Auth::user()->name;
        $data['link'] = $userFriend->token;
        $email = $friend->email;
        try {
            Mail::send('emails.user-connection-request', ['data' => $data], function ($message) use ($email) {
                $message->to($email);
                $message->sender(env('MAIL_FROM_ADDRESS'));
                $message->subject('New Connection');
            });
        } catch (\Exception $e) {
            Log::info($e);
        }

        return redirect()->back()->with('success', 'Successfully send connection request');
      
    }

    public function unConnectUser(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_connected = 0;
        $userFriend->status = 1;
        $userFriend->save();

        

        $userAction = UserAction::where('key', 'unconnect')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        $userFriend = UserFriend::updateOrCreate([
            'friend_id' => Auth()->user()->id,
            'user_id' => $id
        ]);
        $userFriend->is_connected = 0;
        $userFriend->status = 1;
        $userFriend->save();

        return redirect()->back()->with('success', 'Successfully removed connection');

        // return json_encode([
        //     'success' => true
        // ]);
    }

    /**
     * 
     */
    public function approveConnection(Request $request, $token)
    {
        $userFriend = UserFriend::where([
            'token' => $token,
            'friend_id' => auth()->user()->id
        ])->first();
        if ($userFriend) {
            $userFriend->is_connected = 1;
            $userFriend->status = 1;
            $userFriend->token = null;
            $userFriend->save();

            $userAction = UserAction::where('key', 'connect')->first();

            UserFriendAction::create([
                'user_friend_id' => $userFriend->id,
                'user_action_id' => $userAction->id,
                'date'  => now(),
                'status' => 1
            ]);

            $user = User::find($userFriend->user_id);
            $data = Auth::user()->name." has approved your connection request";
            $email = $user->email;
            $notification= Notification::updateOrCreate([
            'sender_user_id' => Auth()->user()->id,
            'receiver_user_id'=> $user->id,
            'title'  => "New Connection",
            'message' =>  $data,
            'is_read' => 0
            ]);
                  
            $userFriend->save();

            if($userFriend->notification_id){

                Notification::where('id', $userFriend->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            try {
                Mail::send('emails.default', ['data' => $data], function ($message) use ($email) {
                    $message->to($email);
                    $message->sender(env('MAIL_FROM_ADDRESS'));
                    $message->subject('New Connection');
                });
            } catch (\Exception $e) {
                Log::info($e);
            }

            // update reward for event creation
            $this->algoService->updateRewardPointsForSocial($userFriend->id, 'connect_with_an_user');

            $userFriend = UserFriend::updateOrCreate([
                'user_id' => Auth()->user()->id,
                'friend_id' => $userFriend->user_id
            ]);
            $userFriend->is_connected = 1;
            $userFriend->status = 1;
            $userFriend->save();

            // update reward for event creation
            $this->algoService->updateRewardPointsForSocial($userFriend->id, 'connect_with_an_user');

            return redirect()->route('dashboard')->with('success', 'Approved connection successfully');
        }        
        //return view('home')->with('success', 'Approved connection successfully');

        return redirect()->route('dashboard')->with('error', 'Unauthorized access');
    }

    /**
     * 
     */
    public function declineConnection(Request $request, $token)
    {
        $userFriend = UserFriend::where([
            'token' => $token,
            'friend_id' => auth()->user()->id
        ])->first();
        if ($userFriend) {
            $userFriend->is_connected = 0;
            $userFriend->status = 1;
            $userFriend->token = null;
            $userFriend->save();

            // TODO
            $userAction = UserAction::where('key', 'unconnect')->first();

            UserFriendAction::create([
                'user_friend_id' => $userFriend->id,
                'user_action_id' => $userAction->id,
                'date'  => now(),
                'status' => 1
            ]);

            $user = User::find($userFriend->user_id);
            $data = Auth::user()->name." has refused your connection request";
            $email = $user->email;
            $notification= Notification::updateOrCreate([
                'sender_user_id' => Auth()->user()->id,
                'receiver_user_id'=> $user->id,
                'title'  => "New Connection",
                'message' =>  $data,
                'is_read' => 0
                ]);
                
                $userFriend->save();

            try {
                Mail::send('emails.default', ['data' => $data], function ($message) use ($email) {
                    $message->to($email);
                    $message->sender(env('MAIL_FROM_ADDRESS'));
                    $message->subject('New Connection');
                });
            } catch (\Exception $e) {
                Log::info($e);
            }

            return redirect()->route('dashboard')->with('success', 'Decline connection successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access');

        // return view('home')->with('success', 'Decline connection successfully');
    }

    public function blockUser(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_blocked = 1;
        $userFriend->save();

        $userAction = UserAction::where('key', 'block')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Successfully blocked the user');

        // return json_encode([
        //     'success' => true
        // ]);
    }

    public function unblockUser(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_blocked = 0;
        $userFriend->save();

        $userAction = UserAction::where('key', 'unblock')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Successfully unblocked the user');

        // return json_encode([
        //     'success' => true
        // ]);
    }

    public function likeUser(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_like = 1;
        $userFriend->save();

        $userAction = UserAction::where('key', 'like')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

         // update reward for event creation
         $this->algoService->updateRewardPointsForSocial(auth()->user()->id, 'give_a_like');

         // update reward for event creation
         $this->algoService->updateRewardPointsForSocial($id, 'received_likes');

        return json_encode([
            'success' => true
        ]);
    }

    /**
     * Dislike user
     */
    public function dislikeUser(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_like = 0;
        $userFriend->save();

        $userAction = UserAction::where('key', 'unlike')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return json_encode([
            'success' => true
        ]);
    }

    public function reportAbuse(Request $request, $id)
    {
        $userFriend = UserFriend::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ]);
        $userFriend->is_abuse = 1;
        $userFriend->save();

        $userAction = UserAction::where('key', 'report-abuse')->first();

        UserFriendAction::create([
            'user_friend_id' => $userFriend->id,
            'user_action_id' => $userAction->id,
            'date'  => now(),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Successfully reported this user as abused');

        // return json_encode([
        //     'success' => true
        // ]);
    }

    public function getPlayerList(Request $request)
    {
        $search = trim($request->input('search'));

        $players = $this->userInteractionService->getAllEPlayerList($search, $request);   

        if ($request->ajaxCall) {
            return view('users.players-table', compact('players'))->render();
        }

        return view('users.player-list', compact(
            'players'
        ));
    }
}
