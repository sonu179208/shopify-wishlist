<?php

namespace Kurl\Bundle\ShopifyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'GET',
            $client->getContainer()->get('router')->generate('kurl_shopify_default_index')
        );

        //$this->assertTrue($crawler->filter('html:contains("Hello")')->count() > 0);
    }
}
