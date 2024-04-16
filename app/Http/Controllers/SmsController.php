<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SmsController extends Controller
{


    public static function send($phone, $message, $code = null)
    {

        if (strpos($phone, '+') !== false) {
            $phone = substr($phone, 1);
        }

        if (strpos($message, '’') or strpos($message, '‘')) {
            $message = str_replace("’", "'", $message);
            $message = str_replace("‘", "'", $message);
        }
        $message = self::messTranslate($message);
        // $data = array(
        //     array('phone' => $phone, 'text' => utf8_encode($message)),
        // );
        // $data[] = ['phone' => $phone, 'text' => utf8_encode($message)];

        //$array = array_chunk($data, 5, true);

        $send_code = [
            'version' => '1.0',
            'id' => 123232,
            'method' => 'opersms.send',
            "client_secret" => "7mbGEJxOF3khqDCg",
            'params' =>
                [
                    'phone' => $phone,
                    'message' => utf8_encode($message),
                    //'code'  => $code
                ]
        ];

        $client = new Client(['verify' => false]);
        $res = $client->post('https://sms.mehnat.uz/serve', [
            'json' => $send_code
        ]);

        $result = json_decode($res->getBody(), true);

        return $result;
    }

    public static function checkCode($phone, $code)
    {
        if (strpos($phone, '+') !== false) {
            $phone = substr($phone, 1);
        }
        $send_code = [
            'version' => '1.0',
            'id' => 123232,
            'method' => 'opersms.send.checkotp',
            'client_secret' => '7mbGEJxOF3khqDCg',
            'params' =>
                [
                    'phone' => $phone,
                    'code' => $code
                ]
        ];

        $client = new Client(['verify' => false]);
        $res = $client->post('https://sms.mehnat.uz/serve', [
            'json' => $send_code
        ]);

        $result = json_decode($res->getBody(), true);
        return $result;
    }



    //    public static function send($phone, $message){

    //     if (strpos($phone, '+') !== false) {
    // 	    $phone = substr($phone, 1);
    // 	}

    // 	if (strpos($message, '’') or strpos($message, '‘')) {
    // 	    $message = str_replace("’", "'", $message);
    // 	    $message = str_replace("‘", "'", $message);
    // 	}
    // 	$message = self::messTranslate($message);

    //     $data = array(
    //         array('phone' => $phone, 'text' => utf8_encode($message)),
    //     );

    //     $array = array_chunk($data, 5, true);

    //     foreach ($array as $chunk) {

    //         $ch = curl_init("http://83.69.139.182:8080/");
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //         curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    //         curl_setopt($ch, CURLOPT_POSTFIELDS, "login=mehnatuz&password=rXnMK4Sjo913&data=" . json_encode($chunk));

    //         $result = curl_exec($ch);

    //         if (!$result) {
    //             echo curl_error($ch);
    //         }

    //         curl_close($ch);

    //         $details = json_decode($result, true);

    //         return $details;
    //     }
    // }


    public static function messTranslate($string)
    {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'x', 'ц' => 'ts',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh',
            'ь' => '\'', 'ы' => '', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'қ' => 'q', 'ў' => 'o\'', 'ҳ' => 'h',
            'ғ' => 'g\'',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'X', 'Ц' => 'Ts',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh',
            'Ь' => '\'', 'Ы' => '', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            'Қ' => 'Q', 'Ў' => 'O\'', 'Ҳ' => 'H',
            'Ғ' => 'G\'',
        );
        return strtr($string, $converter);
    }


    /* sms service uchun ***********
    s
        public static function send($phone, $message){

        if (strpos($phone, '+') !== false) {
            $phone = substr($phone, 1);
        }

        if (strpos($message, '’') or strpos($message, '‘')) {
            $message = str_replace("’", "'", $message);
            $message = str_replace("‘", "'", $message);
        }
        $message = self::messTranslate($message);
        // $data = array(
        //     array('phone' => $phone, 'text' => utf8_encode($message)),
        // );
           // $data[] = ['phone' => $phone, 'text' => utf8_encode($message)];

        //$array = array_chunk($data, 5, true);

       $send_code = [
                'version' => '1.0',
                'id' => 123232,
                'method' => 'opersms.send',
                "client_secret":"u0XTiYrlu9Cxxifm",
                'params' =>
                    [
                        'phone' => $phone,
                        'message' => utf8_encode($message)
                    ]
                ];

                $client = new Client();
                $res = $client->post('https://sms.mehnat.uz/serve', [
                    'json' => $send_code
                ]);

                $result = json_decode($res->getBody(), true);

           // return $details;
        }
    }
    */
}
