<?php

namespace App\Tests\User;


use App\Features\User\Repository\UserRepository;
use App\Tests\BaseTest;

class AuthTest extends BaseTest
{
    public function testRegistration(): void
    {
        $client = $this->getClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        if($user = $userRepository->findOneByEmail($this->userName)){
            $userRepository->remove($user);
        }

        $client->request('POST', '/api/user/registration', [
            'email' => $this->userName,
            'password' => $this->password,
            'passwordRepeat' => $this->password

        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Successful registered', $data['message']);

    }

    public function testApproveRegistration(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/api/user/approve/' . base64_encode($this->userName));

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Approved', $data['message']);
    }

    public function testLogin(): void
    {
        $client = $this->getClient();

        $client->request('POST', '/api/user/login', [
            'username' => $this->userName,
            'password' => $this->password
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['status']);
    }

    public function testLogout(): void
    {
        $client = $this->createClientWithCredentials();

        $client->request('GET', '/api/user/logout');

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Logout is successful', $data['message']);
    }
}
