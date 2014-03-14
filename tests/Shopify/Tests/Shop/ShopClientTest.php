<?php

namespace Shopify\Tests\Shop;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\Shop\ShopClient;

/**
 * Status client test.
 *
 * Class StatusClientTest
 *
 * @package Fnuk\Sdk\Tests\Status
 * @created 31/10/2013 12:11
 * @author  chris
 */
class ShopClientTest extends GuzzleTestCase
{
    /**
     * Tests the status client factory.
     */
    public function testFactory()
    {
        $client = ShopClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\Shop\ShopClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests getting the shop details.
     */
    public function testGetShop()
    {
        /** @var ShopClient $client */
        $client = $this->getServiceBuilder()->get('shop');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'shop/get_shop',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getShop();

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(
            array(
                'address1'                             => '1 Infinite Loop',
                'city'                                 => 'Cupertino',
                'country'                              => 'US',
                'created_at'                           => '2007-12-31T19:00:00-05:00',
                'customer_email'                       => 'customers@apple.com',
                'domain'                               => 'shop.apple.com',
                'email'                                => 'steve@apple.com',
                'id'                                   => 690933842,
                'latitude'                             => '45.45',
                'longitude'                            => '-75.43',
                'name'                                 => 'Apple Computers',
                'phone'                                => '1231231234',
                'primary_location_id'                  => null,
                'province'                             => 'California',
                'public'                               => null,
                'source'                               => null,
                'zip'                                  => '95014',
                'country_code'                         => 'US',
                'country_name'                         => 'United States',
                'currency'                             => 'USD',
                'timezone'                             => '(GMT-05:00) Eastern Time (US & Canada)',
                'shop_owner'                           => 'Steve Jobs',
                'money_format'                         => '$ ',
                'money_with_currency_format'           => '$  USD',
                'province_code'                        => 'CA',
                'taxes_included'                       => null,
                'tax_shipping'                         => null,
                'county_taxes'                         => true,
                'plan_display_name'                    => 'Shopify Plus',
                'plan_name'                            => 'enterprise',
                'myshopify_domain'                     => 'apple.myshopify.com',
                'google_apps_domain'                   => null,
                'google_apps_login_enabled'            => null,
                'money_in_emails_format'               => '$',
                'money_with_currency_in_emails_format' => '$ USD',
                'eligible_for_payments'                => true,
                'requires_extra_payments_agreement'    => false,
            ),
            $result->get('shop')
        );

        $this->assertEquals('https://apple.myshopify.com/admin/shop.json', $history->getLastRequest()->getUrl());
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }
}