<?php
/*
 * This file is part of the FNUK package.
 *
 * (c) FILM NATION UK <support@fnuk.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopify\Common\Client;

use Guzzle\Common\Collection;
use Guzzle\Service\Description\ServiceDescription;
use InvalidArgumentException;
use Shopify\Common\Plugin\ApiKeyPlugin;

/**
 * The client builder, influenced heavily from the aws php sdk.
 *
 * Class ClientBuilder
 *
 * @package Fnuk\Sdk\Common\Client
 * @created 30/10/2013 16:44
 * @author  chris
 */
class ClientBuilder
{
    /**
     * Default client config.
     *
     * @var array
     */
    protected static $commonConfigDefaults = array();

    /**
     * Default client requirements.
     *
     * @var array
     */
    protected static $commonConfigRequirements = array('api_key', 'shop', 'service.description');

    /**
     * The config options.
     *
     * @var array
     */
    protected $config = array();

    /**
     * The config defaults.
     *
     * @var array
     */
    protected $configDefaults = array();

    /**
     * The client namespace.
     *
     * @var string
     */
    protected $clientNamespace;

    /**
     * Factory method for creating the client builder
     *
     * @param string $namespace The namespace of the client
     *
     * @return ClientBuilder
     */
    public static function factory($namespace = null)
    {
        return new static($namespace);
    }

    /**
     * Constructs a client builder
     *
     * @param string $namespace The namespace of the client
     */
    public function __construct($namespace = null)
    {
        $this->clientNamespace = $namespace;
    }

    /**
     * Sets the config options
     *
     * @param array|Collection $config The config options
     *
     * @return ClientBuilder
     */
    public function setConfig($config)
    {
        $this->config = $this->processArray($config);

        return $this;
    }

    /**
     * Sets the config options' defaults
     *
     * @param array|Collection $defaults The default values
     *
     * @return ClientBuilder
     */
    public function setConfigDefaults($defaults)
    {
        $this->configDefaults = $this->processArray($defaults);

        return $this;
    }

    /**
     * Performs the building logic using all of the parameters that have been
     * set and falling back to default values. Returns an instantiate service
     * client with credentials prepared and plugins attached.
     *
     * @return AbstractClient
     * @throws InvalidArgumentException
     */
    public function build()
    {
        // Resolve configuration
        $config = Collection::fromConfig(
            $this->config,
            array_merge(self::$commonConfigDefaults, $this->configDefaults),
            self::$commonConfigRequirements
        );

        $description = $this->updateConfigFromDescription($config);

        // Determine service and class name
        $clientClass = 'Shopify\Common\Client\DefaultClient';
        if (null !== $this->clientNamespace) {
            $serviceName = substr($this->clientNamespace, strrpos($this->clientNamespace, '\\') + 1);
            $clientClass = $this->clientNamespace . '\\' . $serviceName . 'Client';
        }

        /** @var $client AbstractClient */
        $client = new $clientClass($config);
        $client->setDescription($description);

//        $client->addSubscriber(
//            new ExceptionListener(
//                new ExceptionFactory(new JsonExceptionParser(),
//                    null === $this->clientNamespace ? ExceptionFactory::DEFAULT_EXCEPTION_CLASS :
//                        "{$this->clientNamespace}\\Exception\\{$serviceName}Exception"
//                )
//            )
//        );

        return $client;
    }


    /**
     * Ensures that an array (e.g. for config data) is actually in array form
     *
     * @param array|Collection $array The array data
     *
     * @return array
     * @throws InvalidArgumentException if the arg is not an array or Collection
     */
    protected function processArray($array)
    {
        if ($array instanceof Collection) {
            $array = $array->getAll();
        }

        if (!is_array($array)) {
            throw new InvalidArgumentException('The config must be provided as an array or Collection.');
        }

        return $array;
    }

    /**
     * Update a configuration object from a service description
     *
     * @param Collection $config Config to update
     *
     * @return ServiceDescription
     * @throws InvalidArgumentException
     */
    protected function updateConfigFromDescription(Collection $config)
    {
        $description = $config->get('service.description');
        if (false === $description instanceof ServiceDescription) {
            if (true === is_string($description)) {
                $description = sprintf($description, $config->get('version'));
            }

            $description = ServiceDescription::factory($description);
            $config->set('service.description', $description);
        }

        return $description;
    }
}