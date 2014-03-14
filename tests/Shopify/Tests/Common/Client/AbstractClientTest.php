<?php

namespace Shopify\Tests\Common\Client;

use Guzzle\Common\Collection;
use Shopify\Common\Shopify;

/**
 * Tests the abstract client.
 *
 * Class AbstractClientTest
 *
 * @created 31/10/2013 09:51
 * @author chris
 */
class AbstractClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the constructor sets everything up correctly.
     */
    public function testConstructor()
    {
        $config = new Collection(
            array(
                'api_key' => 'foo',
                'shop' => 'apple.my-shopify.com',
            )
        );

        /** @var \Shopify\Common\Client\AbstractClient $client */
        $client = $this->getMockBuilder('Shopify\Common\Client\AbstractClient')
            ->setConstructorArgs(array($config))
            ->getMockForAbstractClass();

        $this->assertSame('foo', $client->getApiKey());
        $this->assertSame($config, $client->getConfig());

        // Ensure that the user agent string is correct
        $expectedUserAgent = 'shopify-sdk-php/' . Shopify::VERSION;
        $actualUserAgent = $this->readAttribute($client, 'userAgent');
        $this->assertRegExp("@^{$expectedUserAgent}@", $actualUserAgent);
    }
}