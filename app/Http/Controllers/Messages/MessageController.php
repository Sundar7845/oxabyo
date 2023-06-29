<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Auth;

use App\User;
use App\UserFriend;
use App\Message;
use App\MessageRecipient;
use App\Notification;
/* Services */
use App\Services\FileService;
use App\Services\MailService;

class MessageController extends Controller
{
     /**
     * @var MailService
     */
    private $mailService;

    /**
     * EventInviteService constructor.
     *
     * @param MailService   $mailService
     */
 
    /**
     * @var FileService
     */
    private $fileService;
   
    public function __construct(
        MailService $mailService,
        FileService $fileService
    ) {
        
        $this->mailService = $mailService;
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::leftjoin('message_recipients', function ($join) {
                $join->on('users.id', '=', 'message_recipients.sender_user_id');
                $join->orOn('users.id', '=', 'message_recipients.receiver_user_id');
            })->join('messages', 'messages.id', 'message_recipients.message_id')
            ->where(function ($query) {
                $query->where('receiver_user_id', Auth::user()->id)
                    ->orWhere('sender_user_id', Auth::user()->id);
            })
            ->select(
                'users.*',
                'messages.message_body',
                'message_recipients.sender_user_id',
                'message_recipients.receiver_user_id',
                'message_recipients.group_id',
                'message_recipients.message_id',
                'message_recipients.is_read',
                'message_recipients.created_at'
            )
            ->where('users.id', '!=', Auth::user()->id)
            ->orderBy('message_recipients.created_at', 'DESC')
            ->get()
            ->unique('id');

        foreach ($users as $user) {
            if ($user->profile_image) {
                $user->profile_image = $this->fileService->fetchS3File($user->profile_image);
            }
        }
        return view('messages.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $player = User::find($id);

        if ($player && $player->profile_image) {
            $player->profile_image = $this->fileService->fetchS3File($player->profile_image);
        }

        $userFriend = UserFriend::where([
            'user_id' => Auth()->user()->id,
            'friend_id' => $id
        ])->first();

        $messages = Message::join('message_recipients', 'message_recipients.message_id', 'messages.id')
            ->where(function ($query) use ($id) {
                $query->where('receiver_user_id', $id)
                    ->where('sender_user_id', Auth::user()->id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('receiver_user_id', Auth::user()->id)
                    ->where('sender_user_id', $id);
            })
            ->select(
                'message_recipients.id',
                'messages.message_body',
                'message_recipients.sender_user_id',
                'message_recipients.receiver_user_id',
                'message_recipients.group_id',
                'message_recipients.message_id',
                'message_recipients.is_read',
                'message_recipients.created_at'
            )
            ->orderBy('message_recipients.created_at', 'ASC')
            ->get();


        if ($request->ajaxCall) {
            $message = Message::join('message_recipients', 'message_recipients.message_id', 'messages.id')
                ->where(function ($query) use ($id) {
                    $query->where('receiver_user_id', $id)
                        ->where('sender_user_id', Auth::user()->id);
                })
                ->orWhere(function ($query) use ($id) {
                    $query->where('receiver_user_id', Auth::user()->id)
                        ->where('sender_user_id', $id);
                })
                ->select(
                    'message_recipients.id',
                    'messages.message_body',
                    'message_recipients.sender_user_id',
                    'message_recipients.receiver_user_id',
                    'message_recipients.group_id',
                    'message_recipients.message_id',
                    'message_recipients.is_read',
                    'message_recipients.created_at'
                )
                ->orderBy('message_recipients.created_at', 'DESC')
                ->first();
            $lastMessageId = $request->lastMessageId;
            return view('messages.single-chat', compact('message', 'lastMessageId'))->render();
        }
        return view('messages.list', compact('player', 'userFriend', 'messages'));
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $data = $request->all();
        $id = $data['deleteId'];
        $messageRecipients = MessageRecipient::where(function ($query) use ($id) {
            $query->where('receiver_user_id', $id)
                ->where('sender_user_id', Auth::user()->id);
            })->orWhere(function ($query) use ($id) {
                $query->where('receiver_user_id', Auth::user()->id)
                    ->where('sender_user_id', $id);
            })
            ->get(['message_id'])->toArray();

        MessageRecipient::where(function ($query) use ($id) {
            $query->where('receiver_user_id', $id)
                ->where('sender_user_id', Auth::user()->id);
            })->orWhere(function ($query) use ($id) {
                $query->where('receiver_user_id', Auth::user()->id)
                    ->where('sender_user_id', $id);
            })
            ->delete();

        Message::whereIn('id', $messageRecipients)->delete();
        return redirect()->route('message-list.index')->with('success', 'Messages deleted successfully');
    }

    /**
     * Send message
     */
    public function sendMessage(Request $request, $id)
    {
      
        $data = $request->all();
       
        $data['user_name'] = Auth::user()->name;

        $message = Message::create([
            'created_by_id' => Auth()->user()->id,
            'subject' => 'Private Message',
            'message_body' => $data['private_message'],
            'status' => 1
        ]);
        MessageRecipient::create([
            'sender_user_id' => Auth()->user()->id, 
            'receiver_user_id' => $id,
            'message_id' => $message->id
        ]);

        Notification::create([
                'sender_user_id'  =>   Auth()->user()->id,
                'receiver_user_id'=>   $id,
                'title'           =>  'Private Message',
                'message'         =>   $data['user_name'] . " sent you a message.",
                'is_read'         =>   0
        ]);


        $user = User::where('users.id', $id)
            ->select('users.email')
            ->first();

        
        /** Send Email */
        $this->mailService->send($user->email, 'Private Message', 'message', $data);

        if ($request->ajaxCall) {
            $messages = Message::join('message_recipients', 'message_recipients.message_id', 'messages.id')
                ->where(function ($query) use ($id) {
                    $query->where('receiver_user_id', $id)
                    ->where('sender_user_id', Auth::user()->id);
                })
                ->orWhere(function ($query) use ($id) {
                    $query->where('receiver_user_id', Auth::user()->id)
                        ->where('sender_user_id', $id);
                })
                ->select(
                    'messages.message_body',
                    'message_recipients.sender_user_id',
                    'message_recipients.receiver_user_id',
                    'message_recipients.group_id',
                    'message_recipients.message_id',
                    'message_recipients.is_read',
                    'message_recipients.created_at'
                )
                ->orderBy('message_recipients.created_at', 'ASC')
                ->get();

            return view('messages.chat', compact('messages'))->render();
        }
       return redirect()->back()->with('success', 'Message sent successfully');
    }
}
