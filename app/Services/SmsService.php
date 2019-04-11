<?php

namespace App\Services;


class SmsService {

    public static function sendSmsNotification($phone, $text){
        $phone = substr(str_replace(' ', '', $phone),1);
        self::sendSms($phone, $text);
    }

    private static function sendSms($phone, $text){
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