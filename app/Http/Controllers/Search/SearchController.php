<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Services */
use App\Services\FileService;
use App\Services\EventService;

use App\Team;
use App\User;

class SearchController extends Controller
{
 /**
     * @var FileService
     */
    private $fileService;

    public function __construct(
        FileService $fileService,
        EventService $eventService
 
    ) {
        $this->fileService = $fileService;
        $this->eventService = $eventService;
 
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $events = $this->eventService->searchEvents($request);

        foreach($events as $event)
        {
            if($event->image)
            {
                $event->image = $this->fileService->fetchS3File($event->image);
            }
        }
        

        $teams = Team::where('name', 'like', '%' . $request->name . '%')->get();

        foreach($teams as $team)
        { 
          if ($team->team_image) 
          {
            $team->team_image = $this->fileService->fetchS3File($team->team_image);
          }
        }
        $users = User::where('name', 'like', '%' . $request->name . '%')->get(); 

        foreach($users as $user)
        {
          if ($user->profile_image)
           {
            $user->profile_image = $this->fileService->fetchS3File($user->profile_image);
           }
       }
       
        return view('users.search',compact('events','teams', 'users'));
    }
}
