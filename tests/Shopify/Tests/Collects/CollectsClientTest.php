<?php

namespace Shopify\Tests\Collects;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\Collects\CollectsClient;

/**
 * CollectsClientTest.php -
 *
 * @created 09/12/2013 15:39
 * @author  chris
 */

class CollectsClientTest extends GuzzleTestCase
{
    /**
     * Tests the status client factory.
     */
    public function testFactory()
    {
        $client = CollectsClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\Collects\CollectsClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests getting the collects details.
     */
    public function testGetCollects()
    {
        /** @var CollectsClient $client */
        $client = $this->getServiceBuilder()->get('collects');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'collects/get_collects',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getCollects();

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            array(
                array(
                    'collection_id' => 841564295,
                    'created_at'    => null,
                    'featured'      => false,
                    'id'            => 841564295,
                    'product_id'    => 632910392,
                    'sort_value'    => '0000000001',
                    'updated_at'    => null,
                    'position'      => 1,
                )
            ),
            $result->get('collects')
        );

        $this->assertEquals('https://apple.myshopify.com/admin/collects.json', $history->getLastRequest()->getUrl());
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests linking a product to a collection (I think this should be LINK but that is just me).
     */
    public function testPostCollection()
    {
        /** @var CollectsClient $client */
        $client = $this->getServiceBuilder()->get('collects');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'collects/post_collects',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->addToCollection(
            array('collect' => array('product_id' => 632910392, 'collection_id' => 841564295))
        );

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            array(
                'collection_id' => 841564295,
                'created_at'    => '2013-12-06T16:49:45-05:00',
                'featured'      => false,
                'id'            => 1071559574,
                'product_id'    => 921728736,
                'sort_value'    => '0000000002',
                'updated_at'    => '2013-12-06T16:49:45-05:00',
                'position'      => 2,
            ),
            $result->get('collect')
        );

        $this->assertEquals('https://apple.myshopify.com/admin/collects.json', $history->getLastRequest()->getUrl());
        $this->assertEquals('POST', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests add to collection failure.
     *
     * @expectedException \Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testFailToPostCollection()
    {
        /** @var CollectsClient $client */
        $client = $this->getServiceBuilder()->get('collects');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'collects/post_collects_failed',
            )
        );

        $client->addToCollection(
            array('collect' => array('body' => 'foobar'))
        );
    }
}
