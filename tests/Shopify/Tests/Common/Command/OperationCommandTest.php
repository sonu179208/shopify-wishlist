<?php
/**
 * Basic tests on the shopify operation command.
 *
 * @created 04/11/2013 16:02
 * @author chris
 */

namespace Shopify\Tests\Common\Command;

use Shopify\Common\Client\DefaultClient;
use Shopify\Common\Command\WrappedOperationCommand;
use Shopify\Common\Command\RequestSerializer;
use Guzzle\Service\Description\Operation;
use Guzzle\Service\Description\ServiceDescription;

/**
 *
 * Class OperationCommandTest
 *
 * @package Shopify\Tests\Common\Command
 */
class OperationCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default behaviour is not affected.
     */
    public function testWrapperKeyVanilla()
    {
        $operation = new Operation();
        $command = new WrappedOperationCommand(array('param1' => 'foo'), $operation);
        $command->setClient(
            DefaultClient::factory(
                array(
                    'service.description' => array(),
                    'api_key' => 'foo',
                    'shop' => 'apple.my-shopify.com',
                )
            )
        );
        $command->prepare();
        $this->assertSame('foo', $command->get('param1'));
        $this->assertNull($command->get('present'));
    }

    /**
     * Tests that the wrapper key is set correctly.
     */
    public function testWrapperKey()
    {
        $description = new ServiceDescription(
            array(
                'operations' => array(
                    'foo' => array(
                        'responseClass'        => 'bar',
                        'responseType'         => 'model',
                        'additionalParameters' => array(
                            'requestWrapperNode' => 'present'
                        ),
                        'parameters'           => array(
                            'id' => array(
                                'location' => 'json',
                                'type'     => 'numeric',
                                'required' => true,
                            ),
                            'present' => array(
                                'name'       => 'present',
                                'type'       => 'array',
                                'location'   => 'json',
                                'required'   => true,
                                'parameters' => array(
                                    'param1' => array(
                                        'location' => 'json',
                                        'type'     => 'string',
                                        'required' => true,
                                    ),
                                )
                            )
                        )
                    )
                ),
                'models'     => array('bar' => array())
            )
        );

        $command = new WrappedOperationCommand(array('param1' => 'foo', 'id' => 1), $description->getOperation('foo'));
        $command->setClient(
            DefaultClient::factory(
                array(
                    'service.description' => array(),
                    'api_key' => 'foo',
                    'shop' => 'apple.my-shopify.com',
                )
            )
        );
        $command->prepare();

        $this->assertSame(array('param1' => 'foo'), $command->get('present'));
        $this->assertSame(1, $command->get('id'));
    }
}