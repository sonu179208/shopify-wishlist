<?php
/**
 * WishlistController.php -
 *
 * @created 13/03/2014 16:28
 * @author  chris
 */

namespace Kurl\Bundle\ShopifyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kurl\Bundle\ShopifyBundle\Service\WishlistService;
use Symfony\Component\HttpFoundation\Request;

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
     * Redirects to the install page.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Template()
     * @Route("")
     */
    public function indexAction(Request $request)
    {
        return $this->redirect($this->generateUrl('kurl_shopify_wishlist_install'));
    }

    /**
     * Adds a product to the customer's wishlist.
     *
     * @Template()
     * @Route("/add")
     */
    public function addAction()
    {
        $productId  = $this->getRequest()->get('product_id');
        $customerId = $this->getRequest()->get('customer_id');

        $service = new WishlistService($this->getServiceFactory());

        $collect = $service->add($customerId, $productId);

        return array(
            'product_id'  => $productId,
            'collect'     => $collect,
            'customer_id' => $customerId
        );
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