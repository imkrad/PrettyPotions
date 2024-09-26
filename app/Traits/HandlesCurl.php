<?php

namespace App\Traits;

trait HandlesCurl
{
    public $link, $api;

    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }

    public function handleApi(){
        $apiUrl = $this->link.'/api/user';
        $accessToken = $this->api;
        $ch = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
        ]);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $respone =  'Error: ' . curl_error($ch);
        } else {
            $response;
        }
        curl_close($ch);
        return $response;
    }

    public function handleCurl($name,$array){
        $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/'.$name.'/'.$array;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->api
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
