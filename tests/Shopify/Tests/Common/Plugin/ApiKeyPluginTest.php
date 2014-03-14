<?php
/**
 * ApiKeyPluginTest.php
 *
 * @created 09/12/2013 14:13
 * @author chris
 */

namespace Shopify\Tests\Common\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Shopify\Common\Plugin\ApiKeyPlugin;

/**
 * Class ApiKeyPluginTest
 *
 * @package Shopify\Tests\Common\Plugin
 */
class ApiKeyPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Needlessly tests the subscribed events.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new ApiKeyPlugin('foo');

        $this->assertEquals(
            array(
                'request.before_send' => array('onRequestBeforeSend', -1000),
            ),
            $plugin->getSubscribedEvents()
        );
    }

    /**
     * Tests the plugin behaves as expected.
     */
    public function testOnBeforeRequestSend()
    {
        $event = new Event(array('request' => new Request('GET', 'http://localhost')));

        $this->assertFalse($event['request']->hasHeader('X-Shopify-Access-Token'));

        $plugin = new ApiKeyPlugin('foo');
        $plugin->onRequestBeforeSend($event);

        $this->assertTrue($event['request']->hasHeader('X-Shopify-Access-Token'));
        $this->assertEquals('foo', $event['request']->getHeader('X-Shopify-Access-Token'));
    }
}
