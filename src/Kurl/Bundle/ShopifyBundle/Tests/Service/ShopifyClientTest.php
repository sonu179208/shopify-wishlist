<?php
/**
  * Tests the shopify client.
  *
  * @created 06/09/2013 14:50
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Tests\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Kurl\Bundle\ShopifyBundle\Service\ShopifyClient;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ShopifyClient
 *
 * @package Kurl\Bundle\ShopifyBundle\Tests\Service
 */
class ShopifyClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basics
     */
    public function testScaffolding()
    {
        $client = new ShopifyClient($this->getStubRequest(), 'key', 'secret');

        $this->assertSame('key', $client->getApiKey());
        $this->assertSame('secret', $client->getSecret());
        $this->assertSame('https', $client->getOption('authorise_scheme'));
        $this->assertSame('myshopify.com', $client->getOption('root_hostname'));
        $this->assertNull($client->getOption('cheese'));

        $client->setOption('cheese', 'brie');
        $this->assertSame('brie', $client->getOption('cheese'));

        $client = new ShopifyClient(
            $this->getStubRequest(),
            'key',
            'secret',
            array(
                'root_hostname' => 'example.com',
                'authorise_scheme' => 'http'
            )
        );
        $this->assertSame('example.com', $client->getOption('root_hostname'));
        $this->assertSame('http', $client->getOption('authorise_scheme'));

        $client->setOption('authorise_scheme', 'ftp');
        $this->assertSame('ftp', $client->getOption('authorise_scheme'));

        $this->assertInstanceOf('Guzzle\Http\Client', $client->getHttpClient());
        $this->assertSame('ftp://example.myshopify.com', $client->getHttpClient()->getBaseUrl());

        $client->setHttpClient(new Client());
        $this->assertSame('', $client->getHttpClient()->getBaseUrl());
    }

    /**
     * Tests the url builder.
     */
    public function testUrlBuilder()
    {
        $client = new ShopifyClient($this->getStubRequest(), 'key', 'secret');
        $this->assertSame(
            'https://example.myshopify.com/admin/oauth/authorize?client_id=key&scope=write_products%2Cread_orders',
            $client->buildAuthorisationUrl(array('write_products','read_orders'))
        );

        $this->assertSame(
            'https://example.myshopify.com/admin/oauth/authorize?client_id=key&scope=write_products%2Cread_orders&redirect_url=http%3A%2F%2Fexample.com%2Fcallback%3Ffoo%3Dbar',
            $client->buildAuthorisationUrl(array('write_products','read_orders'), 'http://example.com/callback?foo=bar')
        );
    }

    /**
     * Tests converting a request token into an access token.
     */
    public function testGetAccessToken()
    {
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200, array('Content-Type' => 'application/json'), '{"access_token":"bar"}'));
        $mock = new Client();
        $mock->addSubscriber($plugin);

        $client = new ShopifyClient($this->getStubRequest(), 'key', 'secret');
        $client->setHttpClient($mock);

        $this->assertSame('bar', $client->getAccessToken('foo'));
    }

    /**
     * Gets an example shop.
     *
     * @return Request the example shop name
     */
    protected function getStubRequest()
    {
        return new Request(array(), array('shop' => 'example.myshopify.com'));
    }
}