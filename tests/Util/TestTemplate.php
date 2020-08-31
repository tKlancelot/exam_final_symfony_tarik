<?php

namespace App\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class TestTemplate extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fr');
        $this->assertSame(1, $crawler->filter('a:contains("articles")')->count());
        $link = $crawler->selectLink('articles')->link();
        $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

?>