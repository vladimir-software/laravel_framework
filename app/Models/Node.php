<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model {

    public static function sendNode($recever = "", $type = "json", $body = "", $code = 'post') {
        $curl = curl_init();
        if ($type == 'json') {
            $body = json_decode($body);
        }
        $data = array('userList' => $recever, 'body' => $body, 'type' => $type, 'code' => $code);

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "9536",
            CURLOPT_URL => "https://www.connecteonetwork.com:9536/update-data",
// => "http://localhost:3001/update-data",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
//CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => false,
//CURLOPT_CAINFO => APP . "/self-signed/server.crt",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
// echo $response;
        }
    }

}
