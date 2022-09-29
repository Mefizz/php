<?php

namespace App\Tests\User;

use App\Tests\BaseTest;

class PasswordTest extends BaseTest
{
    public function testChangePassword(): void
    {
        $client = $this->createClientWithCredentials();
        $client->request('POST', '/api/user/change-password', [
            'email' => $this->userName,
            'passwordOld' => $this->password,
            'passwordNew' => '123456789',
            'passwordNewRepeat' => '123456789',
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Password changed', $data['message']);
    }

    public function testResetPassword(): void
    {
        $client = $this->getClient();
        $client->request('POST', '/api/user/reset-password', [
            'email' => $this->userName
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Password updated', $data['message']);
    }
}
