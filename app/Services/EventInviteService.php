<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\EventInviteServiceInterface;

use Illuminate\Support\Str;
use Log;
use Auth;
use Mail;

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
use App\Notification;

/** Services */
use App\Services\MailService;

class EventInviteService implements EventInviteServiceInterface
{

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * EventInviteService constructor.
     *
     * @param MailService   $mailService
     */
    public function __construct(
        MailService $mailService
    ) {
        $this->mailService = $mailService;
    }

    /**
     * @Service - Invite Users
     */
    public function inviteUsers($inviteUsers, $event, $isChampion)
    {
        $data = [];
        $inviteUsers = explode(',', $inviteUsers);
        $users = User::whereIn('id',$inviteUsers)->get();        
        $data['message'] = Auth::user()->name . " has invited you to participate to the event " . $event->name;
        foreach ($users as $user) {
	
	    $token = hash('sha256', Str::random(100));
            $data['accept_href'] = url(route('event-invite-accept', ['token' => $token]));
            $data['decline_href'] = url(route('event-invite-decline', ['token' => $token]));

            $notification = Notification::create([              
                'sender_user_id' => Auth()->user()->id,
                'receiver_user_id' => $user->id,
                'title'  => "Event Invite",
                'message' => $data['message'],
                'accept_href' =>  $data['accept_href'],
                'decline_href' => $data['decline_href'],
                'is_read' => 0
            ]);

            $eventInvite = EventInvite::updateOrCreate([
                'invitee_id' =>  $user->id,
                'invite_sent_by' => Auth()->user()->id,
                'event_id' => $event->id,
                'is_champion' => $isChampion,
                'status' => 'sent',
                'date' => now()
            ]);
           
            $eventInvite->token = $token;
            $eventInvite->notification_id = $notification->id;
            $eventInvite->save();           

            /** Send Email */
            $this->mailService->send($user->email,'Event Invite','invite-event', $data);
        }
    }

    /**
     * @Service - Invite Event Admin
     */
    public function inviteEventAdmin($inviteEventAdmin, $event)
    {
        $data = [];
        $eventAdminUsers = explode(',', $inviteEventAdmin);
        $users = User::whereIn('id', $eventAdminUsers)->get();
        $data['message'] = Auth::user()->name . " invited you to join the Event Admin " . $event->name;
        
        foreach ($users as $user) {
            $adminInvite = EventAdminInvite::updateOrCreate([
                'invitee_id' =>  $user->id,
                'invite_sent_by' => Auth()->user()->id,
                'event_id' => $event->id,
                'status' => 'sent',
                'date' => now()
            ]);
            $token = hash('sha256', Str::random(100));
            $data['accept_href'] = url(route('event-invite-admin-accept', ['token' =>$token]));
            $data['decline_href'] = url(route('event-invite-admin-decline', ['token' => $token]));

          $notification=  Notification::create([
                'sender_user_id' =>Auth()->user()->id,
                'receiver_user_id' =>$user->id, 
                'title'  => "Event Admin Invite",
                'message' =>  $data['message'],
                'accept_href' => $data['accept_href'],
                'decline_href' =>  $data['decline_href'],
                'is_read' => 0
            ]);
            $adminInvite->token = $token;
            $adminInvite->notification_id = $notification->id;
            $adminInvite->save();

            /** Send Email */
            $this->mailService->send($user->email,'Event Admin Invite','invite-event', $data);
        }
    }

    /**
     * Invite Team for Event
     */
    public function inviteTeamEvents($inviteEventAdmin, $event)
    {
        $teamIds = explode(',', $inviteEventAdmin);

        $teams = Team::join('users', 'users.id', 'admin_user_id')
            ->whereIn('teams.id',$teamIds)
            ->select('teams.id', 'admin_user_id', 'users.email')
            ->get();

        $data = [];

        $data['message'] = Auth::user()->name . " has invited your team to participate to the event " . $event->name;            
        
        foreach ($teams as $team) {

            $eventInvite = EventInvite::updateOrCreate([
                'invitee_id' =>  $team->admin_user_id,
                'invite_sent_by' => Auth()->user()->id,
                'event_id' => $event->id,
                'team_id' => $team->id,
                'status' => 'sent',
                'date' => now()
            ]);
            $token = hash('sha256', Str::random(100));
            $data['accept_href'] = url(route('event-invite-team-accept', ['token' => $token]));
            $data['decline_href'] = url(route('event-invite-team-decline', ['token' => $token]));

            $notification=  Notification::create([
                'sender_user_id' =>Auth()->user()->id,
                'receiver_user_id' =>$team->id, 
                'title'  => "Event Admin Invite",
                'message' =>  $data['message'],
                'accept_href' => $data['accept_href'],
                'decline_href' =>  $data['decline_href'],
                'is_read' => 0
            ]);
            $eventInvite->token = $token;
            $eventInvite->notification_id = $notification->id;
            $eventInvite->save();
            /** Send Email */
            $this->mailService->send($team->email,'Event Invite','invite-event', $data);
        }
    }

    /**
     * Join Events
     */
    public function joinEvents($user, $event, $token,$eventJoinee)
    {
        $data = [];
        $data['message'] = Auth::user()->name . " has requested to join the event " . $event->name;
        $data['accept_href'] = url(route('event-join-accept', ['token' => $token]));
        $data['decline_href'] = url(route('event-join-decline', ['token' => $token]));

       $notification= Notification::create([
            'sender_user_id' =>Auth()->user()->id,
            'receiver_user_id' =>$user->id, 
            'title'  => "Event Join",
            'message' =>  $data['message'],
            'accept_href' => $data['accept_href'],
            'decline_href' =>  $data['decline_href'],
            'is_read' => 0
        ]);

        $eventJoinee->notification_id = $notification->id;
      
      

        /** Send Email */
        $this->mailService->send($user->email, 'Event Join', 'invite-event', $data);
    }
}
