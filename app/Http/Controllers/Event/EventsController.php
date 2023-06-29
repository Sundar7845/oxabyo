<?php namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Auth;

/*Models */
use App\User;
use App\Game;
use App\Team;
use App\EventType;
use App\PlayerType;
use App\Slider;
use App\Phase;
use App\EventInvite;
use App\EventAdminInvite;
use App\EventPlayerDetail;
use App\TeamMember;
use App\EventPlayerTeam;
use App\LiveComment;
use App\Comment;
use App\Event;
use App\EventJoinee;
use App\Notification;
use App\EventChampion;
use Carbon\Carbon;

/* Services */
use App\Services\FileService;
use App\Services\EventService;
use App\Services\EventInviteService;
use App\Services\UserInteractionService;
use App\Services\FixtureService;
use App\Services\AlgoService;
use App\Traits\SubscriptionTrait;

class EventsController extends Controller
{
    use SubscriptionTrait;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var EventService
     */
    private $eventService;

    /**
     * @var EventInviteService
     */
    private $eventInviteService;

    /**
     * @var UserInteractionService
     */
    private $userInteractionService;

    /**
     * @var FixtureService
     */
    private $fixtureService;

    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        FileService $fileService,
        EventService $eventService,
        EventInviteService $eventInviteService,
        UserInteractionService $userInteractionService,
        FixtureService $fixtureService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
        $this->eventService = $eventService;
        $this->eventInviteService = $eventInviteService;
        $this->userInteractionService = $userInteractionService;
        $this->fixtureService = $fixtureService;
        $this->algoService = $algoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // current events
        $currentEvents = $this->eventService->getCurrentEvents();
        foreach ($currentEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
            if ($event->cover) {
                $event->cover = $this->fileService->fetchS3File($event->cover);
            }
        }
        // upcoming events
        $upcomingEvents = $this->eventService->getUpcomingEvents();
        foreach ($upcomingEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
        }
        // All events
        $allEvents = $this->eventService->getAllEvents();
        foreach ($allEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
        }
        $players = $currentEvents;
        $sliders = Slider::with(['events', 'events.player_types', 'events.games', 'events.event_types'])
            ->orderBy('position', 'asc')
            ->get();
        foreach ($sliders as $slider) {
            if ($slider->events->cover) {
                $slider->events->cover = $this->fileService->fetchS3File($slider->events->cover);
            }
            if ($slider->events->image) {
                $slider->events->image = $this->fileService->fetchS3File($slider->events->image);
            }
        }

        $games = Game::get();

        return view('events.index', compact('currentEvents', 'upcomingEvents', 'allEvents', 'players', 'sliders', 'games'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = $this->eventService->findEventsById($id);
        if (!$event) {
            return redirect()->back()->with(['error' => 'Invalid access']);
        }
        if ($event->cover) {
            $event->cover = $this->fileService->fetchS3File($event->cover);
        }
        if ($event->image) {
            $event->image = $this->fileService->fetchS3File($event->image);
        }
        $players = $this->eventService->findAllEventPlayers($id);

        // Fetch heighest score from the user
        $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
        $socialScore = $this->algoService->fetchHeighestSocialScore();
        $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        foreach ($players as $player) {
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
            }
            $player->wins = EventChampion::where('winner_id', $player->id)->count();
            $player->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $player->id);
            $player->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $player->id);
            $player->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $player->id);
            $player->oxarate = ceil(($player->performance + $player->social + $player->monetization) / 3);
        }

        //Fetch Comments
        $comments = LiveComment::join('comments', 'comments.id', 'live_comments.comment_id')
            ->join('users', 'users.id', 'live_comments.created_by_id')
            ->select('live_comments.*', 'comments.comment', 'users.name')
            ->where('event_id', $id)
            ->where('can_hide', '0')
            ->whereNull('player_id')
            ->get();


        if ($event->event_types->name == 'Single Player') {
            $player = $this->eventService->findSingleEventPlayer($id);
            if ($player && $player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
            }
            return view('events.view.event-view-single-player', compact('event', 'player', 'players', 'comments'));
        } else if ($event->event_types->name  == 'One shot') {
            return view('events.view.event-view-one-shot', compact('event', 'players', 'comments'));
        } else {

            $completedEventPhase = $this->fixtureService->fetchCompletedEventPhase($id);

            foreach ($completedEventPhase as $completedPhase) {
                foreach ($completedPhase->fixtures as $fixtures) {
                    $challenger1 = $fixtures->challenger1->players ?? '';
                    if ($challenger1 && $challenger1->profile_image && Str::startsWith($challenger1->profile_image, 'oxabyo/profiles')) {
                        $fixtures->challenger1->players->profile_image = $this->fileService->fetchS3File($challenger1->profile_image);                   
                    }
                    $challenger2 = $fixtures->challenger2->players ?? '';
                    if ($challenger2 && $challenger2->profile_image && Str::startsWith($challenger2->profile_image, 'oxabyo/profiles')) {
                        $fixtures->challenger2->players->profile_image = $this->fileService->fetchS3File($challenger2->profile_image);
                    }
                }
            }

            $champion = $this->eventService->getEventChampion($id);

            if ($champion && $champion->profile_image) {
                $champion->profile_image = $this->fileService->fetchS3File($champion->profile_image);
            }

            $fixture = $this->eventService->getNextMatchDetails($id);
            if (isset($fixture->challenger1->players->profile_image) && $fixture->challenger1->players->profile_image) {
                $fixture->challenger1->players->profile_image = $this->fileService->fetchS3File($fixture->challenger1->players->profile_image);
            }
            if (isset($fixture->challenger2->players->profile_image) && $fixture->challenger2->players->profile_image) {
                $fixture->challenger2->players->profile_image = $this->fileService->fetchS3File($fixture->challenger2->players->profile_image);
            }

            

            return view('events.view.event-view-challenge-round', compact(
                'event', 'players', 'completedEventPhase', 'champion', 'fixture', 'comments'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = $this->eventService->findEventsById($id);
        $games = Game::get();
        $teams = Team::get();
        $playerTypes = PlayerType::get();
        $phases = Phase::get();
        $eventTypes = EventType::whereNotIn('name', ['Single Player', 'One shot'])->get();

        if (! $event) {
            return redirect()->back()->with(['error'=>'Invalid access']);
        }
        if ($event->cover) {
            $event->cover = $this->fileService->fetchS3File($event->cover);
        }
        if ($event->image) {
            $event->image = $this->fileService->fetchS3File($event->image);
        }

           // Fetch heighest score from the user
           $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
           $socialScore = $this->algoService->fetchHeighestSocialScore();
           $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();
   

        $users = $this->userInteractionService->getAllUserFriends();
        $players = $this->eventService->findAllEventPlayersWithFriends($id);
        foreach ($players as $player) {          
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
            }

            $player->wins = EventChampion::where('winner_id', $player->cust_user_id)->count();
            $player->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $player->cust_user_id);
            $player->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $player->cust_user_id);
            $player->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $player->cust_user_id);
            $player->oxarate = ceil(($player->performance + $player->social + $player->monetization) / 3);
         

        }
 
      

        if ($event->event_types->name == 'Single Player') {
            return view('events.manage.event-single-player', compact(
                'event', 
                'games', 
                'playerTypes', 
                'teams', 
                'phases', 
                'users', 
                'eventTypes',
                'players'
            ));
        } else if ($event->event_types->name  == 'One shot') {
            return view('events.manage.event-one-shot', compact(
                'event', 
                'players', 
                'games', 
                'playerTypes', 
                'teams', 
                'phases', 
                'users', 
                'eventTypes'
            ));
        } else {       
            
            $currentEventPhase = $this->fixtureService->fetchCurrentEventPhase($id);
            $currentEventFixtureResult = $this->fixtureService->getFixtureResultById($id, $currentEventPhase);
            $completedEventPhase = $this->fixtureService->fetchCompletedEventPhase($id);
            $lastWinners = $this->eventService->findAllEventPlayersWithLastWinners($id, $completedEventPhase);
            foreach ($lastWinners as $player) {          
                if ($player->profile_image) {
                    $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
                }
            }          

            foreach ($completedEventPhase as $completedPhase) {
                foreach ($completedPhase->fixtures as $fixtures) {
                    $challenger1 = $fixtures->challenger1->players ?? '';
                    if ($challenger1 && $challenger1->profile_image && Str::startsWith($challenger1->profile_image, 'oxabyo/profiles')) {
                        $fixtures->challenger1->players->profile_image = $this->fileService->fetchS3File($challenger1->profile_image);                   
                    }
                    $challenger2 = $fixtures->challenger2->players ?? '';
                    if ($challenger2 && $challenger2->profile_image && Str::startsWith($challenger2->profile_image, 'oxabyo/profiles')) {
                        $fixtures->challenger2->players->profile_image = $this->fileService->fetchS3File($challenger2->profile_image);
                    }

                    $winner = $fixtures->fixture_results->winner->players ?? '';
                    if ($winner && $winner->profile_image && Str::startsWith($winner->profile_image, 'oxabyo/profiles')) {
                        $fixtures->fixture_results->winner->players->profile_image = $this->fileService->fetchS3File($winner->profile_image);
                    }

                    $looser = $fixtures->fixture_results->looser->players ?? '';
                    if ($looser && $looser->profile_image && Str::startsWith($looser->profile_image, 'oxabyo/profiles')) {
                        $fixtures->fixture_results->looser->players->profile_image = $this->fileService->fetchS3File($looser->profile_image);
                    }

                }
            }

            $champions = $this->fixtureService->getChampions(); 

            return view('events.manage.event-challenge-round', compact(
                'event', 
                'players', 
                'games', 
                'playerTypes',  
                'teams', 
                'phases', 
                'users', 
                'eventTypes',
                'currentEventPhase',
                'currentEventFixtureResult',
                'completedEventPhase',
                'lastWinners',
                'champions'
            ));
        }
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
        $event = $this->eventService->find($id);

        $data = $request->all();

        if ($request->time_zone) {
            $data['match_date'] = getUTCDate($request->match_date, $request->match_hour, $request->time_zone);            
            $data['match_hour'] = getUTCTime($request->match_date, $request->match_hour, $request->time_zone); 
        }
 
        $event->fill($data);

        if ($request->event_type) {
            $eventType = EventType::where('name', $request->event_type)->first();
            $event->event_type_id = $eventType ? $eventType->id : null;
        }

        if ($request->max_num_players) {
            $phase = Phase::where('value', $request->max_num_players)->first();
            $event->number_of_rounds = $phase ? $phase->round : null;
        }
        $event->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->image = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/events/".$event->id
            );
        }

        if ($request->cover) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->cover->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->cover->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->cover = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->cover,
                "oxabyo/events/".$event->id
            );
        }

        return redirect()->back()->with('success', 'Event updated successfully');
    }

    /**
     * Create Event in one shot
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventCreateOneShot(Request $request)
    {
        $games = Game::get();
        $playerTypes = PlayerType::get();
        $teams = Team::get();

        $users = $this->userInteractionService->getAllUserFriends();     
       
        $subscriptionStatus = $this->validateSubscription();
        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }
       
        return view('events.event-create-one-shot', compact('games', 'playerTypes', 'users', 'teams'));
    }

    /**
     * Create single player event
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventCreateSinglePlayer(Request $request)
    {
        $games = Game::get();
        $users = $this->userInteractionService->getAllUserFriends();
         
        $subscriptionStatus = $this->validateSubscription();
        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }
	
        return view('events.event-create-single-player', compact('games', 'users'));
    }

    /**
     * Create event challenge round
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventCreateChallengeRound(Request $request)
    {
        $games = Game::get();
        $playerTypes = PlayerType::get();
        $eventTypes = EventType::whereNotIn('name', ['Single Player', 'One shot'])->get();
        $teams = Team::get();
        $phases = Phase::where('action', '!=', 'Super Final')
            ->get();
        $users = $this->userInteractionService->getAllUserFriends();   

        $champions = $this->fixtureService->getChampions(); 

        $subscriptionStatus = $this->validateSubscription();
        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }

        return view('events.event-create-challenge-round', compact(
            'games', 
            'playerTypes', 
            'users', 
            'eventTypes', 
            'phases',
            'teams',
            'champions'
        ));
    }

    public function validateSubscription()
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
        $getTotalNumberOfEventJoined = EventJoinee::where('event_id', Auth()->user()->id)
            ->whereBetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();
            
        return $this->validateSubscriptionUserPermission("event_participation", $getTotalNumberOfEventJoined, $currentPlan); 
    }

    /**
     * Store a single player event
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->event_type) {
            $eventType = EventType::where('name', $request->event_type)->first();
            $data['event_type_id'] = $eventType ? $eventType->id : null;
        }

        if ($request->max_num_players) {
            $phase = Phase::where('value', $request->max_num_players)->first();
            $data['number_of_rounds'] = $phase ? $phase->round : null;
        }   

        $data['organizer_id'] = Auth::user()->id;

        if ($request->time_zone) {
            $data['match_date'] = getUTCDate($request->match_date, $request->match_hour, $request->time_zone);            
            $data['match_hour'] = getUTCTime($request->match_date, $request->match_hour, $request->time_zone); 
        }       

        $event = $this->eventService->create($data);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->image = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/events/".$event->id
            );
        }

        if ($request->cover) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->cover->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->cover->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->cover = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->cover,
                "oxabyo/events/".$event->id
            );
        }

        if ($request->inviteChampions) {            
            $event->is_champion_invite = 1;
            $event->save();
            $this->eventInviteService->inviteUsers($request->inviteChampions, $event, 1);
        }
        if ($request->inviteUsers) {
            $this->eventInviteService->inviteUsers($request->inviteUsers, $event, 0);
        }
        if ($request->inviteEventAdmin) {
            $this->eventInviteService->inviteEventAdmin($request->inviteEventAdmin, $event);
        }

        if ($request->inviteTeamPlayers) {
            $this->eventInviteService->inviteTeamEvents($request->inviteTeamPlayers, $event);
        }

        // Store Event phases
        if ($request->max_num_players) {
            $this->fixtureService->createEventPhase($event);
        }
        
        // update reward for event creation
        $this->algoService->updateRewardPointsForSocial(auth()->user()->id, 'event_creation');

        if ($event->ticket > 0) {
            $this->updateRewardPointsForMonetization(auth()->user()->id, 'pay_event_creation');
        }

        if ($event->allow_players_streaming) {
            $this->updateRewardPointsForSocial(auth()->user()->id, 'event_streaming');
        }

        return redirect()->route('events.index');
    }

    /**
     * Accept the event invite for the user via email
     */
    public function acceptInvite(Request $request)
    {
        $eventInvite = EventInvite::where('token', $request->token)
            ->first();
        if ($eventInvite) {
            $eventInvite->date = now();
            $eventInvite->status = 'approved';
            $eventInvite->is_invite_accept = 1;
            $eventInvite->token = null;
            $eventInvite->save();

            $eventPlayerDetail = EventPlayerDetail::updateOrCreate([
                'event_id'      => $eventInvite->event_id,
                'user_id'       => $eventInvite->invitee_id
            ]);
            $eventPlayerDetail->is_champion = $eventInvite->is_champion;
            $eventPlayerDetail->save();

            if($eventInvite->notification_id){

                Notification::where('id',$eventInvite->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }
            return redirect()->route('events.show', $eventInvite->event_id)->with('success', 'You have successfully joined to the event');
        }
        return redirect()->route('dashboard')->with('success', 'Event players joined successfully');       
    }

    /**
     * Decline the event invite request by email
     */
    public function declineInvite(Request $request)
    {
        $eventInvite = EventInvite::where('token', $request->token)
            ->first();
        if ($eventInvite) {
            $eventInvite->date = now();
            $eventInvite->status = 'rejected';
            $eventInvite->is_invite_accept = 0;
            $eventInvite->token = null;
            $eventInvite->save();
        }

        return redirect()->route('dashboard')->with('success', 'Event players decline successfully');
    }

    /**
     * Accept the event invite for the user via email
     */
    public function acceptAdminInvite(Request $request)
    {
        $eventAdminInvite = EventAdminInvite::where('token', $request->token)
            ->first();
        if ($eventAdminInvite) {
            $eventAdminInvite->date = now();
            $eventAdminInvite->status = 'approved';
            $eventAdminInvite->is_invite_accept = 1;
            $eventAdminInvite->token = null;
            $eventAdminInvite->save();

            $eventPlayerDetail = EventPlayerDetail::updateOrCreate([
                'event_id'      => $eventAdminInvite->event_id,
                'user_id'       => $eventAdminInvite->invitee_id
            ]);
            $eventPlayerDetail->is_champion = $eventAdminInvite->is_champion;
            $eventPlayerDetail->is_admin = 1;
            $eventPlayerDetail->save();

            if($eventAdminInvite->notification_id){

                Notification::where('id',$eventAdminInvite->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }
            return redirect()->route('events.show', $eventAdminInvite->event_id)->with('success', 'You have successfully joined to the event admin');
        }
        return redirect()->route('dashboard')->with('success', 'Event players admin joined successfully');       
    }

    /**
     * Decline the event invite request by email
     */
    public function declineAdminInvite(Request $request)
    {
        $eventAdminInvite = EventAdminInvite::where('token', $request->token)
            ->first();
        if ($eventAdminInvite) {
            $eventAdminInvite->date = now();
            $eventAdminInvite->status = 'rejected';
            $eventAdminInvite->is_invite_accept = 0;
            $eventAdminInvite->token = null;
            $eventAdminInvite->save();
        }
        return redirect()->route('dashboard')->with('success', 'Event player admin request declined successfully');
    }

    
    /**
     * Accept the event invite for the user via email
     */
    public function acceptTeamInvite(Request $request)
    {
        $eventInvite = EventInvite::where('token', $request->token)
            ->first();
        
        if ($eventInvite) {
            $eventInvite->date = now();
            $eventInvite->status = 'approved';
            $eventInvite->is_invite_accept = 1;
            $eventInvite->token = null;
            $eventInvite->save();

            // Save the members of the teams
            $teamMembers = TeamMember::where('team_id', $eventInvite->team_id)->get();

            $eventPlayerTeam = EventPlayerTeam::updateOrCreate([
                'event_id'      => $eventInvite->event_id,
                'team_id'       => $eventInvite->team_id
            ]);

            foreach ($teamMembers as $teamMember) {
                $eventPlayerDetail = EventPlayerDetail::updateOrCreate([
                    'event_id'      => $eventInvite->event_id,
                    'user_id'       => $teamMember->user_id,
                    'event_player_team_id' => $eventPlayerTeam->id
                ]);
                $eventPlayerDetail->save();
            }

            if($eventInvite->notification_id){

                Notification::where('id',$eventInvite->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('events.show', $eventInvite->event_id)->with('success', 'You have accepted the event');
        }
        return redirect()->route('dashboard')->with('success', 'Event players joined successfully');       
    }

    /**
     * Decline the event invite request by email
     */
    public function declineTeamInvite(Request $request)
    {
        $eventInvite = EventInvite::where('token', $request->token)
            ->first();
        if ($eventInvite) {
            $eventInvite->date = now();
            $eventInvite->status = 'rejected';
            $eventInvite->is_invite_accept = 0;
            $eventInvite->token = null;
            $eventInvite->save();
        }

        return redirect()->route('dashboard')->with('success', 'Event players decline successfully');
    }

    public function customEventInvite(Request $request)
    {
        $event = $this->eventService->findEventsById($request->currentEventId);

        if ($request->inviteChampions) {
            $this->eventInviteService->inviteUsers($request->inviteChampions, $event, 1);
        }
        if ($request->inviteUsers) {
            $this->eventInviteService->inviteUsers($request->inviteUsers, $event, 0);
        }
        if ($request->inviteEventAdmin) {
            $this->eventInviteService->inviteEventAdmin($request->inviteEventAdmin, $event);
        }

        if ($request->inviteTeamPlayers) {
            $this->eventInviteService->inviteTeamEvents($request->inviteTeamPlayers, $event);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back()->with('success', 'Event player removed successfully');
    }

    /**
     * Remove the event player from Event
     *
     * @param  int $id
     * @param  int $event_id
     * @return \Illuminate\Http\Response
     */
    public function removeEventPlayer($id)
    {
        $eventPlayerDetail = EventPlayerDetail::find($id);
        $eventPlayerDetail->delete();
        
        return redirect()->back()->with('success', 'Event player removed successfully');
    }

    /**
     * Search Events
     */
    public function searchEvents(Request $request)
    {
        // All events
        $allEvents = $this->eventService->searchEvents($request);
        foreach ($allEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
        }

        return view('includes.event_table', compact('allEvents'))->render();
    }
    
    public function eventDetails($id)
    {
        $event = $this->eventService->findEventsById($id);
        if ($event->cover) {
            $event->cover = $this->fileService->fetchS3File($event->cover);
        }
        if ($event->image) {
            $event->image = $this->fileService->fetchS3File($event->image);
        }

        $players = $this->eventService->findAllEventPlayers($id);
        foreach ($players as $player) {
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
            }
        }

        return view('events.view.event-detail', compact(

            'event', 'players'
        ));
    }

    /**
     * Join Event
     */
    public function joinEvent(Request $request, $id)
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

        $getTotalNumberOfJoined = EventPlayerDetail::where('user_id',Auth()->user()->id)
            ->wherebetween('created_at',[$startOfMonth,$endOfMonth])
            ->count();

        $subscriptionStatus = $this->validateSubscriptionUserPermission("event_participation", $getTotalNumberOfJoined, $currentPlan);

        if ($subscriptionStatus) {
            return redirect()->back()->with(
                'subscription-alert-model',
                'Your maximum subscription limit is reached. Please upgrade your plan'
            );
        }
        $event = Event::find($id);

        $user = User::where('id', $event->organizer_id)->first();

        // Store the invited user into the database
        $eventJoinee = EventJoinee::updateOrCreate([
            'joinee_id' => Auth()->user()->id,
            'approved_by_id' =>  $user->id,
            'event_id' => $event->id,
            'date' => now(),
            'status' => 'sent'
        ]);

        $token = hash('sha256', Str::random(100));
        $eventJoinee->token = $token;
        $eventJoinee->save();

       
 
        $this->eventInviteService->joinEvents($user, $event, $eventJoinee->token,$eventJoinee);

        return redirect()->back()->with('success', 'Event join request sent successfully');
    }

    /**
     * Event accept
     */
    public function acceptJoin(Request $request)
    {
        $eventJoinee = EventJoinee::where('token', $request->token)
            ->where('approved_by_id', auth()->user()->id)
            ->first();
        
        if ($eventJoinee) {
            $eventJoinee->date = now();
            $eventJoinee->status = 'approved';
            $eventJoinee->token = null;
            $eventJoinee->save();

            $eventPlayerDetail = EventPlayerDetail::updateOrCreate([
                'event_id'      => $eventJoinee->event_id,
                'user_id'       => $eventJoinee->joinee_id
            ]);
            $eventPlayerDetail->save();
            if( $eventJoinee->notification_id){

                Notification::where('id',$eventJoinee->notification_id)
                ->update([
                    'accept_href'=>null,
                    'decline_href'=>null,
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Event players joined successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');
    }

    /**
     * Event Decline
     */
    public function declineJoin(Request $request)
    {
        $eventJoinee = EventJoinee::where('token', $request->token)
            ->where('approved_by_id', auth()->user()->id)
            ->first();
        if ($eventJoinee) {
            $eventJoinee->token = null;
            $eventJoinee->status = 'rejected';
            $eventJoinee->save();

            return redirect()->route('dashboard')->with('success', 'Event player request declined successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access to this approval');
    }
}
