<?php

namespace App\Http\Controllers\Twitch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use romanzipp\Twitch\Twitch;

use App\Twitch as TwitchModel;

class TwitchIntegrationController extends Controller
{
    /**
     * Twitch integration for the users
     */
    public function storeTwitchUser(Request $request)
    {
        try {

            $twitch = new Twitch;

            // Get User by Username
            $result = $twitch->getUsers(['login' => $request->twitch_username]);

            // Check, if the query was successful
            if (!$result->success()) {
                return null;
            }
            // Shift result to get single user data
            $user = $result->shift();

            $stream = $twitch->getStreams(['user_id' => $user->id]);

            $stream = $stream->shift();

            $twitchModel = TwitchModel::updateOrCreate([
                'user_id' => auth()->user()->id
            ]);
            $twitchModel->twitch_user_id = $user->id;
            $twitchModel->twitch_login = $user->login;
            $twitchModel->twitch_display_name = $user->display_name;
            $twitchModel->channel_name = $user->login;
            $twitchModel->type = $user->type;
            $twitchModel->broadcaster_type = $user->broadcaster_type;
            $twitchModel->description = $user->description;


            $twitchModel->online_status = $stream->type ?? null;

            $twitchModel->last_streaming = $stream->started_at ?? null;
            $twitchModel->followers = null;
            $twitchModel->subscribers = null;
            $twitchModel->last_cover = null;
            $twitchModel->status = 1;
            $twitchModel->save();

        } catch (\Exception $e) {

            // Error Logging
        }

        return redirect()->back();
    }

    /**
     * Twitch integration for the users
     */
    // public function getTwitchUser(Request $request)
    // {

    // }
}
