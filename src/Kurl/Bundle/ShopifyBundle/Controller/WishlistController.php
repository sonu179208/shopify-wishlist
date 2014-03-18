<?php
/**
 * WishlistController.php -
 *
 * @created 13/03/2014 16:28
 * @author  chris
 */

namespace Kurl\Bundle\ShopifyBundle\Controller;

use Kurl\Bundle\ShopifyBundle\Response\LiquidResponse;
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

        $parameters = array(
            'product_id'  => $productId,
            'customer_id' => $customerId
        );

        try {
            $parameters['collect'] = $service->add($customerId, $productId);
        } catch (\Exception $e) {
            $parameters['error_message'] = $e->getMessage();
        }

        return $this->getResponse(
            $this->container
                ->get('templating')
                ->render('KurlShopifyBundle:Wishlist:add.html.twig', $parameters)
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
        $productId  = $this->getRequest()->get('product_id');
        $customerId = $this->getRequest()->get('customer_id');

        $service = new WishlistService($this->getServiceFactory());

        $parameters = array(
            'product_id'  => $productId,
            'customer_id' => $customerId
        );

        try {
            $service->remove($customerId, $productId);
        } catch (\Exception $e) {
            $parameters['error_message'] = $e->getMessage();
        }

        return $this->getResponse(
            $this->container
                ->get('templating')
                ->render('KurlShopifyBundle:Wishlist:remove.html.twig', $parameters)
        );
    }
}