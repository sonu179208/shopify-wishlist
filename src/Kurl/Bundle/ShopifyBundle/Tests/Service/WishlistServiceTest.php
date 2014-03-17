<?php
/**
 * Tests the wishlist service.
 *
 * @created 17/03/2014 14:42
 * @author  chris
 */

namespace Kurl\Bundle\ShopifyBundle\Tests\Service;

use Guzzle\Tests\GuzzleTestCase;
use Kurl\Bundle\ShopifyBundle\Service\WishlistService;
use Shopify\Common\Shopify;

/**
 * Class WishlistServiceTest
 *
 * @package Kurl\Bundle\ShopifyBundle\Tests\Service
 */
class WishlistServiceTest extends GuzzleTestCase
{
    /**
     * Tests adding a product to a wish list including all the hoops to jump through to create a new collection.
     */
    public function testAdd()
    {
        $builder = $this->getServiceBuilderInterface();

        $service = new WishlistService($builder);

        $this->setMockResponse(
            $builder->get('custom_collections'),
            array(
                'wishlist_service/get_custom_collections_empty',
                'wishlist_service/post_custom_collections',
            )
        );

        $this->setMockResponse(
            $builder->get('collects'),
            array(
                'wishlist_service/post_collects',
            )
        );

        $collection = $service->add(138301351, 921728736);

        $this->assertEquals(
            array(
                'collection_id' => 1063001313,
                'created_at'    => "2013-12-06T16:49:45-05:00",
                'featured'      => false,
                'id'            => 1071559574,
                'product_id'    => 921728736,
                'sort_value'    => "0000000002",
                'updated_at'    => "2013-12-06T16:49:45-05:00",
                'position'      => 2
            ),
            $collection->get('collect')
        );
    }

    /**
     * Tests removing a production from a collection.
     */
    public function testRemove()
    {
        $builder = $this->getServiceBuilderInterface();

        $service = new WishlistService($builder);

        $this->setMockResponse(
            $builder->get('custom_collections'),
            array(
                'wishlist_service/get_custom_collections',
            )
        );

        $this->setMockResponse(
            $builder->get('collects'),
            array(
                'wishlist_service/get_collects',
                'wishlist_service/delete_collects'
            )
        );

        $this->assertNull($service->remove(138301351, 159666449)->get('collect'));
    }

    /**
     * Gets the service builder.
     *
     * @return \Guzzle\Service\Builder\ServiceBuilderInterface
     */
    private function getServiceBuilderInterface()
    {
        return Shopify::factory(
            array(
                'api_key' => 'junk',
                'shop'    => 'example.myshopify.com'
            )
        );
    }
}
