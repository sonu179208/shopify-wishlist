<?php
/**
 * The shopify client factory.
 *
 * @created 02/12/2013 11:49
 * @author chris
 */

namespace Shopify\Common;

use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Service\Builder\ServiceBuilderInterface;
use Guzzle\Service\Builder\ServiceBuilderLoader;

class Shopify extends ServiceBuilder
{
    /**
     * The current sdk version.
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * Gets the default service definition.
     *
     * @return string
     */
    public static function getDefaultServiceDefinition()
    {
        return __DIR__ . '/Resources/shopify-sdk.php';
    }

    /**
     * Returns the configuration for the service builder
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->builderConfig;
    }

    /**
     * Gets the service builder.
     *
     * @param array  $config the config
     * @param array $globalParameters the global parameters
     *
     * @return ServiceBuilderInterface
     */
    public static function factory($config = null, array $globalParameters = array())
    {
        if (null === $config) {
            $config = self::getDefaultServiceDefinition();
        } elseif (is_array($config)) {
            $globalParameters = $config;
            $config = self::getDefaultServiceDefinition();
        }

        $serviceBuilderLoader = new ServiceBuilderLoader();
        $serviceBuilderLoader->addAlias('_shopify', self::getDefaultServiceDefinition());

        return $serviceBuilderLoader->load($config, $globalParameters);
    }
}