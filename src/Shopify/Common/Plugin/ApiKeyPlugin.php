<?php
/**
 * ApiKeyPlugin.php -
 *
 * @created 02/12/2013 14:16
 * @author chris
 */

namespace Shopify\Common\Plugin;


use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApiKeyPlugin implements EventSubscriberInterface
{
    /**
     * The API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     * @return array
     * @throws \InvalidArgumentException
     */
    public function onRequestBeforeSend(Event $event)
    {
        /** @var Request $request */
        $request = $event['request'];
        $request->setHeader('X-Shopify-Access-Token', $this->apiKey);
        $request->setHeader('Content-Type', 'application/json'); // Shouldn't really do this here, naughty!
    }
}