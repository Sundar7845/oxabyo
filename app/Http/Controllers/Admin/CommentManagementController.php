<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Comment;
use App\LiveComment;

class CommentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        // $comments = Comment::when($search, function ($query, $search) {
        //         return $query->where('comment', 'like', '%' . $search . '%');
        //     })
        //     ->paginate(10)
        //     ->appends(request()->query());

        $comments =    LiveComment::join('comments', 'comments.id', 'live_comments.comment_id')
            ->join('users', 'users.id', 'live_comments.created_by_id')
            ->join('events', 'events.id', 'live_comments.event_id')
            ->select('live_comments.*', 'comments.comment', 'users.name as user_name', 'events.name as event_name')
            ->when($search, function ($query, $search) {
                return $query->where('comment', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.comment-management.index', compact('comments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.comment-management.create');
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

        Comment::create($input);

        return redirect()->route('comment-management.index')
            ->with('success', 'Comment created successfully');
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
        $comment = Comment::find($id);
        return view('admin.comment-management.edit', compact('comment'));
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
        $comment = Comment::find($id);
        $comment->fill($request->all());
        $comment->save();
        return redirect()->route('comment-management.index')
            ->with('success', 'Comment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return redirect()->route('comment-management.index')
            ->with('success', 'Comment deleted successfully');
    }

    /**
     * Hide the specific comment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hideComment($id)
    {
        $comment = LiveComment::find($id);
        $comment->can_hide = 0;
        $comment->save();
        return redirect()->back()->with('success', 'Comment unhide successfully');
    }

    /**
     * Unhide the specific comment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showComment($id)
    {
        $comment = LiveComment::find($id);
        $comment->can_hide = 1;
        $comment->save();
        return redirect()->back()->with('success', 'Commet hidden successfully');
    }
}
