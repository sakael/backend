<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/items');

        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertContains('success', $response);
    }

    public function testAddItem(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/items/create',[
           'name' => 'test', 'phone_number' => '065542131', 'description' => 'Lorem test text',
        ]);
        
        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertContains('success', $response);
    }
}
