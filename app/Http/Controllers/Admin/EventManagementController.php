<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Event;
use App\PlayerType;
use App\EventType;
use App\Game;
use App\EventInvite;
use App\EventPlayerDetail;
use App\EventPlayerTeam;
use App\Fixture;
use App\FixtureResult;
use App\EventPhase;
use App\EventAdminInvite;

/* Services */
use App\Services\FileService;

class EventManagementController extends Controller
{

    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $events = Event::with(['player_types', 'games'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.event-management.index', compact('events', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $playerTypes = PlayerType::get();
        $eventTypes = EventType::get();
        $games = Game::get();
        $users = User::where('user_role_id', '!=', 1)->orderBy('users.name', 'ASC')->get();
        return view('admin.event-management.create', compact('playerTypes', 'eventTypes', 'games','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $event = Event::create($input);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->image = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/events/".$event->id
            );
        }

        if ($request->cover) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->cover->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->cover->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->cover = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->cover,
                "oxabyo/events/".$event->id
            );
        }

        return redirect()->route('event-management.index')
            ->with('success', 'Event created successfully');
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
        $event = Event::with(['player_types', 'games'])
            ->find($id);

        $playerTypes = PlayerType::get();
        $eventTypes = EventType::get();
        $games = Game::get();
        $users = User::where('user_role_id', '!=', 1)->orderBy('users.name', 'ASC')->get();

        return view('admin.event-management.edit', compact('event', 'playerTypes', 'eventTypes', 'games', 'users'));
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
        $event = Event::find($id);
        $event->fill($request->all());
        $event->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->image = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/events/".$event->id
            );
        }

        if ($request->cover) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->cover->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->cover->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $event->id . '.' . $ext;

            $event->cover = "oxabyo/events/".$event->id."/".$filename;
            $event->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->cover,
                "oxabyo/events/".$event->id
            );
        }

        return redirect()->route('event-management.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        EventInvite::where('event_id', $id)->delete();
        $fixtureIds = Fixture::where('event_id', $id)->get(['id'])->toArray();
        FixtureResult::whereIn('fixture_id', $fixtureIds)->delete();
        Fixture::where('event_id', $id)->delete();
        EventPlayerDetail::where('event_id', $id)->delete();
        EventPlayerTeam::where('event_id', $id)->delete();
        EventPhase::where('event_id', $id)->delete();
        EventAdminInvite::where('event_id', $id)->delete();
        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully');
    }

    /**
     * Hide the specific event
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideEvent($id)
    {
        $event = Event::find($id);
        $event->status = 0;
        $event->save();
        return redirect()->back()->with('success', 'Event hidden successfully');
    }

    /**
     * Unhide the specific event
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEvent($id)
    {
        $event = Event::find($id);
        $event->status = 1;
        $event->save();
        return redirect()->back()->with('success', 'Event unhide successfully');
    }
}
