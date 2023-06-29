<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

/** Services */
use App\Services\FileService;
/** Models */
use App\Game;
use App\UserGame;

class GameController extends Controller
{
    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    /**
     * Display a list of games
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $Games = Game::leftJoin('user_games', function ($join) {
        //     $join->on('user_games.game_id', '=', 'games.id')
        //         ->where('user_games.user_id', auth()->id());
        // })
        //     ->select('games.*', 'user_games.is_played')
        //     ->get();
        $user = Auth::user();

        $search = trim($request->input('search'));
        $category = trim($request->input('categories'));
        $games = Game::with(['user_games']);
        if ($search) {
            $games = $games->where('name', 'LIKE', "%$search%");
        }
        if ($request->input('game_played_by_me') || $request->input('game_played_events_by') ) {
            $games = $games->whereHas('user_games', function ($query) use ($user) {
                $query->where('user_games.user_id', $user->id);
            });
        }  
        if ($request->input('game_played_by')) {
            $games = $games->whereHas('user_games', function ($query) use ($user) {
                $query->where('user_games.user_id', $user->id);
            });
        } else if ($request->input('game_played_by')) {
            $games = $games->where('admin_user_id', $user->id);
        }
        if ($category) {
            $games = $games->where('category', 'LIKE', "%$category%");
        }
        $games = $games->get();
        foreach ($games as $game) {
            if ($game->game_image) {
                $game->game_image = $this->fileService->fetchS3File($game->game_image);
            }
        }

        if ($request->ajaxCall) {
            return view('games.list', compact('games','search'))->render();
        }

        $gameCategories = Game::groupBy('category')->get();

        return view('games.index', compact('games','search', 'gameCategories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::  leftJoin('user_games', function ($join) {
            $join->on('user_games.game_id', '=', 'games.id')
            ->where('user_games.user_id', auth()->id());
        })
        ->select('games.*', 'user_games.is_played')
        ->where('games.id', $id)
        ->first();

        if ($game->game_image) {
            $game->game_image = $this->fileService->fetchS3File($game->game_image);
        }


        return view('games.show', compact('game'));
        //   return view('games.show');

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
    
    public function storeUserGame($id)
    {
        $usergame = UserGame::updateOrCreate([
            'user_id' => Auth()->user()->id,
            'game_id' => $id
        ]);
        $usergame->is_played = 1;
        $usergame->save();
        return redirect()->back()->with('success', 'Successfully added the usergame action');
    }
}
