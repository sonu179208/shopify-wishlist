<?php
/**
  * ShopRepositoryTest.php -
  *
  * @created 11/09/2013 13:50
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Tests\Repository;

use Kurl\Bundle\ShopifyBundle\Entity\Shop;
use Kurl\Bundle\ShopifyBundle\Repository\ShopRepository;
use Kurl\Common\Test\OrmTestCase;

class ShopRepositoryTest extends OrmTestCase
{
    /**
     * Tests getByHostname
     */
    public function testGetByHostname()
    {
        $repo = $this->getRepository();

        $this->assertNull($repo->getByHostName('example.myshopify.com'));

        $shop = new Shop();
        $shop->setHostname('example.myshopify.com');
        $repo->save($shop);

        unset($shop);

        $shop = $repo->getByHostName('example.myshopify.com');

        $this->assertNotNull($shop);
        $this->assertInstanceOf('Kurl\Bundle\ShopifyBundle\Entity\Shop', $shop);
        $this->assertSame('example.myshopify.com', $shop->getHostname());
        $this->assertNull($shop->getAccessToken());
        $this->assertNotNull($shop->getId());
    }

    /**
     * Gets the entity paths.
     *
     * @return array the entity paths
     */
    protected function getEntityPaths()
    {
        return array(
            __DIR__ . '/../../Entity/',
        );
    }

    /**
     * Gets a shop repo.
     *
     * @return ShopRepository
     */
    private function getRepository()
    {
        return new ShopRepository(
            $this->getEntityManager(),
            $this->getEntityManager()->getClassMetadata('Kurl\Bundle\ShopifyBundle\Entity\Shop')
        );
    }
}