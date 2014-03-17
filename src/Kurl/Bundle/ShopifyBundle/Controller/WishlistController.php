<?php
/**
 * WishlistController.php -
 *
 * @created 13/03/2014 16:28
 * @author chris
 */

namespace Kurl\Bundle\ShopifyBundle\Controller;

use Kurl\Bundle\ShopifyBundle\Service\WishlistService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class WishlistController
 *
 * @package Kurl\Bundle\ShopifyBundle\Controller
 *
 * @Route("/wishlist")
 */
class WishlistController extends DefaultController
{
    /**
     * Adds a product to the customer's wishlist.
     *
     * @Template()
     * @Route("/add")
     */
    public function addAction()
    {
        $service = new WishlistService($this->getServiceFactory());
        $added = $service->add($this->getRequest()->get('customer_id'), $this->getRequest()->get('product_id'));
    }

    /**
     * Removes a product from the customer's wishlist.
     *
     * @Template()
     * @Route("/remove")
     */
    public function removeAction()
    {
        $service = new WishlistService($this->getServiceFactory());
        $removed = $service->remove($this->getRequest()->get('customer_id'), $this->getRequest()->get('product_id'));
    }
}