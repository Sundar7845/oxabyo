<?php

namespace App\Repositories\Interfaces;

interface EventPhaseRepositoryInterface
{
    /**
     * Create a new EventPhase
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data);

    /**
     * Insert many EventPhases
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function insert($data);

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function find($id);

        /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function update($id, $data);

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCurrentEventPhase($id);

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCompletedEventPhase($id);

    /**
     * Get fixture result by event id and phase id
     * 
     */
    public function getFixtureResultById($event_id, $phase_id);

    /**
     * Get fixture result by event id and phase id
     * 
     */
    public function getNotCompletedFixtureResultById($phase_id, $event_id);

        /**
     * Fetch one by Event Id
     * 
     * @param Event $event
     *
     * @return 
     */
    public function findOneByEventId($event_id);

    /**
     * Fetch current EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function fetchCompletedEventPhaseByLatest($id);
}
