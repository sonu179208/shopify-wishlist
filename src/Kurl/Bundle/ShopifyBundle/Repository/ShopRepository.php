<?php
/**
  * The shop repository.
  *
  * @created 11/09/2013 10:06
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Kurl\Bundle\ShopifyBundle\Entity\Shop;

/**
 * Class ShopRepository
 *
 * @package Kurl\Bundle\ShopifyBundle\Repository
 */
class ShopRepository extends EntityRepository
{
    /**
     * Saves a shop.
     *
     * @param Shop $shop the shop
     *
     * @return ShopRepository
     */
    public function save(Shop $shop)
    {
        $em = $this->getEntityManager();
        $em->persist($shop);
        $em->flush();
        return $this;
    }

    /**
     * Gets a shop by hostname.
     *
     * @param $hostname
     *
     * @return Shop|null
     */
    public function getByHostName($hostname)
    {
        return $this
            ->createQueryBuilder('s')
            ->where('s.hostname = :hostname')
            ->setParameter('hostname', $hostname)
            ->getQuery()
            ->getOneOrNullResult();
    }
}