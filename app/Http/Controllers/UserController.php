<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/* Services */
use App\Services\FileService;
use App\Services\AlgoService;

use App\User;
use App\Twitch;

use Session;

class UserController extends Controller
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var AlgoService
     */
    private $algoService;

    public function __construct(
        FileService $fileService,
        AlgoService $algoService
    ) {
        $this->fileService = $fileService;
        $this->algoService = $algoService;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        $twitch = Twitch::where('user_id', $user->id)->first();

        return view('users.profile',compact('user', 'twitch'));
    }
    
    public function updateProfile(Request $request)
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
        $user->profile_color=$request->profile_color ??$user->profile_color;
        $user->save();

        if ($request->file) {
            $image_prefix = substr(md5(microtime()), rand(0, 26), 4);
            $origname = $request->file->getClientOriginalName();
            $origname = pathinfo($origname, PATHINFO_FILENAME);
            $ext = $request->file->getClientOriginalExtension();
            $filename = $image_prefix . '-' . $origname . '-' .  $user->id . '.' . $ext;

            $user->profile_image = "oxabyo/profiles/".$filename;
            $user->save();

            $this->fileService->storeWithChunking(
                $filename,
                $request->file,
                'oxabyo/profiles'
            );

            $profile_image = $this->fileService->fetchS3File($user->profile_image);
            Session::put('user_profile_image', $profile_image); 
        }

        // update reward for event creation
        $this->algoService->updateRewardPointsForSocial($user->id, 'complete_profile');


        return redirect()->back()->with(['success'=>'Your profile updated successfully']);
    }

    public function userActivation(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if ($user) {
            $user->token = null;
            $user->email_verified_at = now();
            $user->activated = 1;
            $user->save();
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error'=>'Invalid access']);
    }
    
    
}
