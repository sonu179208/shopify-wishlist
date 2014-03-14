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
        $service = new WishlistService($this->serviceFactory);
        $added = $service->add($this->getRequest()->get('customer_id'), $this->getRequest()->get('product_id'));
    }
}