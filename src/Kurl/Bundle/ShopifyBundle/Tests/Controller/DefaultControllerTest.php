<?php

namespace Kurl\Bundle\ShopifyBundle\Tests\Controller;

use Guzzle\Http\Client;
use Guzzle\Plugin\Mock\MockPlugin;
use Kurl\Common\Test\Fixture\JsonDataSet;
use Kurl\Common\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package Kurl\Bundle\ShopifyBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Tests the index page renders OK.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Nothing to see here")')->count() > 0);
    }

    /**
     * Tests the preferences page.
     */
    public function testPreferences()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/preferences');

        $this->assertEquals(1, $crawler->filter('html:contains("Application Preferences")')->count());
        $this->assertEquals(0, $crawler->filter('a:contains("Visit shop")')->count());

        $crawler = $client->request('GET', '/preferences?shop=foo.myshopify.com');

        $this->assertEquals(1, $crawler->filter('html:contains("Application Preferences")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Visit shop")')->count());
    }

    /**
     * Tests the support page.
     */
    public function testSupport()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/support');

        $this->assertEquals(1, $crawler->filter('html:contains("Application Support")')->count());
        $this->assertEquals(0, $crawler->filter('a:contains("Visit shop")')->count());

        $crawler = $client->request('GET', '/support?shop=foo.myshopify.com');

        $this->assertEquals(1, $crawler->filter('html:contains("Application Support")')->count());
        $this->assertEquals(1, $crawler->filter('a:contains("Visit shop")')->count());
    }

    /**
     * Test the app is installed already.
     */
    public function testInstalled()
    {
        /** @var \Symfony\Bundle\FrameworkBundle\Client $client */
        $client = static::$kernel->getContainer()->get('test.client');

        $client->request('GET', '/install?shop=example.myshopify.com');

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('location', '/wishlist/installed/example.myshopify.com'));
        $this->assertEquals(1, $client->followRedirect()->filter('html:contains("Application installed")')->count());
    }

    /**
     * Tests the installing an application step with a code.
     */
    public function testInstallWithCode()
    {
        /** @var \Symfony\Bundle\FrameworkBundle\Client $client */
//        $client = static::$kernel->getContainer()->get('test.client');
//
//        $this->setMockResponse(
//            static::$kernel->getContainer()->get('kurl_shopify.shopify_client')->getHttpClient(),
//            array('shopify_client/get_access_token')
//        );
//
//        $client->request('GET', '/install?shop=example2.myshopify.com&code=hello');
//
//
//        /** @var \Symfony\Component\HttpFoundation\Response $response */
//        $response = $client->getResponse();

        //$this->assertTrue($response->headers->contains('location', '/wishlist/installed/example2.myshopify.com'));
        //$this->assertEquals(1, $client->followRedirect()->filter('html:contains("Application installed")')->count());
    }

    /**
     * Sets the mock response on a client.
     *
     * @param Client       $client
     * @param array|string $paths paths to the mock responses
     *
     * @return MockPlugin the mock plugin
     */
    protected function setMockResponse(Client $client, $paths)
    {
        $mock = new MockPlugin(null, true);
        $client->getEventDispatcher()->removeSubscriber($mock);

        foreach ((array) $paths as $path) {
            $mock->addResponse(MockPlugin::getMockFile(__DIR__ . '/../../../../../../tests/mock' . DIRECTORY_SEPARATOR . $path));
        }

        $client->getEventDispatcher()->addSubscriber($mock);

        return $mock;
    }

    /**
     * @inheritDoc
     */
    protected function getDataSet()
    {
        return JsonDataSet::fromFile(__DIR__ . '/Fixture/shop.json');
    }
}
