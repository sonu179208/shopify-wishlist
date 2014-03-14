<?php
/**
  * A liquid response, shopify responses must return a content length.
  *
  * @created 17/09/2013 09:40
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class LiquidResponse
 *
 * @package Kurl\Bundle\ShopifyBundle\Response
 */
class LiquidResponse extends Response
{
    /**
     * Sets the response content.
     *
     * Valid types are strings, numbers, and objects that implement a __toString() method.
     *
     * @param mixed $content
     *
     * @return Response
     *
     * @throws \UnexpectedValueException
     *
     * @api
     */
    public function setContent($content)
    {
        $return = parent::setContent($content);

        $this->headers->set('Content-Length', strlen($this->getContent()));
        $this->headers->set('Content-Type', 'application/liquid');

        return $return;
    }
}