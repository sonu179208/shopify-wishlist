<?php
namespace Shopify\Tests\Common;

use Shopify\Common;

/**
 * Tests the shopify factory.
 *
 * Class ShopifyTest
 *
 * @package Shopify\Tests\Common
 * @created 31/10/2013 15:00
 * @author chris
 */
class ShopifyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     * @expectedExceptionMessage Config is missing the following keys: api_key, shop
     */
    public function testMissingConfigValues()
    {
        $client = Common\Shopify::factory();
        $client->get('shop');
    }

    /**
     * Tests the factory.
     */
    public function testFactory()
    {
        $builder = Common\Shopify::factory(
            array(
                'api_key' => 'gobble-de-gook',
                'shop' => 'apple.myshopify.com',
            )
        );

        $this->assertNotNull($builder->get('shop'));
        $this->assertArrayHasKey('shop', $builder->getConfig());
    }

    /**
     * Checks that the config parameters are forced into globals.
     */
    public function testTreatsArrayInFirstArgAsGlobalParametersUsingDefaultConfigFile()
    {
        $builder = Common\Shopify::factory(
            array(
                'api_key' => 'gobble-de-gook',
                'shop' => 'apple.myshopify.com',
            )
        );

        $this->assertEquals('gobble-de-gook', $builder->get('shop')->getConfig('api_key'));
        $this->assertEquals('apple.myshopify.com', $builder->get('shop')->getConfig('shop'));
    }
}