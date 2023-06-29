<?php

namespace App\Services;

/* Interfaces */

use App\Services\Interfaces\UserInteractionServiceInterface;

/* Services */
use App\Services\FileService;
use App\Services\AlgoService;

/* Repository */
use App\Repositories\UserFriendRepository;

/* Model */
use App\User;
use App\EventChampion;

class UserInteractionService implements UserInteractionServiceInterface
{
    /**
     * @var UserFriendRepository
     */
    private $userFriendRepository;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var AlgoService
     */
    private $algoService;

    /**
     * UserInteractionService constructor.
     *
     * @param UserFriendRepository $userFriendRepository
     */
    public function __construct(
        UserFriendRepository $userFriendRepository,
        FileService $fileService,
        AlgoService $algoService
    ) {
        $this->userFriendRepository = $userFriendRepository;
        $this->fileService = $fileService;
        $this->algoService = $algoService;
    }

    /**
     * Get All User Friends
     * 
     *
     * @return
     */
    public function getAllUserFriends()
    {
        return $this->userFriendRepository->getAllUserFriends();
    }

    /**
     * Get All E-Player List
     * 
     *
     * @return
     */
    public function getAllEPlayerList($search = '', $request)
    {
        $players = User::with(['friends']);

        if ($search) {
            $players = $players->where('name', 'LIKE', "%$search%");
        }

        if ($request->player_friends_only) {
            $players = $players->whereHas('friends', function ($query) {
                $query->where('user_friends.user_id', auth()->user()->id)
                    ->where('is_connected', 1);
            });
        }

        $players =  $players->where('users.id', '!=', Auth()->user()->id)
            ->where('users.user_role_id', '!=', '1')
            ->orderBy('users.name', 'ASC')
            ->get();

        // Fetch heighest score from the user
        $performanceScore = $this->algoService->fetchHeighestPerformanceScore();
        $socialScore = $this->algoService->fetchHeighestSocialScore();
        $monetizationScore = $this->algoService->fetchHeighestMonetizationScore();

        foreach ($players as $player) {
            if ($player->profile_image) {
                $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
            }
            $player->wins = EventChampion::where('winner_id', $player->id)->count();
            $player->performance =  $this->algoService->calculatePerformanceScore($performanceScore, 1, $player->id);
            $player->social = $this->algoService->calculatePerformanceScore($socialScore, 2, $player->id);
            $player->monetization = $this->algoService->calculatePerformanceScore($monetizationScore, 3, $player->id);
            $player->oxarate = ceil(($player->performance + $player->social + $player->monetization) / 3);
        }

        return $players->sort(function ($a, $b) {
            return $a->oxarate < $b->oxarate;
        });
    }
}
