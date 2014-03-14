<?php
/**
 * ClientBuilderTest.php -
 *
 * @created 09/12/2013 15:02
 * @author chris
 */

namespace Shopify\Tests\Common\Client;

use Guzzle\Common\Collection;
use Shopify\Common\Client\ClientBuilder;

class ClientBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests config setting.
     */
    public function testSetConfig()
    {
        $config = new Collection(
            array(
                'api_key' => 'bar',
                'shop' => 'apple.my-shopify.com',
                'service.description' => array(),
            )
        );
        $client = ClientBuilder::factory()
            ->setConfig($config)
            ->build();

        $this->assertSame('https://apple.my-shopify.com', $client->getBaseUrl());
    }

    /**
     * Tests non-array config.
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The config must be provided as an array or Collection.
     */
    public function testBadConfig()
    {
        ClientBuilder::factory()->setConfig('foo');
    }

    public function testClientNamespace()
    {
        $config = new Collection(
            array(
                'api_key' => 'bar',
                'shop' => 'apple.my-shopify.com',
                'service.description' => array(),
            )
        );

        $client = ClientBuilder::factory('Shopify\Shop')
            ->setConfig($config)
            ->build();

        $this->assertInstanceOf('Shopify\Shop\ShopClient', $client);
    }
}
