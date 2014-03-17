<?php
/**
 * custom_collections-2013-12-02.php -
 *
 * @created 02/12/2013 15:13
 * @author  chris
 */

return array(
    'apiVersion'  => '2013-12-02',
    'description' => 'Shopify custom collections service',
    'operations'  => array(
        'GetCustomCollections'   => array(
            'summary'       => 'Provides list of custom collections, this list can be filtered.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/custom_collections.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetCustomCollectionsResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'handle' => array(
                    'location'    => 'query',
                    'description' => 'The collection handle',
                    'type'        => 'string',
                ),
            )
        ),
        'GetCustomCollection'    => array(
            'summary'       => 'Gets a custom collection by Id.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/custom_collections/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetCustomCollectionResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The custom collection Id',
                    'type'        => 'numeric',
                ),
            )
        ),
        'RemoveCustomCollections'    => array(
            'summary'       => 'Removes a custom collection by Id.',
            'httpMethod'    => 'DELETE',
            'uri'           => 'admin/custom_collections/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'EmptyResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The custom collection Id',
                    'type'        => 'numeric',
                ),
            )
        ),
        'CreateCustomCollection' => array(
            'summary'       => 'Creates a custom collection.',
            'httpMethod'    => 'POST',
            'uri'           => 'admin/custom_collections.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'CreateCustomCollectionResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'custom_collection' => array(
                    'location'    => 'json',
                    'required'    => true,
                    'description' => 'The custom collection',
                    'type'        => 'array',
                    'parameters'  => array(
                        'handle' => array(
                            'location'    => 'json',
                            'description' => 'The custom collection handle',
                            'type'        => 'string',
                        ),
                        'title'  => array(
                            'location'    => 'json',
                            'description' => 'The custom collection title',
                            'type'        => 'string',
                            'required'    => true
                        ),
                    ),
                ),
            ),
        ),
        'EditCustomCollection' => array(
            'summary'       => 'Edits a custom collection.',
            'httpMethod'    => 'PUT',
            'uri'           => 'admin/custom_collections/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'EditCustomCollectionResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'id' => array(
                    'location'    => 'uri',
                    'required'    => true,
                    'description' => 'The custom collection Id',
                    'type'        => 'numeric',
                ),
                'custom_collection' => array(
                    'location'    => 'json',
                    'required'    => true,
                    'description' => 'The custom collection',
                    'type'        => 'array',
                    'parameters'  => array(
                        'handle' => array(
                            'location'    => 'json',
                            'description' => 'The custom collection handle',
                            'type'        => 'string',
                        ),
                        'title'  => array(
                            'location'    => 'json',
                            'description' => 'The custom collection title',
                            'type'        => 'string',
                            'required'    => true
                        ),
                        'collects' => array(
                            'location' => 'json',
                            'description' => 'A set of products',
                            'type' => 'array',
                            'parameters' => array(
                                'product_id' => array(
                                    'location'    => 'json',
                                    'description' => 'The product Id',
                                    'type'        => 'numeric',
                                ),
                                'sort_value'  => array(
                                    'location'    => 'json',
                                    'description' => 'The position of the item in the list',
                                    'type'        => 'numeric',
                                    'required'    => true
                                ),
                            )
                        )
                    ),
                ),
            )
        )
    ),
    'models'      => array(
        'EmptyResult'                => array(
            'type'                 => 'object',
            'additionalProperties' => true,
        ),
        'CustomCollection'           => array(
            'location'             => 'json',
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'body_html'       => array(
                    'type' => 'string',
                ),
                'handle'          => array(
                    'type' => 'string',
                ),
                'image'           => array(
                    'type' => 'string',
                ),
                'id'              => array(
                    'type' => 'numeric',
                ),
                'meta_field'      => array(
                    'type' => 'array',
                ),
                'published'       => array(
                    'type' => 'boolean',
                ),
                'published_at'    => array(
                    'type' => 'date-time',
                ),
                'published_scope' => array(
                    'type' => 'string',
                ),
                'sort_order'      => array(
                    'type' => 'string',
                ),
                'template_suffix' => array(
                    'type' => 'string',
                ),
                'title'           => array(
                    'type' => 'string',
                ),
                'published_at'    => array(
                    'type' => 'date-time',
                ),
                'collects'        => array(
                    'type'                 => 'array',
                    'location'             => 'json',
                    'additionalProperties' => false,
                    'items'                => array(
                        'additionalProperties' => false,
                        'type'                 => 'object',
                        'location'             => 'json',
                        'properties'           => array(
                            'product_id' => array(
                                'type' => 'numeric',
                            ),
                            'position'   => array(
                                'type' => 'numeric',
                            )
                        )
                    )
                )
            )
        ),
        'GetCustomCollectionResult'  => array(
            'type'       => 'object',
            'properties' => array(
                'custom_collection' => array(
                    '$ref' => 'CustomCollection',
                )
            )
        ),
        'GetCustomCollectionsResult' => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'custom_collections' => array(
                    'name'     => 'results',
                    'location' => 'json',
                    'sentAs'   => 'custom_collections',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'CustomCollection',
                    )
                ),
            )
        ),
        'CreateCustomCollectionResult' => array(
            'type'       => 'object',
            'properties' => array(
                'custom_collection' => array(
                    '$ref' => 'CustomCollection',
                )
            )
        ),
        'EditCustomCollectionResult' => array(
            'type'       => 'object',
            'properties' => array(
                'custom_collection' => array(
                    '$ref' => 'CustomCollection',
                )
            )
        ),
    )
);