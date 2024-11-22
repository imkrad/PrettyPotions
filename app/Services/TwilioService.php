<?php

namespace App\Services;

// use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;

class TwilioService
{
    // protected $client;

    // public function __construct()
    // {
    //     $this->client = new Client('AC015c1dda2602ab86d81141a463bc1d87','83f5fbd7c06469852e4009eedfe0ec08');
    // }

    public function sendSms($to, $message)
    {
        if (substr($to, 0, 1) === '0') {
            $to = '+63' . substr($to, 1); // Replace leading 0 with +63
        }
        // return $this->client->messages->create($to, [
        //     'from' => '+16514123300',
        //     'body' => $message,
        // ]);

        // $response = Http::post('https://api.semaphore.co/api/v4/messages', [
        //     'apikey' => '7eef4877bfbb1cc20b7725e70853c8e4',
        //     'number' => $to,
        //     'sendername' => 'SEMAPHORE',
        //     'message' => $message,
        // ]);
        // return $response->json();

        $ch = curl_init();
        $parameters = array(
            'apikey' => '7eef4877bfbb1cc20b7725e70853c8e4', //Your API KEY
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
