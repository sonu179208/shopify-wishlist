<?php
/**
 * Tests the custom collections client.
 *
 * @created 17/03/2014 14:14
 * @author  chris
 */

namespace Shopify\Tests\CustomCollections;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\CustomCollections\CustomCollectionsClient;

class CustomCollectionsClientTest extends GuzzleTestCase
{
    /**
     * Tests the custom collections clientfactory.
     */
    public function testFactory()
    {
        $client = CustomCollectionsClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\CustomCollections\CustomCollectionsClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests creating a new collection.
     */
    public function testPostCustomerCollection()
    {
        /** @var CustomCollectionsClient $client */
        $client = $this->getServiceBuilder()->get('custom_collections');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'custom_collections/post_custom_collections',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->createCustomCollection(
            array(
                'custom_collection' => array(
                    'title'      => 'Macbooks',
                    'metafields' => array(
                        'key'        => 'new',
                        'value'      => 'newvalue',
                        'value_type' => 'string',
                        'namespace'  => 'global'

                    )
                )
            )
        );

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            array(
                'body_html'       => null,
                'handle'          => 'macbooks',
                'id'              => 1063001313,
                'published_at'    => '2014-03-13T19:14:22-04:00',
                'published_scope' => 'global',
                'sort_order'      => 'alpha-asc',
                'template_suffix' => null,
                'title'           => 'Macbooks',

            ),
            $result->get('custom_collection')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/custom_collections.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('POST', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests creating removing a collection.
     */
    public function testRemoveCustomerCollection()
    {
        /** @var CustomCollectionsClient $client */
        $client = $this->getServiceBuilder()->get('custom_collections');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'custom_collections/delete_custom_collections',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->removeCustomCollections(
            array(
                'id' => 1063001313
            )
        );

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertNull($result->get('custom_collection'));

        $this->assertEquals(
            'https://apple.myshopify.com/admin/custom_collections/1063001313.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('DELETE', $history->getLastRequest()->getMethod());
    }

    public function testGetCustomerCollections()
    {
        /** @var CustomCollectionsClient $client */
        $client = $this->getServiceBuilder()->get('custom_collections');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'custom_collections/get_custom_collections',
                'custom_collections/get_custom_collections_empty',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getCustomCollections(array());

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            json_decode(file_get_contents(__DIR__ . '/Fixture/custom_collections.json'), true),
            $result->toArray()
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/custom_collections.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());

        //
        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getCustomCollections(array('query' => ''));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            array(),
            $result->get('custom_collections')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/custom_collections.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }
}
