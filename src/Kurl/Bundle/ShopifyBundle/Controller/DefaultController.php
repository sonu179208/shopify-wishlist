<?php

namespace Kurl\Bundle\ShopifyBundle\Controller;

use Guzzle\Service\Builder\ServiceBuilderInterface;
use Kurl\Bundle\ShopifyBundle\Entity\Shop;
use Kurl\Bundle\ShopifyBundle\Form\InstallType;
use Kurl\Bundle\ShopifyBundle\Repository\ShopRepository;
use Kurl\Bundle\ShopifyBundle\Service\ShopifyClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shopify\Common\Shopify;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * The current shop.
     *
     * @var Shop
     */
    protected $shop;

    /**
     * A collection of clients.
     *
     * @var ServiceBuilderInterface
     */
    protected $serviceFactory;

    /**
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
        return array();
    }

    /**
     * Installs the app.
     *
     * @return array
     *
     * @Template()
     * @Route("/install")
     */
    public function installAction()
    {
        $shop = $this->getShop();

        if (null !== $shop->getAccessToken()) {
            return $this->redirect(
                $this->generateUrl('kurl_shopify_wishlist_installed', array('shop' => $shop->getHostname()))
            );
        }

        $form = $this->createForm(new InstallType(), $shop);

        /** @var ShopifyClient $client */
        $client = $this->container->get('kurl_shopify.shopify_client');

        if (null !== $code = $this->getRequest()->get('code')) {
            /** @var ShopRepository $repo */
            $repo = $this->get('doctrine.orm.entity_manager')->getRepository('Kurl\Bundle\ShopifyBundle\Entity\Shop');
            $shop->setAccessToken($client->getAccessToken($code));
            $repo->save($shop);

            return $this->redirect(
                $this->generateUrl('kurl_shopify_default_installed', array('shop' => $shop->getHostname()))
            );
        }

        if (true === $this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                return $this->redirect(
                    $client->buildAuthorisationUrl(
                        $this->container->getParameter('kurl.shopify.wishlist.scope'),
                        $this->generateUrl(
                            'kurl_shopify_wishlist_authorise',
                            array(),
                            UrlGeneratorInterface::ABSOLUTE_URL
                        )
                    )
                );
            }
        }

        return array(
            'form'             => $form->createView(),
            'shop_http_scheme' => $client->getOption('authorise_scheme')
        );
    }

    /**
     * Displays a confirmation message.
     *
     * @Template()
     * @Route("/installed/{shop}")
     */
    public function installedAction()
    {
        $shop = new Shop();
        $shop->setHostname($this->getRequest()->get('shop'));

        /** @var ShopifyClient $client */
        $client = $this->container->get('kurl_shopify.shopify_client');

        return array(
            'shop'             => $shop->getHostname(),
            'shop_http_scheme' => $client->getOption('authorise_scheme')
        );
    }

    /**
     * Installs the app.
     *
     * @return array
     *
     * @Template()
     * @Route("/authorise")
     */
    public function authoriseAction()
    {
        return array();
    }

    /**
     * Displays the app preferences page.
     *
     * @Template()
     * @Route("/preferences")
     */
    public function preferencesAction(Request $request)
    {
        return $this->getShopResponse($request);
    }

    /**
     * Displays the app support page.
     *
     * @Template()
     * @Route("/support")
     */
    public function supportAction(Request $request)
    {
        return $this->getShopResponse($request);
    }

    /**
     * Gets the shop from the current request.
     * TODO this needs some work, it will explode if used incorrectly.
     *
     * @return Shop
     */
    protected function getShop()
    {
        if (null === $this->shop) {
            /** @var ShopRepository $repo */
            $repo = $this->get('doctrine.orm.entity_manager')->getRepository('Kurl\Bundle\ShopifyBundle\Entity\Shop');

            if (null === $shop = $repo->getByHostName($this->getRequest()->get('shop'))) {
                $shop = new Shop();
                $shop->setHostname($this->getRequest()->get('shop'));
            }

            $this->shop = $shop;
        }

        return $this->shop;
    }

    /**
     * Gets an SDk client by name.
     *
     * @param string $name the client name
     *
     * @return \Guzzle\Service\ClientInterface the client
     */
    protected function getClient($name)
    {
        return $this->getServiceFactory()->get($name);
    }

    /**
     * Gets a vanilla response for shop requests.
     *
     * @param Request $request the request
     *
     * @return array
     */
    protected function getShopResponse(Request $request)
    {
        if (null !== $shopId = $request->get('shop')) {
            $shop = new Shop();
            $shop->setHostname($shopId);

            /** @var ShopifyClient $client */
            $client = $this->container->get('kurl_shopify.shopify_client');

            $response = array(
                'shop'             => $shop->getHostname(),
                'shop_http_scheme' => $client->getOption('authorise_scheme')
            );
        }

        return true === isset($response) ? $response : array();
    }

    /**
     * Gets the service factory.
     *
     * @return \Guzzle\Service\Builder\ServiceBuilderInterface
     */
    protected function getServiceFactory()
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = Shopify::factory(
                array(
                    'api_key' => $this->getShop()->getAccessToken(),
                    'shop'    => $this->getShop()->getHostname()
                )
            );
        }

        return $this->serviceFactory;
    }
}
