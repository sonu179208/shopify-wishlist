<?php
/**
 * DefaultClient.php -
 *
 * @created 02/12/2013 14:23
 * @author chris
 */

namespace Shopify\Common\Client;


class DefaultClient extends AbstractClient
{
    /**
     * Creates a new client.
     *
     * @param array $config the client config
     *
     * @return DefaultClient the client
     */
    public static function factory($config = array())
    {
        return ClientBuilder::factory()
            ->setConfig($config)
            ->setConfigDefaults(array())
            ->build();
    }
}