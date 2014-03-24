<?php
/**
 * The customers SDK client.
 *
 * @author chris
 * @created 24/03/2014 10:53
 */

namespace Shopify\Customers;

use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getCustomers(array $args = array()) {@command Customers GetCustomers}
 *
 * Class CustomerClient
 *
 * @package Shopify\CustomerClient
 */
class CustomersClient extends AbstractClient
{
    /**
     * The latest API version.
     *
     * @var string
     */
    const LATEST_API_VERSION = '2014-03-24';

    /**
     * @inheritDoc
     */
    public static function factory($config = array())
    {
        return
            ClientBuilder::factory(__NAMESPACE__)
                ->setConfig($config)
                ->setConfigDefaults(
                    array(
                        'version'             => self::LATEST_API_VERSION,
                        'service.description' => __DIR__ . '/Resources/customers-%s.php'
                    )
                )
                ->build();
    }
}