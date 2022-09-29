<?php

namespace App\Tests\User;

use App\Tests\BaseTest;

class PhoneTest extends BaseTest
{
    public function testLogin()
    {
        $client = $this->getClient();

        $client->request('POST', '/api/user/login', [
            'username' => $this->userName,
            'phone'=>$this->phone
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($data['status']);
    }
}