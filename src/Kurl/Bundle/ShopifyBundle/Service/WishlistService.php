<?php
/**
 * Manipulates custom collections created under the guise of wishlists.
 *
 * @created 13/03/2014 18:32
 * @author  chris
 */

namespace Kurl\Bundle\ShopifyBundle\Service;

use Guzzle\Service\Builder\ServiceBuilderInterface;
use Guzzle\Service\Resource\Model;
use Shopify\Collects\CollectsClient;
use Shopify\CustomCollections\CustomCollectionsClient;

/**
 * Class WishlistService
 *
 * @package Kurl\Bundle\ShopifyBundle\Service
 */
class WishlistService
{
    /**
     * The service builder.
     *
     * @var ServiceBuilderInterface
     */
    protected $builder;

    /**
     * Creates a new wishlist service.
     *
     * @param ServiceBuilderInterface $builder
     */
    public function __construct(ServiceBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Adds a production to a wishlist.
     *
     * TODO add meta tags to count quantity, possibly add quantity argument
     * TODO correct return value
     *
     * @param int $customerId the customerId
     * @param int $productId  the product Id
     *
     * @return null
     */
    public function add($customerId, $productId)
    {
        $wishlist = $this->getWishlist($customerId);

        /** @var CollectsClient $client */
        $client = $this->builder->get('collects');

        // TODO rename this sdk method to add
        return $client->addToCollection(
            array('collect' => array('collection_id' => $wishlist['id'], 'product_id' => $productId))
        );
    }

    /**
     * Removes a product from a wishlist.
     *
     * TODO sort return value, possibly make chain-able
     * TODO check quantities and remove one or add quantity argument
     *
     * @param int $customerId the customerId
     * @param int $productId  the product Id
     *
     * @return null
     */
    public function remove($customerId, $productId)
    {
        $wishlist = $this->getWishlist($customerId);

        /** @var CollectsClient $client */
        $client = $this->builder->get('collects');

        $collect = $client
            ->getCollects(array('collection_id' => $wishlist['id'], 'product_id' => $productId))
            ->get('collects');

        // Silently ignore either missing products or extras, naughty :).
        return 1 !== count($collect) ?
            array() :
            $client->removeFromCollection(array('id' => $collect[0]['id']));
    }

    public function search($filter)
    {
    }

    /**
     * Gets a wishlist, creates one if it does not exist.
     *
     * @param int $customerId the customer Id
     *
     * @return array the wishlist details
     */
    protected function getWishlist($customerId)
    {
        /** @var CustomCollectionsClient $client */
        $client   = $this->builder->get('custom_collections');
        $wishlist = $client->getCustomCollections(array('handle' => 'wishlist-' . $customerId))->get(
            'custom_collections'
        );

        return 1 === count($wishlist) ? $wishlist[0] : $this->create($customerId);
    }

    /**
     * Creates a new wishlist.
     *
     * TODO ensure a fancy human readable title is assigned to the wish list
     *
     * @param int $customerId the customer Id
     *
     * @return array the collection that was created
     */
    protected function create($customerId)
    {
        /** @var CustomCollectionsClient $client */
        $client = $this->builder->get('custom_collections');
        /** @var Model $collection */
        $collection = $client->createCustomCollection(
            array(
                'custom_collection' => array(
                    'title'  => 'wishlist-' . $customerId,
                    'handle' => 'wishlist-' . $customerId
                )
            )
        );

        return $collection->get('custom_collection');
    }
}