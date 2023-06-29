<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use App\PasswordReset;
use App\User;
use Auth;
use Log;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function showResetForm(Request $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)->first();

        $userResetLinkExpired = '';

        if ($passwordReset) {
            $user = User::where('email', $passwordReset->email)->first();
        } else {
            $userResetLinkExpired = '';
        }

        return view('auth.passwords.reset')->with(
            [
                'token' => $request->token
            ]
        );
    }

    protected function sendResetResponse($response)
    {
        return redirect($this->redirectTo)
            ->with('status', trans($response));
    }

    protected function reset(Request $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)
            ->where('email', $request->email)
            ->first();
        if ($passwordReset) {
       
            User::where('email', $request->email)->update(['password' => \Hash::make($request->password)]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->intended('dashboard');
            }
        } else {
            return redirect()->back()->with('customerrors', "The username and/or password combination was not correct.")->withInput();
        }
    }
}
