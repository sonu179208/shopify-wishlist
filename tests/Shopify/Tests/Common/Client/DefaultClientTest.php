<?php
/*
 * This file is part of the FNUK package.
 *
 * (c) FILM NATION UK <support@fnuk.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopify\Tests\Common\Client;

use Shopify\Common\Client\DefaultClient;

/**
 * Exercises the default client.
 *
 * Class DefaultClientTest
 *
 * @package Fnuk\Sdk\Tests\Common\Credentials
 * @created 31/10/2013 10:13
 * @author chris
 */
class DefaultClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default client factory.
     */
    public function testClientFactory()
    {
        $client = DefaultClient::factory(
            array(
                'api_key'             => 'foo',
                'shop'                => 'apple.my-shopify.com',
                'version'             => '0.0.1',
                'service.description' => __DIR__ . '/Fixture/stub-%s.php'
            )
        );

        $this->assertSame('foo', $client->getApiKey());
        $this->assertSame('https://apple.my-shopify.com', $client->getBaseUrl());
        $this->assertSame('0.0.1', $client->getApiVersion());
    }
}