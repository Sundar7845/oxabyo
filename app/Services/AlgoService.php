<?php

namespace App\Services;

use Carbon\Carbon;

/** Models */

use App\User;
use App\Event;
use App\RewardType;
use App\UserRewardPoint;
use App\UserRewardPointHistory;
use App\EventPointMapping;
use App\Phase;

use App\Repositories\EventPhaseRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\EventRepository;

/* Interfaces */
use App\Services\Interfaces\AlgoServiceInterface;
use App\UserFriend;

class AlgoService implements AlgoServiceInterface
{

    /**
     * @var EventPhaseRepository
     */
    private $eventPhaseRepository;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(
        EventPhaseRepository $eventPhaseRepository,
        EventRepository $eventRepository
    ) {
        $this->eventPhaseRepository = $eventPhaseRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * Set performance points for events
     */
    public function setPerformancePointsForFinalMatch($eventId)
    {
        //Fetch event phase fixture users
        $event = $this->eventRepository->findEventsById($eventId);

        $eventPhases = $this->eventPhaseRepository->fetchCompletedEventPhase($eventId);

        $eventPointMappings = EventPointMapping::where('reward_type_id', '1')
            ->where('is_active', 1)
            ->get();

        foreach ($eventPhases as $eventPhase) {

            foreach ($eventPhase->fixtures as $fixture) {
                // Event participation
                $eventPointMapping = $eventPointMappings->where('key', 'event_partecipation')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($fixture->challenger1->players->id, $eventId, $eventPointMapping, $fixture);
                }

                // Event participation
                $eventPointMapping = $eventPointMappings->where('key', 'event_partecipation')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($fixture->challenger2->players->id, $eventId, $eventPointMapping, $fixture);
                }

                if ($event->ticket > 0) {
                    $this->updateRewardPointsForMonetization($fixture->challenger1->players->id, 'pay_event_partecipations');
                }

                if ($event->ticket > 0) {
                    $this->updateRewardPointsForMonetization($fixture->challenger2->players->id, 'pay_event_partecipations');
                }

                // victory_1_match
                $eventPointMapping = $eventPointMappings->where('key', 'victory_1_match')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($fixture->fixture_results->winner->players->id, $eventId, $eventPointMapping, $fixture);
                }

                // victory_1_match
                $eventPointMapping = $eventPointMappings->where('key', 'victory_1_match')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($fixture->fixture_results->winner->players->id, $eventId, $eventPointMapping, $fixture);
                }

                // no_victories
                $eventPointMapping = $eventPointMappings->where('key', 'no_victories')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($fixture->fixture_results->looser->players->id, $eventId, $eventPointMapping, $fixture);
                }

                // update bonus and minus points
                $this->updateBonusAndMinusPoints($fixture, $eventId, $eventPointMappings);
            }
        }

        // Update the points to the event positions

        $this->updatePositionForEvents($eventId);

        // update the points to the winner - win_event_without_loss
        $winner = $this->eventRepository->findWinnerByEventId($eventId);
        $eventPointMapping = $eventPointMappings->where('key', 'win_event_without_loss')->first();
        if ($eventPointMapping && $winner) {
            $this->updateRewardPoints($winner->id, $eventId, $eventPointMapping, $fixture);
        }



        // update prize_money
        if ($event->prize_money > 0) {
            $this->updateRewardPointsForMonetization($winner->id, 'win_a_prize');
        }

        // do_not_partecipate // after joined to the event
    }


    public function updateRewardPoints($userId, $eventId, $eventPointMapping, $fixture)
    {

        $userRewardPoint = UserRewardPoint::updateOrCreate([
            'user_id' => $userId,
            'reward_type_id' => 1
        ]);

        $points = $userRewardPoint->points + $eventPointMapping->points;

        if ($points >= 0) {
            $userRewardPoint->points = $points;
        } else if ($points < 0) {
            $userRewardPoint->points = 0;
        }
        $userRewardPoint->save();

        $userRewardPointHistory = UserRewardPointHistory::updateOrCreate([

            'user_id' => $userId,
            'event_id' => $eventId,
            'reward_type_id' => 1,
            'event_point_mapping_id' => $eventPointMapping->id,
            'event_phase_id' => $fixture->event_phase_id,
            'fixture_id' => $fixture->id,
            'points' => $eventPointMapping->points,
            'status' => 'active'

        ]);
        $userRewardPointHistory->save();
    }

    public function updateBonusAndMinusPoints($fixture, $eventId, $eventPointMappings)
    {
        $winner = $fixture->fixture_results->winner->players;
        $loser = $fixture->fixture_results->looser->players;

        // Get points
        $winnerPoint = UserRewardPoint::where('user_id', $winner->id)->first();
        $loserPoint = UserRewardPoint::where('user_id', $loser->id)->first();

        if ($winnerPoint && $loserPoint) {

            if ($loserPoint->points > $winnerPoint->points) {

                $eventPointMapping = $eventPointMappings->where('key', 'win_vs_higher_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($winner->id, $eventId, $eventPointMapping, $fixture);
                }
            } else if ($loserPoint->points < $winnerPoint->points) {

                $eventPointMapping = $eventPointMappings->where('key', 'win_vs_lower_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($winner->id, $eventId, $eventPointMapping, $fixture);
                }
            } else {
                $eventPointMapping = $eventPointMappings->where('key', 'win_vs_same_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($winner->id, $eventId, $eventPointMapping, $fixture);
                }
            }

            if ($winnerPoint->points > $loserPoint->points) {
                $eventPointMapping = $eventPointMappings->where('key', 'loss_vs_higher_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($loser->id, $eventId, $eventPointMapping, $fixture);
                }
            } else if ($winnerPoint->points < $loserPoint->points) {
                $eventPointMapping = $eventPointMappings->where('key', 'loss_vs_lower_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($loser->id, $eventId, $eventPointMapping, $fixture);
                }
            } else {
                $eventPointMapping = $eventPointMappings->where('key', 'loss_vs_same_level_player')->first();
                if ($eventPointMapping) {
                    $this->updateRewardPoints($loser->id, $eventId, $eventPointMapping, $fixture);
                }
            }
        }
    }

    public function updatePositionForEvents($eventId)
    {
        $event = $this->eventRepository->findEventsById($eventId);

        $eventPhases = $this->eventPhaseRepository->fetchCompletedEventPhaseByLatest($eventId);

        $i = 1;

        $positionUserId = [
            '1st_position' => [],
            '2nd_position' => [],
            '3rd_position' => [],
            '4th_position' => [],
            '5th_position' => [],
            '6th_position' => [],
            '7th_position' => [],
            '8th_position' => [],
            '9th_to_16th_position' => []
        ];

        $defaultPositions = [
            0 => [],
            1 => ["1st_position", "2nd_position"],
            2 => ["3rd_position", "4th_position"],
            3 => ["5th_position", "6th_position", "7th_position", "8th_position"],
            4 => ["9th_to_16th_position"],
            5 => []
        ];

        // Construct Positions
        $constructPositions = [];

        $phases = Phase::where('round', '<=', $event->number_of_rounds)->get();

        foreach ($phases as $phase) {
            $constructPositions[] = $defaultPositions[$phase->round];
        }

        // first update the positions of the users
        foreach ($eventPhases as $eventPhase) {
            foreach ($eventPhase->fixtures as $fixture) {
                foreach ($constructPositions[$i] as $pos => $posVal) {
                    if ($posVal == '1st_position') {
                        array_push($positionUserId['1st_position'], [
                            "user_id" => $fixture->fixture_results->winner->players->id,
                            "fixture" => $fixture,
                            "position" => $posVal
                        ]);
                    } else {
                        array_push($positionUserId[$posVal], [
                            "user_id" => $fixture->fixture_results->looser->players->id,
                            "fixture" => $fixture,
                            "position" => $posVal
                        ]);
                    }
                }
            }
            $i++;
        }

        $this->allocatePointsToPositions($positionUserId, $eventId);
    }

    public function allocatePointsToPositions($positionUserId, $eventId)
    {
        $eventPointMappings = EventPointMapping::where('reward_type_id', '1')
            ->where('is_active', 1)
            ->get();

        $eventPositions = [
            '1st_position' => $eventPointMappings->where('key', '1st_position')->first(),
            '2nd_position' => $eventPointMappings->where('key', '2nd_position')->first(),
            '3rd_position' => $eventPointMappings->where('key', '3rd_position')->first(),
            '4th_position' => $eventPointMappings->where('key', '4th_position')->first(),
            '5th_position' => $eventPointMappings->where('key', '5th_position')->first(),
            '6th_position' => $eventPointMappings->where('key', '6th_position')->first(),
            '7th_position' => $eventPointMappings->where('key', '7th_position')->first(),
            '8th_position' => $eventPointMappings->where('key', '8th_position')->first(),
            '9th_to_16th_position' => $eventPointMappings->where('key', '9th_to_16th_position')->first()
        ];

        foreach ($positionUserId as $key => $positionUser) {
            if (count($positionUser) > 0) {
                foreach ($positionUser as $user) {
                    if (isset($eventPositions[$user['position']])) {
                        $this->updateRewardPoints($user['user_id'], $eventId, $eventPositions[$user['position']], $user['fixture']);
                    }
                }
            }
        }
    }

    public function updateRewardPointsForSocial($userId, $type)
    {
        $eventPointMapping = EventPointMapping::where('reward_type_id', '2')
            ->where('key', $type)
            ->where('is_active', 1)
            ->first();
        if ($eventPointMapping) {
            $userRewardPoint = UserRewardPoint::updateOrCreate([
                'user_id' => $userId,
                'reward_type_id' => 2
            ]);
            $points = $userRewardPoint->points + $eventPointMapping->points;
            if ($points >= 0) {
                $userRewardPoint->points = $points;
            } else if ($points < 0) {
                $userRewardPoint->points = 0;
            }
            $userRewardPoint->save();
            $userRewardPointHistory = UserRewardPointHistory::updateOrCreate([
                'user_id' => $userId,
                'reward_type_id' => 2,
                'event_point_mapping_id' => $eventPointMapping->id,
                'points' => $eventPointMapping->points,
                'status' => 'active'
            ]);
            $userRewardPointHistory->save();
        }
    }

    /**
     * Update reward points for monetization
     */
    public function updateRewardPointsForMonetization($userId, $type)
    {
        $eventPointMapping = EventPointMapping::where('reward_type_id', '3')
            ->where('key', $type)
            ->where('is_active', 1)
            ->first();
        if ($eventPointMapping) {
            $userRewardPoint = UserRewardPoint::updateOrCreate([
                'user_id' => $userId,
                'reward_type_id' => 3
            ]);
            $points = $userRewardPoint->points + $eventPointMapping->points;
            if ($points >= 0) {
                $userRewardPoint->points = $points;
            } else if ($points < 0) {
                $userRewardPoint->points = 0;
            }
            $userRewardPoint->save();
            $userRewardPointHistory = UserRewardPointHistory::updateOrCreate([
                'user_id' => $userId,
                'reward_type_id' => 3,
                'event_point_mapping_id' => $eventPointMapping->id,
                'points' => $eventPointMapping->points,
                'status' => 'active'
            ]);
            $userRewardPointHistory->save();
        }
    }

    public function fetchHeighestPerformanceScore()
    {
        return UserRewardPoint::where('reward_type_id', 1)->orderBy('points', 'DESC')->first()->points ?? 0;
    }

    public function fetchHeighestSocialScore()
    {
        return UserRewardPoint::where('reward_type_id', 2)->orderBy('points', 'DESC')->first()->points ?? 0;
    }

    public function fetchHeighestMonetizationScore()
    {
        return UserRewardPoint::where('reward_type_id', 3)->orderBy('points', 'DESC')->first()->points ?? 0;
    }

    public function calculatePerformanceScore($maxPoints, $rewardTypeId, $userId)
    {
        if (!$maxPoints) {
            return 0;
        }

        $currentUserPoint = UserRewardPoint::where('reward_type_id', $rewardTypeId)
            ->where('user_id', $userId)
            ->first();

        if (!$currentUserPoint) {
            return 0;
        }

        return ceil(($currentUserPoint->points / $maxPoints) * 100);
    }

    /**
     * Expire user reward points
     */
    public function expireUserRewardPoints()
    {
        $date = Carbon::now()->subYear();

        $userRewardPointHistorys = UserRewardPointHistory::whereDate('created_at', '<=', $date)
            ->where('status', 'active')
            ->get();

        foreach ($userRewardPointHistorys as $userRewardPointHistory) {

            if ($userRewardPointHistory->points > 0) {

                $userRewardPoint = UserRewardPoint::updateOrCreate([
                    'user_id' => $userRewardPointHistory->user_id,
                    'reward_type_id' => $userRewardPointHistory->reward_type_id
                ]);
                $points = $userRewardPoint->points - $userRewardPointHistory->points;
                if ($points >= 0) {
                    $userRewardPoint->points = $points;
                } else if ($points < 0) {
                    $userRewardPoint->points = 0;
                }
                $userRewardPoint->save();

                $userRewardPointHistory->status = 'expired';
                $userRewardPointHistory->expired_at = now();
                $userRewardPointHistory->is_active = 0;
                $userRewardPointHistory->save();

                $userRewardPointHistory = UserRewardPointHistory::updateOrCreate([
                    'parent_id' => $userRewardPointHistory->id,
                    'user_id' => $userRewardPointHistory->user_id,
                    'reward_type_id' => $userRewardPointHistory->reward_type_id,
                    'event_point_mapping_id' => $userRewardPointHistory->event_point_mapping_id,
                    'points' => '-' . $userRewardPointHistory->points,
                    'status' => 'expired',
                    'expired_at' => now(),
                    'is_active' => 0
                ]);
                $userRewardPointHistory->save();
            }
        }
    }

    /**
     * Update user reward points
     */
    public function updateUserRewardPoints()
    {
        $date = Carbon::now()->subWeek();

        // User not logged for a week 
        $users = User::whereDate('last_logged_in_date', '<=', $date)
            ->get();
        foreach ($users as $user) {
            // update reward for event creation
            $this->updateRewardPointsForSocial($user->id, 'not_logged_for_a_week');
        }

        $userFriends = User::leftjoin('user_friends', 'user_friends.user_id', 'users.id')
            ->leftjoin('user_friend_actions', 'user_friend_actions.user_friend_id', 'user_friends.id')
            ->leftjoin('user_actions', 'user_actions.id', 'user_friend_actions.user_action_id')
            ->where('user_friend_actions.date', '>', $date)
            ->where('user_friends.is_like', 1)
            ->where('user_actions.key', 'like')
            ->select('user_friends.*')
            ->groupBy('users.id')
            ->get();

        // User not getting likes
        foreach ($userFriends as $userFriend) {
            // update reward for event creation
            $this->updateRewardPointsForSocial($userFriend->user_id, 'no_likes_for_a_week');
        }
    }
}
