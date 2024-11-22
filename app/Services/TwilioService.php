<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TwilioService
{
    public function sendSms($to, $message)
    {
       
        if (substr($to, 0, 1) === '0') {
            $to = '+63' . substr($to, 1); // Replace leading 0 with +63
        }

        $ch = curl_init();
        $parameters = array(
            'apikey' => config('app.api_key'), //Your API KEY
            'number' => $to,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        dd($output);
        curl_close ($ch);
    }

}
