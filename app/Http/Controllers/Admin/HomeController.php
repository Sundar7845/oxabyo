<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Event;
use App\Team;
use App\Game;

/* Services */
use App\Services\FileService;

use Session;

class HomeController extends Controller
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
        $usersCount = User::where('user_blocked_status', 0)->count();
        $eventsCount = Event::where('status', 1)->count();
        $gamesCount = Game::where('status', 1)->count();
        $teamsCount = Team::where('status', 1)->count();

        return view('admin.index', compact('usersCount', 'eventsCount', 'gamesCount', 'teamsCount'));
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        return view('admin.profile',compact('user'));        
    }

    public function saveProfile(Request $request)
    {

        $user = Auth::user();
        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->password = $request->password;
        }
        $user->name = $request->name ?? $user->name;
        $user->surename = $request->surename ?? $user->surename;
        $user->dob = $request->dob ?? $user->dob;
        $user->address = $request->address ?? $user->address;
        $user->city = $request->city ?? $user->city;
        $user->bio_data = $request->bio_data ?? $user->bio_data;
        $user->profile_color = $request->profile_color ?? $user->profile_color;
        
        $user->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $user->id . '.' . $ext;

            $user->profile_image = "oxabyo/profiles/".$user->id."/".$filename;
            $user->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                "oxabyo/profiles/".$user->id
            );

            $profile_image = $this->fileService->fetchS3File($user->profile_image);
            Session::put('user_profile_image', $profile_image); 
        }

        return redirect()->back()->with(['success'=>'Your profile updated successfully']);
    }
}
