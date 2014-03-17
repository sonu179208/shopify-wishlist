<?php
/**
 * assets-2013-12-31.php -
 *
 * @created 31/12/2013 10:41
 * @author  chris
 */

return array(
    'apiVersion'  => '2013-12-31',
    'description' => 'Shopify assets service',
    'operations'  => array(
        'GetAssets'   => array(
            'summary'       => 'Provides list of assets for a specific theme.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/themes/{id}/assets.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetAssetsResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The theme Id',
                    'type'        => 'numeric',
                ),
            )
        ),
        'GetAsset'    => array(
            'summary'       => 'Get an asset for a certain theme by it\'s relative path.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/themes/{id}.json?asset[key]={asset_path}&theme_id={id}',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetAssetResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id'         => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The theme Id',
                    'type'        => 'numeric',
                ),
                'asset_path' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The relative path to the asset',
                    'type'        => 'string',
                ),
            )
        ),
        'CreateAsset' => array(
            'summary'              => 'Creates a new asset.',
            'httpMethod'           => 'PUT',
            'uri'                  => 'admin/themes/{id}/assets.json',
            'class'                => 'Shopify\\Common\\Command\\WrappedOperationCommand',
            'responseClass'        => 'GetAssetResult',
            'responseType'         => 'model',
            'additionalParameters' => array(
                'requestWrapperNode' => 'asset',
            ),
            'parameters'           => array(
                'id'    => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The theme Id',
                    'type'        => 'numeric',
                ),
                'asset' => array(
                    'name'       => 'asset',
                    'type'       => 'array',
                    'location'   => 'json',
                    'required'   => true,
                    'parameters' => array(
                        'key'   => array(
                            'location'    => 'json',
                            'required'    => true,
                            'description' => 'The relative path to the asset',
                            'type'        => 'string',
                        ),
                        'value' => array(
                            'location'    => 'json',
                            'required'    => true,
                            'description' => 'The asset value, string, base 64 encoded image...',
                            'type'        => 'string',
                        ),
                    )
                )
            )
        ),
    ),
    'models'      => array(
        'EmptyResult'     => array(
            'type'                 => 'object',
            'additionalProperties' => true,
        ),
        'Asset'           => array(
            'location'             => 'json',
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'key'          => array(
                    'type' => 'string'
                ),
                'public_url'   => array(
                    'type' => 'string'
                ),
                'created_at'   => array(
                    'type' => 'date-time'
                ),
                'updated_at'   => array(
                    'type' => 'date-time'
                ),
                'content_type' => array(
                    'type' => 'string',
                ),
                'size'         => array(
                    'type' => 'numeric'
                ),
                'theme_id'     => array(
                    'type' => 'numeric'
                ),
            )
        ),
        'GetAssetResult'  => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'asset' => array(
                    '$ref' => 'Asset',
                )
            )
        ),
        'GetAssetsResult' => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'assets' => array(
                    'name'     => 'assets',
                    'location' => 'json',
                    'sentAs'   => 'assets',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'Asset',
                    )
                ),
            )
        ),
    )
);