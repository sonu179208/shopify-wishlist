<?php
/**
 * The shop service client.
 *
 * @created 02/12/2013 15:08
 * @author chris
 */

namespace Shopify\Shop;


use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getShop(array $args = array()) {@command Shop GetShop}
 *
 * Class ShopClient
 *
 * @package Shopify\Shop
 */
class ShopClient extends AbstractClient
{
    /**
     * The latest API version.
     *
     * @var string
     */
    const LATEST_API_VERSION = '2013-12-09';

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
                        'service.description' => __DIR__ . '/Resources/shop-%s.php'
                    )
                )
                ->build();
    }
}