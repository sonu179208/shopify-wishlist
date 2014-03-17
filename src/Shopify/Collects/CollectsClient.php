<?php
/**
 * CollectsClient.php -
 *
 * @created 02/12/2013 15:08
 * @author chris
 */

namespace Shopify\Collects;

use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getCollects(array $args = array()) {@command Collects GetCollects}
 * @method Model addToCollection(array $args = array()) {@command Collects AddToCollection}
 * @method Model removeFromCollection(array $args = array()) {@command Collects RemoveFromCollection}
 *
 * Class CollectsClient
 *
 * @package Shopify\CustomCollection
 */
class CollectsClient extends AbstractClient
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
                        'service.description' => __DIR__ . '/Resources/collects-%s.php'
                    )
                )
                ->build();
    }
}