<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Comment;
use App\LiveComment;

use App\Services\AlgoService;

class CommentsController extends Controller
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
        // Store comments for event id and user id

        $comment = Comment::create([
            'comment' => $request->comment,
            'status' => 1
        ]);

        LiveComment::create([
            'comment_id'    =>  $comment->id,
            'created_by_id' =>  auth()->user()->id,
            'event_id'      =>  $request->event_id,
            'player_id'     =>  $request->player_id ?? null,
            'can_hide'      =>  0
        ]);

        // update reward for event creation
        $this->algoService->updateRewardPointsForSocial(auth()->user()->id, 'create_comment');

        $comment = LiveComment::join('comments', 'comments.id', 'live_comments.comment_id')
            ->join('users', 'users.id', 'live_comments.created_by_id')
            ->select('live_comments.*', 'comments.comment', 'users.name')
            ->where('event_id', $request->event_id) 
            ->where('can_hide', '0')
            ->orderBy('live_comments.created_at', 'DESC')
            ->first();

        if ($request->player_id) {

            $lastPlayerCommentId = $request->lastCommentId;
            return view('events.comments.player-single-comment', compact('comment', 'lastPlayerCommentId'))->render();
        } else {

            $lastCommentId = $request->lastCommentId;
            return view('events.comments.single-comment', compact('comment', 'lastCommentId'))->render();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $userId = $request->userId ?? null;

        $comment = LiveComment::join('comments', 'comments.id', 'live_comments.comment_id')
            ->join('users', 'users.id', 'live_comments.created_by_id')
            ->select('live_comments.*', 'comments.comment', 'users.name')
            ->where('event_id', $id)            
            ->where('can_hide', '0')
            ->when($userId, function ($query, $userId) {
                return $query->where('live_comments.player_id', $userId);
            })
            ->when( ! $userId, function ($query) {
                return $query->whereNull('player_id');
            })            
            ->orderBy('live_comments.created_at', 'DESC')
            ->first();

        $lastCommentId = $request->lastCommentId;
        
        return view('events.comments.single-comment', compact('comment', 'lastCommentId'))->render();
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
}
