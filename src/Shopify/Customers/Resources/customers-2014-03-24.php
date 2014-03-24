<?php
/**
 * customers-2014-03-24.php -
 *
 * @created 09/12/2013 10:59
 * @author  chris
 */

return array(
    'apiVersion'  => '2014-03-26',
    'description' => 'Shopify customers service',
    'operations'  => array(
        'GetCustomers' => array(
            'summary'       => 'Provides list of customers.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/customers/search.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetCustomersResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'query' => array(
                    'location'    => 'query',
                    'required'    => true,
                    'description' => 'The filter query',
                    'type'        => 'string',
                ),
            )
        ),
    ),
    'models'      => array(
        'EmptyResult'        => array(
            'type'                 => 'object',
            'additionalProperties' => true,
        ),
        'Customer'           => array(
            'location'             => 'json',
            'additionalProperties' => true, // Just allow the addresses through TODO add addresses nodes
            'type'                 => 'object',
            'properties'           => array(
                'accepts_marketing'    => array('type' => 'boolean'),
                'created_at'           => array('type' => 'date-time'),
                'email'                => array('type' => 'string'),
                'first_name'           => array('type' => 'string'),
                'id'                   => array('type' => 'numeric'),
                'last_name'            => array('type' => 'string'),
                'last_order_id'        => array('type' => 'numeric'),
                'multipass_identifier' => array('type' => 'string'),
                'note'                 => array('type' => 'string'),
                'orders_count'         => array('type' => 'numeric'),
                'state'                => array('type' => 'string'),
                'total_spent'          => array('type' => 'string'),
                'updated_at'           => array('type' => 'date-time'),
                'verified_email'       => array('type' => 'boolean'),
                'tags'                 => array('type' => 'string'),
                'last_order_name'      => array('type' => 'string'),
            )
        ),
        'GetCustomersResult' => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'customer' => array(
                    '$ref' => 'Customer',
                )
            )
        ),
        'GetCustomersResult' => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'customers' => array(
                    'name'     => 'customers',
                    'location' => 'json',
                    'sentAs'   => 'customers',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'Customer',
                    )
                ),
            )
        ),
    )
);

