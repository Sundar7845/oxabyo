<?php

namespace App\Repositories;

/* Interfaces */

use App\Repositories\Interfaces\EventRepositoryInterface;

/* Model */
use App\Event;
use App\User;
use App\EventPlayerDetail;
use App\Fixture;

class EventRepository implements EventRepositoryInterface
{
    /**
     * Create a new Event
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data)
    {
        return Event::create($data);
    }

    /**
     * Update an existing Event
     * 
     * @param int   $id           - event.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return Event::where('id', $id)->update($data);
    }

    /**
     * Find an Event
     * 
     * @param int   $id           - event.id
     *
     * @return Event
     */
    public function find(int $id): Event
    {
        return Event::find($id);
    }

    /**
     * Get current Events
     *
     * @return Collection
     */
    public function getCurrentEvents($limit = 3)
    {
        return Event::with(['player_types', 'games', 'event_types', 'organizer'])
            ->whereDate('match_date', now())
            ->oldest('match_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Get upcoming Events
     *
     * @return Collection
     */
    public function getUpcomingEvents($limit = 3)
    {
        return Event::with(['player_types', 'games', 'event_types'])
            ->where('match_date', '>', now())
            ->latest('match_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all Events
     *
     * @return Collection
     */
    public function getAllEvents($limit = 10)
    {
        return Event::with(['player_types', 'games', 'event_types'])
            ->get();
    }

    /**
     * Find Events by Id
     *
     * @return Collection
     */
    public function findEventsById($id)
    {
        return Event::with(['player_types', 'games', 'event_types'])
        ->where('id', $id)        
        ->first();
    }

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findAllEventPlayers($id)
    {
        return EventPlayerDetail::with([
                'live_comments', 'live_comments.comments', 'live_comments.user', 'players.twitch'
            ])->join('users', 'users.id', 'event_player_details.user_id')
            ->leftjoin('event_player_teams', 'event_player_teams.id', 'event_player_details.event_player_team_id')
            ->leftjoin('teams', 'teams.id', 'event_player_teams.team_id')
            ->where('event_player_details.event_id', $id)
            ->select('*', 'users.id as id','users.name as name', 'teams.name as team_name', 'event_player_details.id as player_id')
            ->get();
    }

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findSingleEventPlayer($id)
    {
        return EventPlayerDetail::join('users', 'users.id', 'event_player_details.user_id')
            ->where('event_player_details.event_id', $id)
            ->first();
    }

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findAllEventPlayersWithFriends($id)
    {
        return User::with(['friends'])->join('event_player_details', 'event_player_details.user_id', 'users.id')
            ->leftjoin('event_player_teams', 'event_player_teams.id', 'event_player_details.event_player_team_id')
            ->leftjoin('teams', 'teams.id', 'event_player_teams.team_id')
            ->where('event_player_details.event_id', $id)
            ->select('*', 'users.name as user_name', 'event_player_details.id as event_player_id', 'users.id as cust_user_id')
            ->get();
    }

    /**
     * Find All Events Players By Event Id AND With Winners of the last event
     *
     * @return Collection
     */
    public function findAllEventPlayersWithLastWinners($id, $completedEventPhase)
    {
        $lastCompletedEventPhase = count($completedEventPhase) > 0 ?
            $completedEventPhase[count($completedEventPhase) - 1] : 0;
        if ($lastCompletedEventPhase && $lastCompletedEventPhase->id) {
            $lastCompletedEventPhase = $lastCompletedEventPhase->id;
        }

        $merged = User::join('event_player_details', 'event_player_details.user_id', 'users.id')
        ->leftjoin('event_player_teams', 'event_player_teams.id', 'event_player_details.event_player_team_id')
        ->leftjoin('teams', 'teams.id', 'event_player_teams.team_id')
        ->when($lastCompletedEventPhase, function ($query) use ($lastCompletedEventPhase) {
            $query->join('fixtures', function ($join) use ($lastCompletedEventPhase) {
                $join->on('fixtures.event_id',  'event_player_details.event_id');
                $join->where('fixtures.event_phase_id', '=', $lastCompletedEventPhase);
            })
            ->join('fixture_results', function ($join) {
                $join->on('fixture_results.fixture_id', '=', 'fixtures.id');
                $join->on('fixture_results.winner_id', '=', 'event_player_details.id');
            });
        })
        ->where('event_player_details.event_id', $id)
        ->select('*', 'users.name as user_name', 'event_player_details.id as event_player_id')
        ->groupBy('event_player_details.id')
        ->get();

        /**
         * Super final round
         * 
         */
         $latest = User::join('event_player_details', 'event_player_details.user_id', 'users.id')
         ->leftjoin('event_player_teams', 'event_player_teams.id', 'event_player_details.event_player_team_id')
         ->leftjoin('teams', 'teams.id', 'event_player_teams.team_id')     
         ->where('event_player_details.event_id', $id)
         ->select('*', 'users.name as user_name', 'event_player_details.id as event_player_id')
         ->where('is_champion', 1)
         ->groupBy('event_player_details.id')
         ->get();      
          
        if (count($latest)>0) {
            $merged = $merged->merge($latest);
        }

        return $merged;
    }

    /**
     * Find WinnerWinners of the event
     *
     * @return Collection
     */
    public function findWinnerByEventId($id)
    {
        return User::join('event_player_details', 'event_player_details.user_id', 'users.id')
            ->join('fixtures', 'fixtures.event_id',  'event_player_details.event_id')
            ->join('fixture_results', function ($join) {
                $join->on('fixture_results.fixture_id', '=', 'fixtures.id');
                $join->on('fixture_results.winner_id', '=', 'event_player_details.id');
            })  
            ->where('event_player_details.event_id', $id)
            ->select('users.*')
            ->latest('fixtures.created_at')
            ->first();
    }

    /**
     * Find Loser of the event
     *
     * @return Collection
     */
    public function findLooserByEventId($id)
    {
        return User::join('event_player_details', 'event_player_details.user_id', 'users.id')
            ->join('fixtures', 'fixtures.event_id',  'event_player_details.event_id')
            ->join('fixture_results', function ($join) {
                $join->on('fixture_results.fixture_id', '=', 'fixtures.id');
                $join->on('fixture_results.looser_id', '=', 'event_player_details.id');
            })  
            ->where('event_player_details.event_id', $id)
            ->select('users.*')
            ->latest('fixtures.created_at')
            ->first();
    }

    /**
     * Find Champion By Event Id
     *
     * @return Collection
     */
    public function getEventChampion($id)
    {
        return EventPlayerDetail::join('users', 'users.id', 'event_player_details.user_id')
            ->where('event_player_details.event_id', $id)
            ->where('is_champion', 1)
            ->first();
    }

    /**
     * Get next match event details
     *
     * @return Collection
     */
    public function getNextMatchDetails($id)
    {            
        return Fixture::with(['challenger1.players', 'challenger2.players', 'challenger2.players.twitch'])
            ->join('fixture_results', 'fixture_results.fixture_id', 'fixtures.id') 
            ->where('event_id', $id)
            ->whereNull('fixture_results.status')
            ->select('*', 'fixtures.date as fixture_date')
            ->oldest('fixtures.created_at')
            ->first();
    }

    /**
     * Search Events
     */
    public function searchEvents($request)
    {
        $event_name = $request->event_name ?? $request->name;
        $event_organizer_name = $request->event_organizer_name;
        $event_games = $request->event_games;
        $event_date_from = $request->event_date_from;
        $event_date_to = $request->event_date_to;
        $event_ticket_from = $request->event_ticket_from;
        $event_ticket_to = $request->event_ticket_to;
        $event_prize_money_from = $request->event_prize_money_from;
        $event_prize_money_to = $request->event_prize_money_to;
        $oxarate_min = $request->oxarate_min;
        $oxarate_max = $request->oxarate_max;
        $performance_rating_min = $request->performance_rating_min;
        $performance_rating_max = $request->performance_rating_max;
        $ynfluence_rating_min = $request->ynfluence_rating_min;
        $ynfluence_rating_max = $request->ynfluence_rating_max;
        $monetization_rating_min = $request->monetization_rating_min;
        $monetization_rating_max = $request->monetization_rating_max; 
        $event_challenge_round_type = $request->event_challenge_round_type;
        $event_one_shot_type = $request->event_one_shot_type;
        $event_play_off_type = $request->event_play_off_type;
        $event_single_player_type = $request->event_single_player_type;
        $event_created_by = $request->event_created_by && $request->event_created_by != 'false' ? $request->event_created_by : null;
        $event_joined_by = $request->event_joined_by && $request->event_joined_by != 'false' ? $request->event_joined_by : null;
        $free_events_only = $request->free_events_only;

        return Event::with(['player_types', 'games', 'event_types'])
            ->when($event_name, function ($query, $event_name) {
                return $query->where('name', 'like', '%' . $event_name . '%');
            })
            ->when($event_organizer_name, function ($query, $event_organizer_name) {
                return $query->join('users', 'users.id', 'events.organizer_id')
                    ->where('users.name', 'like', '%' . $event_organizer_name . '%');
            })
            ->when($event_games, function ($query, $event_games) {
                return $query->whereHas('games', function ($query) use ($event_games) {
                    $query->where('games.id', $event_games);
                });
            })
            ->when($event_date_from, function ($query, $event_date_from) {
                return $query->where('match_date', '>=' , $event_date_from);
            })
            ->when($event_date_to, function ($query, $event_date_to) {
                return $query->where('match_date', '<=' , $event_date_to);
            })
            ->when($event_ticket_from, function ($query, $event_ticket_from) {
                return $query->where('ticket', '>=' , $event_ticket_from);
            })
            ->when($event_ticket_to, function ($query, $event_ticket_to) {
                return $query->where('ticket', '<=' , $event_ticket_to);
            })
            ->when($event_prize_money_from, function ($query, $event_prize_money_from) {
                return $query->where('prize_money', '>=' , $event_prize_money_from);
            })
            ->when($event_prize_money_to, function ($query, $event_prize_money_to) {
                return $query->where('prize_money', '<=' , $event_prize_money_to);
            })
            ->when($free_events_only, function ($query) {
                return $query->where('ticket', '0')->orWhereNull('ticket');
            })
            ->when($oxarate_min, function ($query, $oxarate_min) {
                return $query->where('oxarate_min', '>=' , $oxarate_min);
            })
            ->when($oxarate_max, function ($query, $oxarate_max) {
                return $query->where('oxarate_min', '<=' , $oxarate_max);
            })
            ->when($performance_rating_min, function ($query, $performance_rating_min) {
                return $query->where('performance_rating_min', '>=' , $performance_rating_min);
            })
            ->when($performance_rating_max, function ($query, $performance_rating_max) {
                return $query->where('performance_rating_min', '<=' , $performance_rating_max);
            })
            ->when($ynfluence_rating_min, function ($query, $ynfluence_rating_min) {
                return $query->where('ynfluence_rating_min', '>=' , $ynfluence_rating_min);
            })
            ->when($ynfluence_rating_max, function ($query, $ynfluence_rating_max) {
                return $query->where('ynfluence_rating_min', '<=' , $ynfluence_rating_max);
            })
            ->when($monetization_rating_min, function ($query, $monetization_rating_min) {
                return $query->where('monetization_rating_min', '>=' , $monetization_rating_min);
            })
            ->when($monetization_rating_max, function ($query, $monetization_rating_max) {
                return $query->where('ynfluence_rating_min', '<=' , $monetization_rating_max);
            })
            ->when($event_challenge_round_type, function ($query) {
                return $query->orWhereHas('event_types', function ($query)  {
                    $query->where('event_types.name','Challenge Round');
                });
            })
            ->when($event_one_shot_type, function ($query) {
                return $query->orWhereHas('event_types', function ($query)  {
                    $query->where('event_types.name','One shot');
                });
            })
            ->when($event_play_off_type, function ($query) {
                return $query->orWhereHas('event_types', function ($query)  {
                    $query->where('event_types.name','Playoff');
                });
            })
            ->when($event_single_player_type, function ($query) {
                return $query->orWhereHas('event_types', function ($query)  {
                    $query->where('event_types.name','Single Player');
                });
            })
            ->when($event_created_by, function ($query) {
                return $query->where('organizer_id', auth()->id());
            })
            ->when($event_joined_by, function ($query) {
                return $query->whereHas('event_players', function ($query)  {
                    $query->where('event_player_details.user_id',auth()->id());
                });
            })
            ->get();
    }
}
