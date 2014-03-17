<?php
/**
 * bootstrap.php -
 *
 * @created 31/10/2013 14:27
 * @author chris
 */

error_reporting(-1);

use Doctrine\Common\Annotations\AnnotationRegistry;

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    die("Dependencies must be installed using composer:\n\nphp composer.phar install\n\n"
        . "See http://getcomposer.org for help with installing composer\n");
}

// Include the composer autoloader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
$loader->add('Shopify\\Test', __DIR__);

// Register services with the GuzzleTestCase
Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . '/mock');


// Instantiate the service builder
$serviceBuilder = \Shopify\Common\Shopify::factory(
    array(
        'api_key' => 'gobble-de-gook',
        'shop' => 'apple.myshopify.com',
    )
);

Guzzle\Tests\GuzzleTestCase::setServiceBuilder($serviceBuilder);
Guzzle\Common\Version::$emitWarnings = true;

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
