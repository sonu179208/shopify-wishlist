<?php
/**
 * shop-2013-12-09.php -
 *
 * @created 09/12/2013 10:59
 * @author  chris
 */

return array(
    'apiVersion'  => '2013-12-02',
    'description' => 'Get the configuration of the shop account',
    'operations'  => array(
        'GetShop' => array(
            'summary'       => 'The Shopify API lets you do the following with the Shop resource.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/shop.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'ShopResult',
            'responseType'  => 'model',
            'parameters'    => array(
                'fields' => array(
                    'location'    => 'query',
                    'description' => 'comma-separated list of fields to include in the response',
                    'type'        => 'string',
                ),
            )
        ),
    ),
    'models'      => array(
        'ShopResult' => array(
            'location'             => 'json',
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'shop' => array(
                    'type'                 => 'array',
                    'location'             => 'json',
                    'additionalProperties' => false,
                    'items'                => array(
                        'additionalProperties' => false,
                        'type'                 => 'object',
                        'location'             => 'json',
                        'properties'           => array(
                            'address1'                             => array('type' => ''),
                            'city'                                 => array('type' => ''),
                            'country'                              => array('type' => ''),
                            'created_at'                           => array('type' => 'date-time'),
                            'customer_email'                       => array('type' => 'string'),
                            'domain'                               => array('type' => 'string'),
                            'email'                                => array('type' => 'string'),
                            'id'                                   => array('type' => 'numeric'),
                            'latitude'                             => array('type' => 'string'),
                            'longitude'                            => array('type' => 'string'),
                            'name'                                 => array('type' => 'string'),
                            'phone'                                => array('type' => 'string'),
                            'primary_location_id'                  => array('type' => 'numeric'),
                            'province'                             => array('type' => 'string'),
                            'public'                               => array('type' => 'string'),
                            'source'                               => array('type' => 'string'),
                            'zip'                                  => array('type' => 'string'),
                            'country_code'                         => array('type' => 'string'),
                            'country_name'                         => array('type' => 'string'),
                            'currency'                             => array('type' => 'string'),
                            'timezone'                             => array('type' => 'string'),
                            'shop_owner'                           => array('type' => 'string'),
                            'money_format'                         => array('type' => 'string'),
                            'money_with_currency_format'           => array('type' => 'string'),
                            'province_code'                        => array('type' => 'string'),
                            'taxes_included'                       => array('type' => 'boolean'),
                            'tax_shipping'                         => array('type' => 'boolean'),
                            'county_taxes'                         => array('type' => 'boolean'),
                            'plan_display_name'                    => array('type' => 'string'),
                            'plan_name'                            => array('type' => 'string'),
                            'myshopify_domain'                     => array('type' => 'string'),
                            'google_apps_domain'                   => array('type' => 'boolean'),
                            'google_apps_login_enabled'            => array('type' => 'boolean'),
                            'money_in_emails_format'               => array('type' => 'string'),
                            'money_with_currency_in_emails_format' => array('type' => 'string'),
                            'eligible_for_payments'                => array('type' => 'boolean'),
                            'requires_extra_payments_agreement'    => array('type' => 'boolean')
                        )
                    )
                )
            )
        ),
    )
);