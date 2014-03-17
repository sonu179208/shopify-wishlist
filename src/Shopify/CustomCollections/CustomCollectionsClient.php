<?php
/**
 * CustomCollectionsClient.phpp -
 *
 * @created 02/12/2013 15:08
 * @author chris
 */

namespace Shopify\CustomCollections;


use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getCustomCollections(array $args = array()) {@command CustomCollections GetCustomCollections}
 * @method Model getCustomCollection(array $args = array()) {@command CustomCollections GetCustomCollection}
 * @method Model createCustomCollection(array $args = array()) {@command CustomCollections CreateCustomCollection}
 * @method Model editCustomCollection(array $args = array()) {@command CustomCollections EditCustomCollection}
 * @method Model removeCustomCollections(array $args = array()) {@command CustomCollections RemoveCustomCollections}
 *
 * Class CustomCollectionsClient
 *
 * @package Shopify\CustomCollection
 */
class CustomCollectionsClient extends AbstractClient
{
    /**
     * The latest API version.
     *
     * @var string
     */
    const LATEST_API_VERSION = '2013-12-02';

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
                        'service.description' => __DIR__ . '/Resources/custom_collections-%s.php'
                    )
                )
                ->build();
    }
}