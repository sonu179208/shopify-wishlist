<?php
/**
 * ShopifyClient.phpnt.php -
 * TODO this does not check the signature of return values, it *must*
 * @created 06/09/2013 12:54
 * @author chris
 */

namespace Kurl\Bundle\ShopifyBundle\Service;

use Guzzle\Http\Client;
use Kurl\Bundle\ShopifyBundle\Entity\Shop;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ShopifyClient
 *
 * @package Kurl\Bundle\ShopifyBundle\Service
 */
class ShopifyClient
{
    /**
     * The shopify default hostname.
     * @var string
     */
    const SHOPIFY_HOSTNAME = 'myshopify.com';

    /**
     * The shopify api key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The shopify secret.
     *
     * @var string
     */
    protected $secret;

    /**
     * The shop.
     * @var Shop
     */
    protected $shop;

    /**
     * The default options.
     * @var array
     */
    protected $defaults = array(
        'root_hostname' => self::SHOPIFY_HOSTNAME,
        'authorise_scheme' => 'https',
    );

    /**
     * The client options.
     * @var array
     */
    protected $options;

    /**
     * The http client.
     * @var Client
     */
    protected $httpClient;

    /**
     * Creates a new client.
     *
     * @param Shop   $shop    the shop to poll
     * @param string $apiKey  the api key
     * @param string $secret  the secret
     * @param array  $options the options
     */
    public function __construct(Shop $shop, $apiKey, $secret, array $options = array())
    {
        $this->setShop($shop);
        $this->setApiKey($apiKey);
        $this->setSecret($secret);
        $this->setOptions(array_merge($this->defaults, $options));
    }

    /**
     * Builds an authorisation url.
     *
     * @param array       $scope an array of scopes names
     * @param string|null $redirectUrl the optional callback url TODO the redirect URL seems pointless as it *must* match that used at app creation time
     *
     * @return string the authorisation URL
     */
    public function buildAuthorisationUrl($scope = array(), $redirectUrl = null)
    {
        $params = array(
            'client_id' => $this->getApiKey(),
            'scope' => implode(',', $scope)
        );

        if (null !== $redirectUrl)
        {
            $params['redirect_url'] = $redirectUrl;
        }

        $request = array();

        foreach ($params as $name => $value)
        {
            $request[] = implode('=', array($name, urlencode($value)));
        }

        return $this->getShopUrl() . '/admin/oauth/authorize?' . implode('&', $request);
    }

    /**
     * Gets the shop access token.
     *
     * TODO consider throwing an exception of the token does not exist.
     *
     * @param string $token the temporary token
     *
     * @return string|null the access token
     */
    public function getAccessToken($token)
    {
        $request = $this->getHttpClient()->post(
            '/admin/oauth/access_token',
            array('Accept' => 'application/json'),
            null,
            array(
                'query' => array(
                    'client_id' => $this->getApiKey(),
                    'client_secret' => $this->getSecret(),
                    'code' => $token,
                )
            )
        );

        $json = $request->send()->json();

        return true === array_key_exists('access_token', $json) ? $json['access_token'] : null;
    }

    /**
     * Sets shop.
     *
     * @param Shop $shop
     *
     * @return ShopifyClient
     */
    public function setShop(Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Gets shop.
     *
     * @return Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Gets the shop url.
     *
     * @return string the shop URL
     */
    public function getShopUrl()
    {
        return $this->getOption('authorise_scheme') . '://' . $this->getShop()->getHostname();
    }

    /**
     * Sets the apiKey.
     *
     * @param string $apiKey
     *
     * @return ShopifyClient
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Gets the apiKey.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the secret.
     *
     * @param string $secret the secret
     *
     * @return ShopifyClient
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Gets the secret.
     *
     * @return string the secret
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Sets options.
     *
     * @param array $options
     *
     * @return ShopifyClient
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Gets options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets an option value.
     * @param string $name the option name
     * @param null   $default the value if the option is not set
     *
     * @return mixed the option value
     */
    public function getOption($name, $default = null)
    {
        $options = $this->getOptions();
        return true === array_key_exists($name, $options) ? $options[$name] : $default;
    }

    /**
     * Sets an option value.
     *
     * @param string $name the option name
     * @param mixed $value the option value
     *
     * @return ShopifyClient
     */
    public function setOption($name, $value)
    {
        $this->options[(string)$name] = $value;
        return $this;
    }

    /**
     * Sets http client.
     *
     * @param \Guzzle\Http\Client $httpClient
     *
     * @return ShopifyClient
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Gets http client.
     *
     * @return \Guzzle\Http\Client
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient)
        {
            $this->httpClient = new Client($this->getShopUrl());
        }

        return $this->httpClient;
    }
}