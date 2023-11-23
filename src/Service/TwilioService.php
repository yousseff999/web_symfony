<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC853fa8dd7f9f60c49329d0418a6f6162';
    private $authToken = '1ac1958fd48bbc4c4003ee4e13445933';
    private $twilioPhoneNumber = '+15133225456';

    public function sendSMS($to, $body)
    {
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $body,
            ]
        );
    }
}
