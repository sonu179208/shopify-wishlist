<?php
/**
 * themes-2013-12-31.php -
 *
 * @created 31/12/2013 10:41
 * @author  chris
 */

return array(
    'apiVersion'  => '2013-12-31',
    'description' => 'Shopify themes service',
    'operations'  => array(
        'GetThemes' => array(
            'summary'       => 'Provides list of themes.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/themes.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetThemesResult',
            'responseType'  => 'model',
        ),
        'GetTheme'  => array(
            'summary'       => 'Get a theme with a certain id.',
            'httpMethod'    => 'GET',
            'uri'           => 'admin/themes/{id}.json',
            'class'         => 'Guzzle\\Service\\Command\\OperationCommand',
            'responseClass' => 'GetThemeResult',
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
    ),
    'models'      => array(
        'EmptyResult'     => array(
            'type'                 => 'object',
            'additionalProperties' => true,
        ),
        'Theme'           => array(
            'location'             => 'json',
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'created_at'     => array(
                    'type' => 'date-time'
                ),
                'id'             => array(
                    'type' => 'numeric'
                ),
                'name'           => array(
                    'type' => 'string'
                ),
                'role'           => array(
                    'type' => 'string',
                    'enum' => array(
                        'unpublished',
                        'main',
                        'mobile'
                    )
                ),
                'theme_store_id' => array(
                    'type' => 'numeric'
                ),
                'updated_at'     => array(
                    'type' => 'date-time'
                ),
                'previewable'    => array(
                    'type' => 'boolean'
                ),
            )
        ),
        'GetThemeResult'  => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'theme' => array(
                    '$ref' => 'Theme',
                )
            )
        ),
        'GetThemesResult' => array(
            'additionalProperties' => false,
            'type'                 => 'object',
            'properties'           => array(
                'themes' => array(
                    'name'     => 'themes',
                    'location' => 'json',
                    'sentAs'   => 'themes',
                    'type'     => 'array',
                    'items'    => array(
                        '$ref' => 'Theme',
                    )
                ),
            )
        ),
    )
);