<?php

namespace App\Tests;

use App\Features\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTest extends WebTestCase
{
    public string $userName = 'bohdan.sotnychuk@gmail.com';
    public int $password = 12345678;
    public int $phone = +38012345678;

    private $token;

    protected function createClientWithCredentials($token = null)
    {
        $token = $token ?: $this->getToken();

        self::ensureKernelShutdown();
        return static::createClient([], [
            'HTTP_Authorization' => 'Bearer '.$token,
            'HTTP_HOST' => 'dare.loc'
        ]);
    }

    /**
     * Use other credentials if needed.
     */
    protected function getToken($body = [])
    {
        if ($this->token) {
            return $this->token;
        }

        $client = $this->getClient();

        $client->request('POST', '/api/user/login', $body ?: [
            'username' => $this->userName,
            'password' => $this->password
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->token = $data['data']['token'];

        return $data['data']['token'];
    }

    protected function getClient()
    {
        return static::createClient([], ['HTTP_HOST' => 'dare.loc']);
    }
}