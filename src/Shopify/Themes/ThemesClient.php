<?php
/**
 * ThemesClient.php -
 *
 * @created 02/12/2013 15:08
 * @author chris
 */

namespace Shopify\Themes;

use Shopify\Common\Client\AbstractClient;
use Shopify\Common\Client\ClientBuilder;

/**
 * @method Model getThemes() {@command Themes GetThemes}
 * @method Model getTheme(array $args = array()) {@command Themes GetTheme}
 *
 * Class ThemesClient
 *
 * @package Shopify\Themes
 */
class ThemesClient extends AbstractClient
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
                        'service.description' => __DIR__ . '/Resources/themes-%s.php'
                    )
                )
                ->build();
    }
}