<?php

namespace App\Tests\User;

use App\Tests\BaseTest;

class UserTest extends BaseTest
{
    public function testGetInfo(): void
    {
        $client = $this->createClientWithCredentials();
        $client->request('GET', '/api/user/');

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['status']);
    }

    public function testEditProfile(): void
    {
        $client = $this->createClientWithCredentials();
        $client->request('POST', '/api/user/edit', [
            'image' => 'userName',
            'firstName' => 'firstName',
            'lastName' => 'lastName',
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['status']);
    }
}
