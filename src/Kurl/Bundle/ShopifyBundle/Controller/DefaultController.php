<?php

namespace Kurl\Bundle\ShopifyBundle\Controller;

use Guzzle\Service\Builder\ServiceBuilderInterface;
use Kurl\Bundle\ShopifyBundle\Entity\Shop;
use Kurl\Bundle\ShopifyBundle\Form\InstallType;
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
        return $this->redirect(
            $this->generateUrl(
                str_replace('_index', '_install', $request->attributes->get('_route')),
                $request->request->all()
            )
        );
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
        /** @var ShopRepository $repo */
        $repo = $this->get('doctrine.orm.entity_manager')->getRepository('Kurl\Bundle\ShopifyBundle\Entity\Shop');

        if (null === $shop = $repo->getByHostName($this->getRequest()->get('shop'))) {
            $shop = new Shop();
            $shop->setHostname($this->getRequest()->get('shop'));
        }

        if (null !== $shop->getAccessToken()) {
            return $this->redirect(
                $this->generateUrl('kurl_shopify_wishlist_installed', array('shop' => $shop->getHostname()))
            );
        }

        $form = $this->createForm(new InstallType(), $shop);

        // TODO the shopify client should maybe not take the shop as a parameter
        $client = new ShopifyClient(
            $shop,
            $this->container->getParameter('kurl.shopify.registry.api_key'),
            $this->container->getParameter('kurl.shopify.registry.secret')
        );

        if (null !== $code = $this->getRequest()->get('code')) {
            $shop->setAccessToken($client->getAccessToken($code));
            $repo->save($shop);

            return $this->redirect(
                $this->generateUrl('kurl_shopify_registry_installed', array('shop' => $shop->getHostname()))
            );
        }

        if (true === $this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                return $this->redirect(
                    $client->buildAuthorisationUrl(
                        $this->container->getParameter('kurl.shopify.registry.scope'),
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

        // TODO the shopify client should maybe not take the shop as a parameter
        $client = new ShopifyClient(
            $shop,
            $this->container->getParameter('kurl.shopify.registry.api_key'),
            $this->container->getParameter('kurl.shopify.registry.secret')
        );

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
        if (null === $this->shop)
        {
            /** @var ShopRepository $repo */
            $repo = $this->get('doctrine.orm.entity_manager')->getRepository('Kurl\Bundle\ShopifyBundle\Entity\Shop');

            if (null === $shop = $repo->getByHostName($this->getRequest()->get('shop')))
            {
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
        if (null === $this->serviceFactory) {
            $this->serviceFactory = Shopify::factory(
                array(
                    'api_key' => $this->getShop()->getAccessToken(),
                    'shop'    => $this->getShop()->getHostname()
                )
            );
        }

        return $this->serviceFactory->get($name);
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

            // TODO the shopify client should maybe not take the shop as a parameter
            $client = new ShopifyClient(
                $shop,
                $this->container->getParameter('kurl.shopify.registry.api_key'),
                $this->container->getParameter('kurl.shopify.registry.secret')
            );

            $response = array(
                'shop'             => $shop->getHostname(),
                'shop_http_scheme' => $client->getOption('authorise_scheme')
            );
        }

        return true === isset($response) ? $response : array();

    }
}
