<?php

namespace App\Http\Controllers\Scheduler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

/**
 * Services
 */
use App\Services\AlgoService;

class SchedulerController extends Controller
{
    
    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        AlgoService $algoService
    ) {
        $this->algoService = $algoService;
    }

    public function expireUserRewardPoints()
    {
        Log::info("expireUserRewardPoints starts here");

       // update reward for event creation
       $this->algoService->expireUserRewardPoints();

       Log::info("expireUserRewardPoints ends here");
    }

    public function updateUserRewardPoints()
    {
        Log::info("updateUserRewardPoints starts here");

        $this->algoService->updateUserRewardPoints();

        Log::info("updateUserRewardPoints ends here");
    }
}
