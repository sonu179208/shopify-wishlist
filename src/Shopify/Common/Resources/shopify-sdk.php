<?php
/**
 * shopify-sdk.php -
 *
 * @created 02/12/2013 11:48
 * @author  chris
 */

return array(
    'class'    => 'Shopify\Common\Shopify',
    'services' => array(
        'default_settings'   => array(
            'params' => array()
        ),
        'assets'             => array(
            'alias'   => 'Assets',
            'extends' => 'default_settings',
            'class'   => 'Shopify\Assets\AssetsClient'
        ),
        'collects'           => array(
            'alias'   => 'Collects',
            'extends' => 'default_settings',
            'class'   => 'Shopify\Collects\CollectsClient'
        ),
        'custom_collections' => array(
            'alias'   => 'CustomCollections',
            'extends' => 'default_settings',
            'class'   => 'Shopify\CustomCollections\CustomCollectionsClient'
        ),
        'customers'          => array(
            'alias'   => 'Customers',
            'extends' => 'default_settings',
            'class'   => 'Shopify\Customers\CustomersClient'
        ),
        'shop'               => array(
            'alias'   => 'Shop',
            'extends' => 'default_settings',
            'class'   => 'Shopify\Shop\ShopClient'
        ),
        'themes'             => array(
            'alias'   => 'Themes',
            'extends' => 'default_settings',
            'class'   => 'Shopify\Themes\ThemesClient'
        ),
    )
);