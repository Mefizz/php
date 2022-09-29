<?php

declare(strict_types=1);

namespace App\Application\Service\Phone;

use Symfony\Component\HttpFoundation\Response;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class PhoneValidator
{
    private Client $client;

    public function __construct(string $sid, string $authToken,  public bool $isDevAuth)
    {
        $this->client = new Client($sid, $authToken);
    }

    /**
     * @param string $phoneNumber // example: "(510) 867-5310"
     * @param string $countryCode // example: "US"
     * @return bool
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function validate(string $phoneNumber, string $countryCode): bool
    {
        if (true === $this->isDevAuth) {
            return true;
        }

        try {
            $phone_number = $this->client->lookups->v1
                ->phoneNumbers($phoneNumber)
                ->fetch(["countryCode" => $countryCode]);
        } catch (RestException $exception) {
            if ($exception->getStatusCode() === Response::HTTP_NOT_FOUND) {
              //  throw new InvalidPhoneNumberException('Mobile number does not exist or is not valid');
            }

     /*       $exceptionId = Uuid::uuid4();
            $this->logService->error(
                '%s {exceptionId: %s; message: %s; trace %s}',
                [__METHOD__, $exceptionId, $exception->getMessage(), $exception->getTraceAsString()]
            );

            throw new LogicException(
                \sprintf('Something was wrong, please contact support. Your request number is %s.', $exceptionId)
            );*/
        }

      //  $this->logService->info('%s {response: %d}', [__METHOD__, $phone_number->phoneNumber]);

        return true;
    }
}