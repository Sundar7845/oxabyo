<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\FixtureServiceInterface;

use App\Repositories\EventPhaseRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\EventRepository;

/** Models */
use App\Phase;
use App\EventChampion;
use App\User;

class FixtureService implements FixtureServiceInterface
{
    /**
     * @var EventPhaseRepository
     */
    private $eventPhaseRepository;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var FixtureRepository
     */
    private $fixtureRepository;

    /**
     * @var AlgoService
     */
    private $algoService;

    /**
     * FixtureService constructor.
     *
     * @param EventPhaseRepository $eventPhaseRepository
     */
    public function __construct(
        EventPhaseRepository $eventPhaseRepository,
        FixtureRepository $fixtureRepository,
        EventRepository $eventRepository,
        AlgoService $algoService
    ) {
        $this->eventPhaseRepository = $eventPhaseRepository;
        $this->fixtureRepository = $fixtureRepository;
        $this->eventRepository = $eventRepository;
        $this->algoService = $algoService;
    }

    /**
     * Create a Fixture and Results
     * 
     * @param array $data
     * @param Request $request
     *
     * @return 
     */
    public function createFixture($data, $request)
    {
        // Construct fixture data
        $fixtureData = $this->constructFixtureData($data, $request);

        $fixture = $this->fixtureRepository->create($fixtureData);
        
        // Construct fixture result data
        $fixtureResultData = $this->constructFixtureResultData($fixture->id, $data);

        $this->fixtureRepository->createFixtureResult($fixtureResultData);

        return $fixture;
    }

    /**
     * Update a Fixture and Results
     * 
     * @param array $data
     * @param Request $request
     *
     * @return 
     */
    public function updateFixture($id, $data, $request)
    {
        // Construct fixture data
        $fixtureData = $this->constructFixtureData($data, $request);

        $fixture = $this->fixtureRepository->findAndUpdate($id, $fixtureData);
      
        $fixtureResultData = $this->constructFixtureResultData($id, $data);

        $findFixtureResult = $this->fixtureRepository->findFixtureResult($id);

        if ($findFixtureResult) {
            $this->fixtureRepository->findAndUpdateFixtureResult($id, $fixtureResultData);
        } else {
            $this->fixtureRepository->createFixtureResult($fixtureResultData);
        }

        return $fixture;
    }

    /**
     * Construct Fixture Data
     */
    public function constructFixtureData($data, $request)
    {
        return [
            'event_id'                  => $request->event_id, 
            'event_phase_id'            => $request->event_phase_id,
            'challenger1_id'            => $data['challenger1_id'],
            'challenger2_id'            => $data['challenger2_id'],
            'date'                      => $data['date'],
            'time'                      => $data['time']
        ];
    }

    /**
     * Construct Fixture Result Data
     */
    public function constructFixtureResultData($fixture_id, $data)
    {
        $status = null;
        $runner_id = null;
        $winner_id = null;

        if ($data['winner_id'] == $data['challenger1_id']) {
            $runner_id = $data['challenger2_id'];
            $winner_id = $data['challenger1_id'];
            $status = 'win';
        } else if ($data['winner_id'] == $data['challenger2_id']) {
            $runner_id = $data['challenger1_id'];
            $winner_id = $data['challenger2_id'];
            $status = 'win';
        }

        if ($data['winner_id'] == 'no-winner') {
            $status = 'no-winner';
        }      

        return [
            'fixture_id'                => $fixture_id, 
            'winner_id'                 => $winner_id,
            'runner_id'                 => $runner_id,
            'number_of_rounds_played'   => null,
            'status'                    => $status,
            'date'                      => now()
        ];
    }

    /**
     * Create a new EventPhase
     * 
     * @param Event $event
     *
     * @return 
     */
    public function createEventPhase($event)
    {
        $data = [];
        $phases = Phase::where('round', '<=', $event->number_of_rounds)
            ->when(! $event->is_champion_invite, function ($query) {
                return $query->where('key', '!=', 'super-final');
            })->get();
        $active_phase = 1;
        $match = 1;
        foreach ($phases as $phase) {
            $data[] = [
                'event_id' => $event->id,
                'phase_id' => $phase->id,
                'status' => 'not-started',
                'match' => $match,
                'active_phase' => $active_phase,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $active_phase = 0;
            $match = $match + 1;
        }
        return $this->eventPhaseRepository->insert($data);
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
        $fetchCurrentEventPhase =  $this->eventPhaseRepository->fetchCurrentEventPhase($id);

        if ($fetchCurrentEventPhase && $fetchCurrentEventPhase->action == 'Super Final') {
            $fetchCurrentEventPhase->match = 'SUPER FINAL'; 
            //echo $fetchCurrentEventPhase;exit;
        }
       
        return $fetchCurrentEventPhase;
    }

    /**
     * Fetch Fixture results
     * 
     * @param Event $event
     *
     * @return 
     */
    public function getFixtureResultById($event_id, $currentEventPhase)
    {
        if ( ! $currentEventPhase) {
            return [];
        }
        return $this->eventPhaseRepository->getFixtureResultById($event_id, $currentEventPhase->event_phase_id);
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
        return $this->eventPhaseRepository->fetchCompletedEventPhase($id);
    }

    public function updateNextPhase($phase_id, $event_id)
    {
        $isNotCompletedStatus = $this->eventPhaseRepository
            ->getNotCompletedFixtureResultById($phase_id, $event_id);

        if ( ! $isNotCompletedStatus) {
            $this->eventPhaseRepository->update($phase_id, [ 
                'status' => 'completed',
                'active_phase' => 0
            ]);

            // update performance results here
            // $this->algoService->setPerformancePoints($event_id, $phase_id);

            $phase =  $this->eventPhaseRepository->findOneByEventId($event_id);
            if ($phase) {
                $this->eventPhaseRepository->update($phase->id, [
                    'active_phase' => 1
                ]);
            }
        }  
        
        $phase =  $this->eventPhaseRepository->findOneByEventId($event_id);
        
        if ( ! $phase ) {
            // update final champion to the event

            $result = $this->eventRepository->findWinnerByEventId($event_id);

            $winner = User::find($result->id);
            // $runner = User::find($result->id);  
            
            // update performance results here
            $this->algoService->setPerformancePointsForFinalMatch($event_id);

            EventChampion::create([
                'event_id' => $event_id,
                'winner_id' => $winner->id ?? null,
             //   'runner_id' => $runner->id ?? null,
                'number_of_rounds_played' => 4,
                'date' => now()
            ]);
        }
    }

    /**
     * Switch winner
     */
    public function switchWinner($id)
    {
        $findFixtureResult = $this->fixtureRepository->findFixtureResult($id);

        if ($findFixtureResult) {
            $fixtureResultData = [
                'winner_id'                 => $findFixtureResult->runner_id,
                'runner_id'                 => $findFixtureResult->winner_id,
                'date'                      => now()
            ];
            $this->fixtureRepository->findAndUpdateFixtureResult($id, $fixtureResultData);
        }
    }

    public function getChampions()
    {
        return EventChampion::join('users','users.id','event_champions.winner_id')
            ->select('users.*')
            ->distinct('users.id')
            ->get();
    }
}
