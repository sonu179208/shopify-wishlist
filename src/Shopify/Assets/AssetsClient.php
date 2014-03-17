<?php
/**
 * AssetsClient.php -
 *
 * @created 02/12/2013 15:08
 * @author chris
 */

namespace Shopify\Assets;

use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getAssets(array $args = array()) {@command Assets GetAssets}
 * @method Model getAsset(array $args = array()) {@command Assets GetAsset}
 * @method Model createAsset(array $args = array()) {@command Assets CreateAsset}
 *
 * Class AssetsClient
 *
 * @package Shopify\Assets
 */
class AssetsClient extends AbstractClient
{
    /**
     * The latest API version.
     *
     * @var string
     */
    const LATEST_API_VERSION = '2013-12-31';

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
                        'service.description' => __DIR__ . '/Resources/assets-%s.php'
                    )
                )
                ->build();
    }
}