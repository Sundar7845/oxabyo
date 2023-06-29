<?php

namespace App\Services\Interfaces;

interface FixtureServiceInterface
{
    /**
     * Create a new EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function createEventPhase($event);

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
     * Create a Fixture and Results
     * 
     * @param array $data
     * @param Request $request
     *
     * @return 
     */
    public function createFixture($data, $request);

    /**
     * Construct Fixture Data
     */
    public function constructFixtureData($data, $request);

    /**
     * Construct Fixture Result Data
     */
    public function constructFixtureResultData($fixture_id, $data);

    /**
     * Fetch Fixture results
     * 
     * @param Event $event
     *
     * @return 
     */
    public function getFixtureResultById($event_id, $currentEventPhase);

    public function updateNextPhase($phase_id, $event_id);

    public function switchWinner($id);
}
