<?php
/**
 * AbstractClient.php -
 *
 * @created 02/12/2013 14:24
 * @author chris
 */

namespace Shopify\Common\Client;

use Guzzle\Common\Collection;
use Guzzle\Service\Client as GuzzleClient;
use Shopify\Common\Plugin\ApiKeyPlugin;
use Shopify\Common\Shopify;

/**
 * The abstract http client.
 *
 * Class AbstractClient
 *
 * @package Fnuk\Sdk\Common\Client
 * @created 30/10/2013 16:49
 * @author  chris
 */
abstract class AbstractClient extends GuzzleClient
{
    /**
     * The credentials.
     *
     * @var Credentials
     */
    protected $apiKey;

    /**
     * Creates a new client.
     *
     * @param \Guzzle\Common\Collection|null $config
     */
    public function __construct(Collection $config = null)
    {
        parent::__construct($this->getEndpoint($config), $config);
        $this->setApiKey($config->get('api_key'));
        $this->setUserAgent('shopify-sdk-php/' . Shopify::VERSION);

        $this->addSubscriber(new ApiKeyPlugin($this->getApiKey()));
    }

    /**
     * Sets credentials.
     *
     * @param string $apiKey
     *
     * @return AbstractClient
     */
    public function setApiKey($apiKey = null)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Gets credentials.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiVersion()
    {
        return $this->serviceDescription->getApiVersion();
    }

    /**
     * @param Collection $config
     *
     * @return string
     */
    protected function getEndpoint(Collection $config)
    {
        return 'https://' . $config->get('shop');
    }
}