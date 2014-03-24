<?php
/**
 * Tests the customers client.
 *
 * @author  chris
 * @created 24/03/2014 11:04
 */

namespace Shopify\Tests\Customers;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\Customers\CustomersClient;

/**
 * Class CustomersClientTest
 *
 * @package Shopify\Tests\Customers
 */
class CustomersClientTest extends GuzzleTestCase
{
    /**
     * Tests the customers client factory.
     */
    public function testFactory()
    {
        $client = CustomersClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\Customers\CustomersClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests getting the asset list.
     */
    public function testGetAssets()
    {
        /** @var CustomersClient $client */
        $client = $this->getServiceBuilder()->get('customers');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'customers/get_customers',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getCustomers(array('query' => 'Bob'));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(1, count($result->get('customers')));

        $this->assertEquals(
            array(
                array(
                    'accepts_marketing'    => false,
                    'created_at'           => '2014-03-19T16:25:37-04:00',
                    'email'                => 'bob.norman@hostmail.com',
                    'first_name'           => 'Bob',
                    'id'                   => 207119551,
                    'last_name'            => 'Norman',
                    'last_order_id'        => null,
                    'multipass_identifier' => null,
                    'note'                 => null,
                    'orders_count'         => 0,
                    'state'                => 'disabled',
                    'total_spent'          => '0.00',
                    'updated_at'           => '2014-03-19T16:25:37-04:00',
                    'verified_email'       => true,
                    'tags'                 => '',
                    'last_order_name'      => null,
                    'default_address'      =>
                        array(
                            'address1'      => 'Chestnut Street 92',
                            'address2'      => '',
                            'city'          => 'Louisville',
                            'company'       => null,
                            'country'       => 'United States',
                            'first_name'    => null,
                            'id'            => 207119551,
                            'last_name'     => null,
                            'phone'         => '555-625-1199',
                            'province'      => 'Kentucky',
                            'zip'           => '40202',
                            'name'          => null,
                            'province_code' => 'KY',
                            'country_code'  => 'US',
                            'country_name'  => 'United States',
                            'default'       => true,
                        ),
                    'addresses'            =>
                        array(
                            array(
                                'address1'      => 'Chestnut Street 92',
                                'address2'      => '',
                                'city'          => 'Louisville',
                                'company'       => null,
                                'country'       => 'United States',
                                'first_name'    => null,
                                'id'            => 207119551,
                                'last_name'     => null,
                                'phone'         => '555-625-1199',
                                'province'      => 'Kentucky',
                                'zip'           => '40202',
                                'name'          => null,
                                'province_code' => 'KY',
                                'country_code'  => 'US',
                                'country_name'  => 'United States',
                                'default'       => true,
                            ),
                        ),
                ),
            ),
            $result->get('customers')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/customers/search.json?query=Bob',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }

    public function testGetCustomer()
    {
        /** @var CustomersClient $client */
        $client = $this->getServiceBuilder()->get('customers');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'customers/get_customer',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getCustomer(array('id' => 207119551));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);

        $this->assertEquals(
            array(
                'accepts_marketing'    => false,
                'created_at'           => '2014-03-19T16:25:51-04:00',
                'email'                => 'bob.norman@hostmail.com',
                'first_name'           => 'Bob',
                'id'                   => 207119551,
                'last_name'            => 'Norman',
                'last_order_id'        => null,
                'multipass_identifier' => null,
                'note'                 => null,
                'orders_count'         => 0,
                'state'                => 'disabled',
                'total_spent'          => '0.00',
                'updated_at'           => '2014-03-19T16:25:51-04:00',
                'verified_email'       => true,
                'tags'                 => '',
                'last_order_name'      => null,
                'default_address'      => array(
                    'address1'      => 'Chestnut Street 92',
                    'address2'      => '',
                    'city'          => 'Louisville',
                    'company'       => null,
                    'country'       => 'United States',
                    'first_name'    => null,
                    'id'            => 207119551,
                    'last_name'     => null,
                    'phone'         => '555-625-1199',
                    'province'      => 'Kentucky',
                    'zip'           => '40202',
                    'name'          => null,
                    'province_code' => 'KY',
                    'country_code'  => 'US',
                    'country_name'  => 'United States',
                    'default'       => true,
                ),
                'addresses'            => array(
                    array(
                        'address1'      => 'Chestnut Street 92',
                        'address2'      => '',
                        'city'          => 'Louisville',
                        'company'       => null,
                        'country'       => 'United States',
                        'first_name'    => null,
                        'id'            => 207119551,
                        'last_name'     => null,
                        'phone'         => '555-625-1199',
                        'province'      => 'Kentucky',
                        'zip'           => '40202',
                        'name'          => null,
                        'province_code' => 'KY',
                        'country_code'  => 'US',
                        'country_name'  => 'United States',
                        'default'       => true,
                    ),
                ),
            ),
            $result->get('customer')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/customers/207119551.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }
}
