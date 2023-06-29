<?php

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\EventPhaseRepositoryInterface;

/** Model */
use App\EventPhase;
use App\Fixture;

class EventPhaseRepository implements EventPhaseRepositoryInterface
{
    /**
     * Create a new EventPhase
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data)
    {
        return EventPhase::create($data);
    }

    /**
     * Insert many EventPhases
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function insert($data)
    {
        return EventPhase::insert($data);
    }

    
    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function find($id)
    {
        return EventPhase::find($id);
    }

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function update($id, $data)
    {
        return EventPhase::find($id)->update($data);
    }

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCurrentEventPhase($id)
    {
        return EventPhase::join('phases', 'phases.id', 'event_phases.phase_id')
            ->where('event_id', $id)
            ->where('active_phase', 1)
            ->select('*', 'event_phases.id as event_phase_id')
            ->first();
    }

    /**
     * Get fixture result by event id and phase id
     * 
     */
    public function getFixtureResultById($event_id, $phase_id)
    {
        return Fixture::with(['fixture_results', 
            'challenger1.players',  
            'challenger2.players'
            ])
            ->where([
                'event_id' => $event_id, 
                'event_phase_id' => $phase_id
            ])
            ->get();
    }

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCompletedEventPhase($id)
    {
        return EventPhase::with([
                'phases', 
                'fixtures', 
                'fixtures.fixture_results', 
                'fixtures.challenger1.players',  
                'fixtures.challenger2.players',  
                'fixtures.fixture_results.winner.players',
                'fixtures.fixture_results.looser.players'
                
            ])->where('event_id', $id)
            ->where('status', 'completed')
            ->oldest('event_phases.created_at')
            ->get();
    }

    /**
     * Get fixture result by event id and phase id
     * 
     */
    public function getNotCompletedFixtureResultById($phase_id, $event_id)
    {
        return Fixture::with(['fixture_results'])
            ->whereHas('fixture_results', function ($query) {
                $query->whereNull('status');
            })
            ->where([
                'event_id' => $event_id, 
                'event_phase_id' => $phase_id
            ])
            ->count();
    }

    /**
     * Fetch one by Event Id
     * 
     * @param Event $event
     *
     * @return 
     */
    public function findOneByEventId($event_id)
    {
        return EventPhase::where('event_id',$event_id)
            ->where('status', 'not-started')
            ->orderBy('id', 'ASC')->first();
    }

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCompletedEventPhaseByLatest($id)
    {
        return EventPhase::with([
                'phases', 
                'fixtures', 
                'fixtures.fixture_results', 
                'fixtures.challenger1.players',  
                'fixtures.challenger2.players',  
                'fixtures.fixture_results.winner.players',
                'fixtures.fixture_results.looser.players'
                
            ])->where('event_id', $id)
            ->where('status', 'completed')
            ->latest('event_phases.created_at')
            ->get();
    }
}
