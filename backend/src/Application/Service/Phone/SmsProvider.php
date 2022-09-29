<?php
declare(strict_types=1);

namespace App\Application\Service\Phone;

use Twilio\Rest\Client;

class SmsProvider
{
    private Client $client;

    public function __construct(string $sid, string $authToken, public string $phoneNumberFrom)
    {
        $this->client = new Client($sid, $authToken);
    }

    public function send(string $destinationPhoneNumber, string $body)
    {
        $message = $this->client->messages
            ->create($destinationPhoneNumber,
                [
                    "body" => $body,
                    "from" => $this->phoneNumberFrom
                ]
            );

       // $this->logService->info('%s {response: %d}', [__METHOD__, $message->sid]);
    }
}