<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use App\User;
use App\PasswordReset;
use Mail;
use Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetLinkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $passwordReset = new PasswordReset();
            $passwordReset->email = $request->email;
            $passwordReset->token = Str::random(60);
            $passwordReset->created_at = date('Y-m-d H:i:s');
            $passwordReset->timestamps = false;
            $passwordReset->save();

            $token = $passwordReset->token;
            $email = $user->email;

            try {
                Mail::send('emails.email_rest', ['token' => $token], function ($message) use ($email) {
                    $message->to($email);
                    $message->sender(env('MAIL_FROM_ADDRESS'));
                    $message->subject('Reset Password');
                });
            } catch (\Exception $exception) {
                Log::error("unexpected exception: ", [
                    'exception'   => $exception->getMessage(),
                    'stack_trace' => $exception->getTraceAsString()
                ]);
            }
        }

        return redirect()->back()
            ->with('success', "Check your inbox, you'll find the instructions to set new password")
            ->withInput();
    }
}
