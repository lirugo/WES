<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * OVERRIDES
     *
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $token = $request->input('g-recaptcha-response');

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('GOOGLE_reCAPTCHA_SECRET'),
                'response' => $token
            ],
        ]);
        $result = json_decode($response->getBody()->getContents());
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required',
            $result->success => 'true'
        ]);

    }
}
