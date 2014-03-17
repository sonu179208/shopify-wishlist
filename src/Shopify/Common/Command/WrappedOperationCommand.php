<?php
/**
 * Wraps command parameters in a parent node.
 *
 * @created 04/11/2013 15:46
 * @author chris
 */
namespace Shopify\Common\Command;

use Guzzle\Service\Command\OperationCommand as GuzzleOperationCommand;
use Guzzle\Service\Description\Operation;
use Guzzle\Service\Description\OperationInterface;

/**
 *
 * Class WrappedOperationCommand
 *
 * @package Shopify\Common\Command
 */
class WrappedOperationCommand extends GuzzleOperationCommand
{
    /**
     * Creates a new wrapper command.
     *
     * @param array              $parameters the operation parameters
     * @param OperationInterface $operation the operation
     */
    public function __construct($parameters = array(), OperationInterface $operation = null)
    {
        if (true === $operation instanceof Operation)
        {
            /** @var Operation $operation */
            if (null !== $operation->getAdditionalParameters() &&
                null !== $requestWrapperNode = $operation->getAdditionalParameters()->getData('requestWrapperNode'))
            {
                if (true === $operation->hasParam($requestWrapperNode))
                {
                    /** @var \Guzzle\Service\Description\Parameter $param */
                    $param = $operation->getParam($requestWrapperNode);
                    $wrapped = array();

                    // Ensure only the keys within the service definition for the wrapper node are injected.
                    foreach(array_keys($param->parameters) as $name) {
                        if (true === array_key_exists($name, $parameters)) {
                            $wrapped[$name] = $parameters[$name];
                            unset($parameters[$name]);
                        }
                    }

                    if (false === empty($wrapped))
                    {
                        $parameters[$requestWrapperNode] = $wrapped;
                    }
                }
            }
        }

        parent::__construct($parameters, $operation);
    }
}