<?php

namespace App\Repositories\Interfaces;

/** Model */

use App\Event;

interface EventRepositoryInterface
{
    /**
     * Create a new Event
     * 
     * @param array $data         - [ key => value ]
     *
     * @return
     */
    public function create($data);

    /**
     * Update an existing Event
     * 
     * @param int   $id           - event.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Find an Event
     * 
     * @param int   $id           - event.id
     *
     * @return Event
     */
    public function find(int $id): Event;

    /**
     * Get current Events
     *
     * @return Collection
     */
    public function getCurrentEvents($limit = 3);

    /**
     * Get upcoming Events
     *
     * @return Collection
     */
    public function getUpcomingEvents($limit = 3);

    /**
     * Get all Events
     *
     * @return Collection
     */
    public function getAllEvents($limit = 10);

    /**
     * Find Events by Id
     *
     * @return Collection
     */
    public function findEventsById($id);

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findAllEventPlayers($id);

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findSingleEventPlayer($id);

    /**
     * Find All Events Players By Event Id with friends
     *
     * @return Collection
     */
    public function findAllEventPlayersWithFriends($id);

    /**
     * Find All Events Players By Event Id AND With Winners of the last event
     *
     * @return Collection
     */
    public function findAllEventPlayersWithLastWinners($id, $currentEventFixtureResult);

    /**
     * Find Champion By Event Id
     *
     * @return Collection
     */
    public function getEventChampion($id);

    /**
     * Get next match event details
     *
     * @return Collection
     */
    public function getNextMatchDetails($id);

    /**
     * Search Events
     */
    public function searchEvents($request);
}
