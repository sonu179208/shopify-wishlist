<?php
/**
 * AssetsClientTest.php -
 *
 * @created 31/12/2013 10:48
 * @author  chris
 */

namespace Shopify\Tests\Assets;

use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Tests\GuzzleTestCase;
use Shopify\Assets\AssetsClient;

class AssetsClientTest extends GuzzleTestCase
{
    /**
     * Tests the assets client factory.
     */
    public function testFactory()
    {
        $client = AssetsClient::factory(
            array(
                'api_key' => 'sdfadsfdasf',
                'shop'    => 'apple.myshopify.com'
            )
        );

        $this->assertInstanceOf('Shopify\Assets\AssetsClient', $client);
        $this->assertSame('sdfadsfdasf', $client->getApiKey('api_key'));
        $this->assertSame('apple.myshopify.com', $client->getConfig('shop'));
    }

    /**
     * Tests getting the asset list.
     */
    public function testGetAssets()
    {
        /** @var AssetsClient $client */
        $client = $this->getServiceBuilder()->get('assets');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'assets/get_assets',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getAssets(array('id' => 828155753));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);
        $this->assertSame(22, count($result->get('assets')));

        $this->assertEquals(
            array(
                array(
                    'key'          => 'assets/bg-body-green.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-body-green.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1542,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-body-orange.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-body-orange.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1548,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-body-pink.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-body-pink.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1562,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-body.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-body.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1571,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-content.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-content.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 134,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-footer.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-footer.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1434,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-main.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-main.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 297,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/bg-sidebar.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/bg-sidebar.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 124,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/shop.css',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/shop.css?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/css',
                    'size'         => 14058,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/shop.css.liquid',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/shop.css.liquid?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 14675,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/shop.js',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/shop.js?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'application/javascript',
                    'size'         => 348,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/sidebar-devider.gif',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/sidebar-devider.gif?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/gif',
                    'size'         => 1016,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'assets/sidebar-menu.jpg',
                    'public_url'   => 'http://cdn.shopify.com/s/files/1/0006/9093/3842/t/1/assets/sidebar-menu.jpg?1',
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'image/jpeg',
                    'size'         => 1609,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'config/settings.html',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/html',
                    'size'         => 4570,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'layout/theme.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 3252,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/article.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 2486,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/blog.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 786,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/cart.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 2047,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/collection.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 946,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/index.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 1068,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/page.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 147,
                    'theme_id'     => 828155753,
                ),
                array(
                    'key'          => 'templates/product.liquid',
                    'public_url'   => null,
                    'created_at'   => '2010-07-12T15:31:50-04:00',
                    'updated_at'   => '2010-07-12T15:31:50-04:00',
                    'content_type' => 'text/x-liquid',
                    'size'         => 2796,
                    'theme_id'     => 828155753,
                ),
            ),
            $result->get('assets')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/themes/828155753/assets.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests getting a asset by Id.
     */
    public function testGetAsset()
    {
        /** @var AssetsClient $client */
        $client = $this->getServiceBuilder()->get('assets');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'assets/get_asset',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->getAsset(array('id' => 828155753, 'asset_path' => 'templates/index.liquid'));

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);

        $this->assertEquals(
            array(
                'key'          => 'templates/index.liquid',
                'public_url'   => null,
                'created_at'   => '2010-07-12T15:31:50-04:00',
                'updated_at'   => '2010-07-12T15:31:50-04:00',
                'content_type' => 'text/x-liquid',
                'size'         => 1068,
                'theme_id'     => 828155753,
            ),
            $result->get('asset')
        );

        $this->assertEquals(
            'https://apple.myshopify.com/admin/themes/828155753.json?asset%5Bkey%5D=templates%2Findex.liquid&' .
                'theme_id=828155753',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('GET', $history->getLastRequest()->getMethod());
    }

    /**
     * Tests asset creation.
     *
     * This test might not be 100% correct as the "create" test in the shopify docs only create attachments, this test
     * result comes from the the "edit" example.
     */
    public function testCreateAsset()
    {
        /** @var AssetsClient $client */
        $client = $this->getServiceBuilder()->get('assets');

        $history = new HistoryPlugin();
        $client->addSubscriber($history);

        $this->setMockResponse(
            $client,
            array(
                'assets/create_asset',
            )
        );

        /** @var \Guzzle\Service\Resource\Model $result */
        $result = $client->createAsset(
            array(
                'id'    => 828155753,
                'key'   => 'templates/index.liquid',
                'value' => '<img src="backsoon-postit.png"><p>We are busy updating the store for you and will be back within the hour.</p>'
            )
        );

        $this->assertInstanceOf('Guzzle\Service\Resource\Model', $result);

        $this->assertEquals(
            array (
                'key' => 'templates/index.liquid',
                'public_url' => NULL,
                'created_at' => '2010-07-12T15:31:50-04:00',
                'updated_at' => '2013-12-19T11:13:12-05:00',
                'content_type' => 'text/x-liquid',
                'size' => 110,
                'theme_id' => 828155753,
            ),
            $result->get('asset')
        );

        // TODO consider testing the response body has correctly added the parent node "asset".
        //var_dump($history->getLastRequest()->getBody()->__toString());

        $this->assertEquals(
            'https://apple.myshopify.com/admin/themes/828155753/assets.json',
            $history->getLastRequest()->getUrl()
        );
        $this->assertEquals('PUT', $history->getLastRequest()->getMethod());
    }
}
