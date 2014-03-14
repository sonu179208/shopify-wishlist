<?php
/**
  * Tests the shop entity.
  *
  * @created 11/09/2013 10:41
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Tests\Unit\Entity;

use Kurl\Bundle\ShopifyBundle\Entity\Shop;

/**
 * Class ShopTest
 *
 * @package Kurl\Bundle\ShopifyBundle\Tests\Unit\Entity
 */
class ShopTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests entity basics.
     */
    public function testScaffolding()
    {
        $shop = new Shop();

        $this->assertNull($shop->getId());
        $this->assertNull($shop->getHostname());
        $this->assertNull($shop->getAccessToken());

        $shop->setAccessToken('token')
            ->setHostname('example.my-shopify.com');

        $this->assertSame('token', $shop->getAccessToken());
        $this->assertSame('example.my-shopify.com', $shop->getHostname());
    }
}