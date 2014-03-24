<?php
/**
 * WishlistControllerTest.php -
 *
 * @created 18/03/2014 12:15
 * @author  chris
 */

namespace Kurl\Bundle\ShopifyBundle\Tests\Controller;

use Kurl\Common\Test\Fixture\JsonDataSet;
use Kurl\Common\Test\WebTestCase;

class WishlistControllerTest extends WebTestCase
{

    /**
     * Tests the search action.
     */
    public function testSearchAction()
    {
        /** @var \Symfony\Bundle\FrameworkBundle\Client $client */
        $client = static::$kernel->getContainer()->get('test.client');

        $client->request('GET', '/wishlist/search?shop=example.myshopify.com');

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $client->getResponse();

        $this->assertEquals(
            <<<EOT
{% assign query = '' %}
{% include 'wishlist-search' %}
EOT
            ,
            trim($response->getContent())
        );
    }

    /**
     * @inheritDoc
     */
    protected function getDataSet()
    {
        return JsonDataSet::fromFile(__DIR__ . '/Fixture/shop.json');
    }
}
