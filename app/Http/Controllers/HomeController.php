<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

/* Services */
use App\Services\FileService;
use App\Services\EventService;
use App\Services\MailService;
use App\Services\AlgoService;

/** Models */
use App\Team;
use App\User;
use App\Group;
use App\UserFriend;
use App\Twitch;
use App\Event;
use App\EventChampion;

class HomeController extends Controller
{
    /**
     * @var EventService
     */
    private $eventService;
    
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * @var AlgoService
     */
    private $algoService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FileService $fileService,
        EventService $eventService,
        MailService $mailService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
        $this->eventService = $eventService;
        $this->mailService=$mailService;
        $this->algoService = $algoService;
    }

    public function dashboard()
    {
        $user = Auth::user();

        $id = $user->id;

        $teamCreated = Team::where('admin_user_id', $user->id)->count();
     

        $allUserFriends = UserFriend::where([
            'friend_id' => $user->id
        ])->get();


        $totalLikes = $allUserFriends->where('is_like', 1)->count();
        $totalFriends = $allUserFriends->where('is_connected', 1)->count();

 

        $teamsJoined = Team::with(['members'])
            ->whereHas('members', function ($query) use ($id) {
                $query->where('team_members.user_id', $id);
            })->count();

        $totalTeamJoined = $teamsJoined;
      
        $totalTeams = $teamsJoined + $teamCreated;
        
        $twitch = Twitch::where('user_id', $user->id)->select('*', 'channel_name as channel_name1')->first();

        $groupCreated = Group::where('group_admin_id', $user->id)->count();

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

        return view('wall',compact('user', 'teamCreated', 'totalLikes', 'totalFriends',  
            'totalTeamJoined', 
            'totalTeams',
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
            )
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {

            if ($user->profile_image) {
                $profile_image = $this->fileService->fetchS3File($user->profile_image);
                session::put('user_profile_image', $profile_image); 
            }
            if ($user->isAdmin($user)) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }
        //current events 
        $currentEvents = $this->eventService->getAllEvents();
        foreach ($currentEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
            if ($event->cover) {
                $event->cover = $this->fileService->fetchS3File($event->cover);
            }
        }

        $players = User::with(['friends'])
            ->where('users.user_role_id', '!=', '1')
            ->orderBy('users.name', 'ASC')
            ->get();

             // Fetch heighest score from the user
           $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
           $socialScore = $this->algoService->fetchHeighestSocialScore();
           $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        foreach ($players as $player) {
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3file($player->profile_image);
            }

            $player->wins = EventChampion::where('winner_id', $player->id)->count();
            $player->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $player->id);
            $player->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $player->id);
            $player->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $player->id);
            $player->oxarate = ceil(($player->performance + $player->social + $player->monetization) / 3);
        }

        $players = $players->sort(function ($a, $b) {
            return $a->oxarate < $b->oxarate;
        })->take(10);
       
        return view('home', compact('currentEvents', 'players'));
    }

    /**
     * Account activation view
     */
    public function accountActivationView()
    {
        $user = Auth::user();
        return view('users.account-activation', compact('user'));
    }

    /**
     * Tournaments page view
     */
    public function getTournaments() 
    {
        //current events 
        $currentEvents = $this->eventService->getAllEvents();
        foreach ($currentEvents as $event) {
            if ($event->image) {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
            if ($event->cover) {
                $event->cover = $this->fileService->fetchS3File($event->cover);
            }
        }

        return view('events.view.tournament', compact('currentEvents'));
    }

    /**
     * Function: To send the contact us email
     * 
     */
    public function sendContactEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        $data = [];
        $data['name'] = $request->name;
        $data['surname'] = $request->surname;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['message'] = $request->message;
        // Email Send
        $this->mailService->send(env('ADMIN_EMAIL_ADDRESS'), 'Richiesta di contatto dal sito web', 'contact-us', $data);
        
        return redirect()->route('contact')
            ->with('success', 'Thanks for contacting us. We will get back you shortly!');
    }

    /**
     * Display contacts page
     */
    public function contact()
    {
        return view('events.view.contact');
    }

    /**
     * Display privacy page
     */
    public function privacy()
    {
        return view('events.view.privacy');
    }

    /**
     * Display cookie page
     */
    public function cookie()
    {
        return view('events.view.cookie');
    }
    
    /**
     * Guest E Players
     */
    public function guestPlayers()
    {
        $players = User::with(['friends'])
            ->where('users.user_role_id', '!=', '1')
            ->orderBy('users.name', 'ASC')
            ->get();

             // Fetch heighest score from the user
           $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
           $socialScore = $this->algoService->fetchHeighestSocialScore();
           $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        foreach ($players as $player) {
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3file($player->profile_image);
            }

            $player->wins = EventChampion::where('winner_id', $player->id)->count();
            $player->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $player->id);
            $player->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $player->id);
            $player->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $player->id);
            $player->oxarate = ceil(($player->performance + $player->social + $player->monetization) / 3);
        }
        return view('users.guest-players', compact('players'));
    }
        
}
