<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPasswordForm()
    {
        return view('auth.reset-password');
    }

    public function resetPasswordEmailForm()
    {
        return view('auth.reset-password-email');
    }

    public function resetMail(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        //Check if the user exists
        if ($user === null) {
            return redirect('/login')->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect('/login')->with('success', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect('/login')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'token' => 'required']);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => $validator->errors()->first()]);
        }

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
        // Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        return redirect('/login')->with(['success' => 'Password was changed']);
    }


    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = User::where('email', $email)->select('email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        Mail::to($user)->send(new ResetPasswordMail($user, $link));

        try {
            //Here send the link with CURL with an external email API
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
