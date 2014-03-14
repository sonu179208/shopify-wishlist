<?php
/**
  * LiquidResponseTest.php -
  *
  * @created 17/09/2013 09:42
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Tests\Unit\Response;


use Kurl\Bundle\ShopifyBundle\Response\LiquidResponse;

class LiquidResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that content length exists and is not null.
     */
    public function testContentLength()
    {
        $response = new LiquidResponse('{"test":"value"}');

        $this->assertSame('application/liquid', $response->headers->get('Content-Type'));
        $this->assertNotNull($response->headers->get('Content-Length'));
        $this->assertSame(16, $response->headers->get('Content-Length'));

        $response->setContent("This is a new string, it is longer than the last!");
        $this->assertNotNull($response->headers->get('Content-Length'));
        $this->assertSame(49, $response->headers->get('Content-Length'));
    }
}