<?php

namespace App\Services;

use Illuminate\Http\Request;

/* Interfaces */
use App\Services\Interfaces\EventServiceInterface;

/* Repository */
use App\Repositories\EventRepository;

/* Model */
use App\Event;

class EventService implements EventServiceInterface
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * EventService constructor.
     *
     * @param EventRepository              $eventRepository
     */
    public function __construct(
        EventRepository $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Create a new Event
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data)
    {
        return $this->eventRepository->create($data);
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
        return $this->eventRepository->update($id,$data);
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
        return $this->eventRepository->find($id);
    }

    /**
     * Get current Events
     *
     * @return Collection
     */
    public function getCurrentEvents($limit = 3)
    {
        return $this->eventRepository->getCurrentEvents($limit);
    }

    /**
     * Get upcoming Events
     *
     * @return Collection
     */
    public function getUpcomingEvents($limit = 3)
    {
        return $this->eventRepository->getUpcomingEvents($limit);
    }

    /**
     * Get all Events
     *
     * @return Collection
     */
    public function getAllEvents($limit = 10)
    {
        return $this->eventRepository->getAllEvents($limit);
    }

    /**
     * Find Events by Id
     *
     * @return Collection
     */
    public function findEventsById($id)
    {
        return $this->eventRepository->findEventsById($id);
    }

    /**
     * Find All Events Players By Event Id
     *
     * @return Collection
     */
    public function findAllEventPlayers($id)
    {
        return $this->eventRepository->findAllEventPlayers($id);
    }

    /**
     * Find Single Events Players By Event Id
     *
     * @return Collection
     */
    public function findSingleEventPlayer($id)
    {
        return $this->eventRepository->findSingleEventPlayer($id);
    }

    /**
     * Find All Events Players By Event Id with friends
     *
     * @return Collection
     */
    public function findAllEventPlayersWithFriends($id)
    {
        return $this->eventRepository->findAllEventPlayersWithFriends($id);
    }

    /**
     * Find All Events Players By Event Id AND With Winners of the last event
     *
     * @return Collection
     */
    public function findAllEventPlayersWithLastWinners($id, $completedEventPhase)
    {
        return $this->eventRepository->findAllEventPlayersWithLastWinners($id, $completedEventPhase);
    }

    /**
     * Find Single Events Players By Event Id
     *
     * @return Collection
     */
    public function getEventChampion($id)
    {
        return $this->eventRepository->getEventChampion($id);
    }

    /**
     * Get next match event details
     *
     * @return Collection
     */
    public function getNextMatchDetails($id)
    {
        return $this->eventRepository->getNextMatchDetails($id);
    }

    /**
     * Search Events
     * 
     */
    public function searchEvents(Request $request)
    {
        return $this->eventRepository->searchEvents($request);
    }
}
