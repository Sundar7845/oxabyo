<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Game;

/* Services */
use App\Services\FileService;

class GameManagementController extends Controller
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

        $games = Game::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.game-management.index', compact('games', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.game-management.create');
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

        $game = Game::create($input);

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $game->id . '.' . $ext;

            $game->game_image = "oxabyo/games/".$game->id."/".$filename;
            $game->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/games/".$game->id
            );
        }

        return redirect()->route('game-management.index')
            ->with('success', 'Game created successfully');
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
        $game = Game::find($id);
        return view('admin.game-management.edit', compact('game'));
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
        $game = Game::find($id);
        $game->fill($request->all());
        $game->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $game->id . '.' . $ext;

            $game->game_image = "oxabyo/games/".$game->id."/".$filename;
            $game->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/games/".$game->id
            );
        }

        return redirect()->route('game-management.index')
            ->with('success', 'Game updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        $game->delete();
        return redirect()->route('game-management.index')
            ->with('success', 'Game deleted successfully');
    }

    /**
     * Hide the specific game
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideGame($id)
    {
        $game = Game::find($id);
        $game->status = 0;
        $game->save();
        return redirect()->back()->with('success', 'Game hidden successfully');
    }

    /**
     * Unhide the specific game
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGame($id)
    {
        $game = Game::find($id);
        $game->status = 1;
        $game->save();
        return redirect()->back()->with('success', 'Game unhide successfully');
    }
}
