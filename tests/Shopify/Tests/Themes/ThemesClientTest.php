<?php
/**
 * ThemesClientTest.php -
 *
 * @created 31/12/2013 10:48
 * @author  chris
 */

namespace Shopify\Tests\Themes;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\Themes\ThemesClient;

class ThemesClientTest extends GuzzleTestCase
{
    /**
     * Tests the themes client factory.
     */
    public function testFactory()
    {
        $client = ThemesClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\Themes\ThemesClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests getting the theme list.
     */
    public function testGetThemes()
    {
        /** @var ThemesClient $client */
        $client = $this->getServiceBuilder()->get('themes');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'themes/get_themes',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getThemes();

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(3, count($result->get('themes')));

        $this->assertEquals(
            array(
                array(
                    'created_at'     => '2013-12-19T11:14:47-05:00',
                    'id'             => 828155753,
                    'name'           => 'Comfort',
                    'role'           => 'main',
                    'theme_store_id' => null,
                    'updated_at'     => '2013-12-19T11:14:47-05:00',
                    'previewable'    => true,
                ),
                array(
                    'created_at'     => '2013-12-19T11:14:47-05:00',
                    'id'             => 976877075,
                    'name'           => 'Speed',
                    'role'           => 'mobile',
                    'theme_store_id' => null,
                    'updated_at'     => '2013-12-19T11:14:47-05:00',
                    'previewable'    => true,
                ),
                array(
                    'created_at'     => '2013-12-19T11:14:47-05:00',
                    'id'             => 752253240,
                    'name'           => 'Sandbox',
                    'role'           => 'unpublished',
                    'theme_store_id' => null,
                    'updated_at'     => '2013-12-19T11:14:47-05:00',
                    'previewable'    => true,
                ),
            ),
            $result->get('themes')
        );

        $this->assertEquals('https://apple.myshopify.com/admin/themes.json', $history->getLastRequest()->getUrl());
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests getting a theme by Id.
     */
    public function testGetTheme()
    {
        /** @var ThemesClient $client */
        $client = $this->getServiceBuilder()->get('themes');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'themes/get_theme',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getTheme(array('id' => 828155753));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);

        $this->assertEquals(
            array(
                'created_at'     => '2013-12-19T11:14:47-05:00',
                'id'             => 828155753,
                'name'           => 'Comfort',
                'role'           => 'main',
                'theme_store_id' => null,
                'updated_at'     => '2013-12-19T11:14:47-05:00',
                'previewable'    => true,
            ),
            $result->get('theme')
        );

        $this->assertEquals('https://apple.myshopify.com/admin/themes/828155753.json', $history->getLastRequest()->getUrl());
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }
}
