<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

/* Services */
use App\Services\FixtureService;
use App\Services\FileService;

class FixtureController extends Controller
{

    /**
     * @var FixtureService
     */
    private $fixtureService;

    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(
        FixtureService $fixtureService,
        FileService $fileService
    ) {
        $this->fixtureService = $fixtureService;
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $calenderMatchArray = $request->calender_match;

        foreach ((array) $calenderMatchArray as $calenderMatchData)
        {
            if ($calenderMatchData['edit_id']) {
                //update logic here
                $this->fixtureService->updateFixture(
                    $calenderMatchData['edit_id'],
                    $calenderMatchData, 
                    $request
                );
            } else {
                //store new logic here
                $this->fixtureService->createFixture($calenderMatchData, $request);
            }
        }

        // Check if all completed the matches in current phase, update the new phase and mark the current phase as completed
        
        $this->fixtureService->updateNextPhase($request->event_phase_id, $request->event_id);

        // LATER STORE FINAL WINNER TO WINNERS TABLE...
        return redirect()->back()->with('success', 'Match information is updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function switchWinner($id, $event_id)
    {
        $this->fixtureService->switchWinner($id);

        // $completedEventPhase = $this->fixtureService->fetchCompletedEventPhase($event_id);

        // foreach ($completedEventPhase as $completedPhase) {
        //     foreach ($completedPhase->fixtures as $fixtures) {
        //         $challenger1 = $fixtures->challenger1->players ?? '';
        //         if ($challenger1 && $challenger1->profile_image && Str::startsWith($challenger1->profile_image, 'oxabyo/profiles')) {
        //             $fixtures->challenger1->players->profile_image = $this->fileService->fetchS3File($challenger1->profile_image);                   
        //         }
        //         $challenger2 = $fixtures->challenger2->players ?? '';
        //         if ($challenger2 && $challenger2->profile_image && Str::startsWith($challenger2->profile_image, 'oxabyo/profiles')) {
        //             $fixtures->challenger2->players->profile_image = $this->fileService->fetchS3File($challenger2->profile_image);
        //         }
        //         $winner = $fixtures->fixture_results->winner->players ?? '';
        //         if ($winner && $winner->profile_image && Str::startsWith($winner->profile_image, 'oxabyo/profiles')) {
        //             $fixtures->fixture_results->winner->players->profile_image = $this->fileService->fetchS3File($winner->profile_image);
        //         }
        //     }
        // }
 

        // return view('events.tables.winner-table-list', compact('completedEventPhase', 'event_id'))->render();

        
    }
}
