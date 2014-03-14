<?php
/**
  * A shop entity.
  *
  * @created 09/09/2013 10:53
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Shop
 *
 * @package Kurl\Bundle\ShopifyBundle\Entity
 *
 * @ORM\Table(name="shopify_shop")
 * @ORM\Entity(repositoryClass="Kurl\Bundle\ShopifyBundle\Repository\ShopRepository")
 */
class Shop
{
    /**
     * The shop Id.
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * TODO rename this value to myshopify_domain to reflect the name in the API response
     *
     * The shop url.
     * @var string
     *
     * @ORM\Column(name="myshopify_domain", type="string", length=255, nullable=false)
     */
    private $hostname;

    /**
     * The access token.
     *
     * @ORM\Column(name="access_token", type="string", length=255, nullable=true)
     * @var string
     */
    private $accessToken;

    /**
     * Ctor.
     */
    function __construct()
    {
        $this->registries = new ArrayCollection();
    }

    /**
     * Gets the shop Id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets shop hostname.
     *
     * @param string $hostname
     *
     * @return Shop
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Gets the shop hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Sets access token.
     *
     * @param string $accessToken
     *
     * @return Shop
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Gets access token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}