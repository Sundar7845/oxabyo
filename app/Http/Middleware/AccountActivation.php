<?php

namespace App\Http\Middleware;

use App\Notification;
use Closure;
use Auth;
use View;
use Mail;
use Log;
use Illuminate\Support\Str;

class AccountActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && !$user->activated) {

            if (!$user->token) {

                $user->token =  hash('sha256', Str::random(100));
                $user->save();
                $email = $user->email;
                
                 Notification::updateOrCreate([
                     'sender_user_id'=>Auth()->user()->id,
                     'receiver_user_id'=>$user->id,
                      'title'=>'Account Activation',
                      'message'=>' Thanks for your registration in OXABYO!',
                      'is_read'=>0
                 ]);

                try {
                    Mail::send('emails.welcome', ['user' => $user], function ($message) use ($email) {
                        $message->to($email);
                        $message->sender(env('MAIL_FROM_ADDRESS'));
                        $message->subject('Account Activation');
                    });
                } catch (\Exception $e) {

                    Log::info($e);
                }
            }

            return redirect(url(route('account_activation')));
        }
        return $next($request);
    }
}
