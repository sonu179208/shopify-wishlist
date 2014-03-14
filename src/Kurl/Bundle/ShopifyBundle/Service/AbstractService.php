<?php
/**
  * An abstract ORM service.
  *
  * @created 11/09/2013 16:09
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class AbstractService
 *
 * @package Kurl\Bundle\ShopifyBundle\Service
 */
class AbstractService
{
    /**
     * The entity manager.
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * The entity name.
     * @var string
     */
    protected $entityName;

    /**
     * Ctor.
     *
     * @param EntityManager $em the entity manager
     * @param string        $entityName the entity name
     */
    public function __construct(EntityManager $em, $entityName)
    {
        $this->setEntityManager($em);
        $this->setEntityName($entityName);
    }

    /**
     * Sets the entityManager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     *
     * @return RegistryService
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Gets the entityManager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Sets entityName.
     *
     * @param string $entityName
     *
     * @return AbstractService
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * Gets entityName.
     *
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Gets the entity repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityName());
    }
}