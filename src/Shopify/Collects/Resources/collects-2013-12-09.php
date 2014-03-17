<?php
/**
 * collects-2013-12-09.php -
 *
 * @created 09/12/2013 10:31
 * @author  chris
 */

return array(
    'apiVersion'  => '2013-12-09',
    'description' => 'Shopify collects service',
    'operations'  => array(
        'GetCollects'     => array(
            'summary'       => 'Provides list of collects, this list can be filtered.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/collects.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetCollectsResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'collection_id' => array(
                    'location'    => 'query',
                    'description' => 'The id of the custom collection containing the product.',
                    'type'        => 'numeric'
                ),
                'created_at'    => array(
                    'location'    => 'query',
                    'description' => 'The date and time when the collect was created. The API returns this value in ISO 8601 format.',
                    'type'        => 'date-time'
                ),
                'featured'      => array(
                    'location'    => 'query',
                    'description' => 'States whether or not the collect is featured. Valid values are "true" or "false".',
                    'type'        => 'string' // Pseudo boolean
                ),
                'id'            => array(
                    'location'    => 'query',
                    'description' => 'A unique numeric identifier for the collect.',
                    'type'        => 'numeric'
                ),
                'position'      => array(
                    'location'    => 'query',
                    'description' => 'A number specifying the order in which the product appears in the custom collection, with 1 denoting the first item in the collection. This value applies only when the custom collection\'s sort-order property is set to manual.',
                    'type'        => 'numeric'
                ),
                'product_id'    => array(
                    'location'    => 'query',
                    'description' => 'The unique numeric identifier for the product in the custom collection.',
                    'type'        => 'numeric'
                ),
                'sort_value'    => array(
                    'location'    => 'query',
                    'description' => 'This is the same value as position but padded with leading zeroes to make it alphanumeric-sortable.',
                    'type'        => 'string'
                ),
                'updated_at'    => array(
                    'location'    => 'query',
                    'description' => 'The date and time when the collect was last updated. The API returns this value in ISO 8601 format.',
                    'type'        => 'date-time'
                )
            )
        ),
        'GetCollect'      => array(
            'summary'       => 'Get the collect with a certain id, or for a given product AND collection.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/collects/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetCollectResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The collection Id',
                    'type'        => 'numeric',
                ),
            )
        ),
        'RemoveFromCollection'      => array(
            'summary'       => 'Removes a collect with a certain id.',
            'httpMethod'    => 'DELETE',
            'uri'           => 'admin/collects/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'EmptyResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The collection Id',
                    'type'        => 'numeric',
                ),
            )
        ),
        'AddToCollection' => array(
            'summary'       => 'Add a product to a collection',
            'httpMethod'    => 'POST',
            'uri'           => 'admin/collects.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'AddToCollectsResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'collect' => array(
                    'location'    => 'json',
                    'required'    => true,
                    'description' => 'The collect',
                    'type'        => 'array',
                    'parameters'  => array(
                        'product_id' => array(
                            'location'    => 'json',
                            'description' => 'The product Id',
                            'type'        => 'string',
                        ),
                        'collect_id' => array(
                            'location'    => 'json',
                            'description' => 'The collect Id',
                            'type'        => 'string',
                            'required'    => true
                        ),
                    ),
                ),
            ),
        ),
    ),
    'models'      => array(
        'EmptyResult'            => array(
            'type'                 => 'object',
            'additionalProperties' => true,
        ),
        'Collection'             => array(
            'location'             => 'json',
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'collects' => array(
                    'type'                 => 'array',
                    'location'             => 'json',
                    'additionalProperties' => false,
                    'items'                => array(
                        'additionalProperties' => false,
                        'type'                 => 'object',
                        'location'             => 'json',
                        'properties'           => array(
                            'collection_id' => array(
                                'type' => 'numeric'
                            ),
                            'created_at'    => array(
                                'type' => 'date-time'
                            ),
                            'featured'      => array(
                                'type' => 'string' // Pseudo boolean
                            ),
                            'id'            => array(
                                'type' => 'numeric'
                            ),
                            'position'      => array(
                                'type' => 'numeric'
                            ),
                            'product_id'    => array(
                                'type' => 'numeric'
                            ),
                            'sort_value'    => array(
                                'type' => 'string'
                            ),
                            'updated_at'    => array(
                                'type' => 'date-time'
                            )
                        )
                    )
                )
            )
        ),
        'GetCollectResult'       => array(
            'type'       => 'object',
            'properties' => array(
                'collect' => array(
                    '$ref' => 'Collect',
                )
            )
        ),
        'GetCollectsResult'      => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'collects' => array(
                    'name'     => 'results',
                    'location' => 'json',
                    'sentAs'   => 'collects',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'Collect',
                    )
                ),
            )
        ),
        'AddToCollectsResult'      => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'collect' => array(
                    'name'     => 'results',
                    'location' => 'json',
                    'sentAs'   => 'collects',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'Collect',
                    )
                ),
            )
        ),
        'CreateCollectionResult' => array(
            'type'       => 'object',
            'properties' => array(
                'collection' => array(
                    '$ref' => 'Collection',
                )
            )
        )
    )
);