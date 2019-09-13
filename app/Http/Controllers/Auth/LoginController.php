<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Captcha;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/';
    protected $redirectToToken = '/auth/token';

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
     * @return boolean
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => new Captcha()
        ]);
    }

    protected function authenticated(Request $request, User $user){
        //Check have two factor auth
//        return redirect("/");
        return $this->logoutAndRedirectToTokenEntry($request, $user);
    }

    protected function logoutAndRedirectToTokenEntry($request, $user){
        session(['user_id' => Auth::user()->id]);
        $phone = substr(str_replace(' ', '', Auth::user()->getPhone()),1);
        Auth::guard()->logout();
        // Random key
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]);
        $keyArray = $collection->random(4);
        $key =  $keyArray[0].$keyArray[1].$keyArray[2].$keyArray[3];
        // Send sms
        $this->sendSms($key, $phone);
        // Put key to session
        session(['key' => $key]);
        // Redirect to token page
        return redirect($this->redirectToTokenPath());
    }

    protected function redirectToTokenPath(){
        return $this->redirectToToken;
    }

    protected function sendSms($key, $phone){
        $text = (env('FLY_SMS_TEXT').' '.$key);
        $description = 'Description';
        $start_time = 'AUTO'; // отправить немедленно или ставим дату и время  в формате YYYY-MM-DD HH:MM:SS
        $end_time = 'AUTO'; // автоматически рассчитать системой или ставим дату и время  в формате YYYY-MM-DD HH:MM:SS
        $rate = 1; // скорость отправки сообщений (1 = 1 смс минута). Одиночные СМС сообщения отправляются всегда с максимальной скоростью.
        $lifetime = 4; // срок жизни сообщения 4 часа
        $recipient = $phone;
        $user = env('FLY_SMS_USER'); // тут ваш логин в международном формате без знака +. Пример: 380501234567
        $password = env('FLY_SMS_PASS'); // Ваш пароль

        $myXML 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $myXML 	.= "<request>"."\n";
        $myXML 	.= "<operation>SENDSMS</operation>"."\n";
        $myXML 	.= '		<message start_time="'.$start_time.'" end_time="'.$end_time.'" lifetime="'.$lifetime.'" rate="'.$rate.'" desc="'.$description.'">'."\n";
        $myXML 	.= "		<body>".$text."</body>"."\n";
        $myXML 	.= "		<recipient>".$recipient."</recipient>"."\n";
        $myXML 	.=  "</message>"."\n";
        $myXML 	.= "</request>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD , $user.':'.$password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://sms-fly.com/api/api.noai.php');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
        $response = curl_exec($ch);
        curl_close($ch);
        return true;
    }
}
