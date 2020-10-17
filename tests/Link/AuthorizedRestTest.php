<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
use Pluf\Test\Client;
use Pluf\Test\TestCase;

class Link_AuthorizedRestTest extends TestCase
{

    /**
     *
     * @var User_Account
     */
    var $user;

    /**
     *
     * @var Client
     */
    var $client;

    /**
     *
     * @var SDP_Asset
     */
    var $freeAsset;

    /**
     *
     * @var SDP_Asset
     */
    var $pricedAsset;

    static $zarinpalBackend;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
        $m = new Pluf_Migration();
        $m->install();

        // Test user
        $user = new User_Account();
        $user->login = 'test';
        $user->is_active = true;
        if (true !== $user->create()) {
            throw new Exception();
        }
        // Credential of user
        $credit = new User_Credential();
        $credit->setFromFormData(array(
            'account_id' => $user->id
        ));
        $credit->setPassword('test');
        if (true !== $credit->create()) {
            throw new Exception();
        }

        Link_AuthorizedRestTest::$zarinpalBackend = new Bank_Backend();
        Link_AuthorizedRestTest::$zarinpalBackend->title = 'title';
        Link_AuthorizedRestTest::$zarinpalBackend->description = 'des';
        Link_AuthorizedRestTest::$zarinpalBackend->symbol = 'symbo.';
        Link_AuthorizedRestTest::$zarinpalBackend->home = '';
        Link_AuthorizedRestTest::$zarinpalBackend->redirect = '';
        Link_AuthorizedRestTest::$zarinpalBackend->engine = 'zarinpal';
        self::assertTrue(Link_AuthorizedRestTest::$zarinpalBackend->create(), 'Impossible to create bank-backend');
    }

    /**
     *
     * @afterClass
     */
    public static function removeDatabses()
    {
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->unInstall();
    }

    /**
     *
     * @before
     */
    public function init()
    {
        $this->client = new Client();

        // User
        $this->user = User_Account::getUser('test');

        // login
        $this->client->post('/user/login', array(
            'login' => 'test',
            'password' => 'test'
        ));

        // Free Asset
        $this->freeAsset = new SDP_Asset();
        $this->freeAsset->name = 'asset-' . rand();
        $this->freeAsset->description = 'It is my asset description';
        $this->freeAsset->price = 0;
        // $this->asset->drive_id = 0;
        $this->freeAsset->path = Pluf::f('upload_path');
        $this->assertTrue($this->freeAsset->create(), 'Impossible to create free asset');

        // Priced Asset
        $this->pricedAsset = new SDP_Asset();
        $this->pricedAsset->name = 'asset-' . rand();
        $this->pricedAsset->description = 'It is my asset description';
        $this->pricedAsset->price = 1000;
        // $this->asset->drive_id = 0;
        $this->pricedAsset->path = Pluf::f('upload_path');
        $this->assertTrue($this->pricedAsset->create(), 'Impossible to create priced asset');

        $res = copy(__DIR__ . '/../data/sample.txt', $this->pricedAsset->path . '/' 
            . $this->freeAsset->id);
        $this->assertTrue($res, 'Impossible to copy file');
    }

    /**
     *
     * @test
     */
    public function createLinkTest()
    {
        // Link for free asset
        $response = $this->client->post('/sdp/assets/' . $this->freeAsset->id . '/links');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertNotNull($actual['secure_link']);
        $this->assertNotNull($actual['expiry']);
        $this->assertTrue($actual['active']);
        $this->assertEquals($actual['asset_id'], $this->freeAsset->id);
        $this->assertEquals($actual['user_id'], $this->user->id);

        // Get created link for free asset
        $response = $this->client->get('/sdp/links/' . $actual['id']);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertNotNull($actual['secure_link']);
        $this->assertNotNull($actual['expiry']);
        $this->assertTrue($actual['active']);
        $this->assertEquals($actual['asset_id'], $this->freeAsset->id);
        $this->assertEquals($actual['user_id'], $this->user->id);

        // Link for priced asset
        $response = $this->client->post('/sdp/assets/' . $this->pricedAsset->id . '/links');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertNotNull($actual['secure_link']);
        $this->assertNotNull($actual['expiry']);
        $this->assertEquals($actual['asset_id'], $this->pricedAsset->id);
        $this->assertEquals($actual['user_id'], $this->user->id);

        // Get created link for priced asset
        $response = $this->client->get('/sdp/links/' . $actual['id']);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertNotNull($actual['secure_link']);
        $this->assertNotNull($actual['expiry']);
        $this->assertEquals($actual['asset_id'], $this->pricedAsset->id);
        $this->assertEquals($actual['user_id'], $this->user->id);
    }

    /**
     *
     * @test
     */
    public function downloadPricedLinkBeforePaymentTest()
    {
        // Link for priced asset
        $response = $this->client->post('/sdp/assets/' . $this->pricedAsset->id . '/links');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $secureLink = $actual['secure_link'];

        $this->expectException(SDP_Exception_ObjectNotFound::class);
        $response = $this->client->get('/sdp/links/' . $secureLink . '/content');
        $this->assertNotNull($response);
        $this->assertNotEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function invalidCurrencyPaymentLinkTest()
    {
        // Link
        $link = new SDP_Link();
        $link->secure_link = rand(1000000000, 9999999999) . '' . rand(1000000000, 9999999999);
        $link->asset_id = $this->pricedAsset;
        $link->active = true;
        $link->expiry = '2050-1-1 00:00:00';
        $link->user_id = $this->user;
        $this->assertTrue($link->create(), 'Impossible to create link');

        // Set currency of tenant different than currency of backend
        Tenant_Service::setSetting('local.currency', 'USD');
        $params = array(
            'callback' => 'testcallback.pluf.ir',
            'backend' => Link_AuthorizedRestTest::$zarinpalBackend->id
        );
        // Invalid payment is expected because of different currency of tenant and backend
        $this->expectException(Pluf_Exception_BadRequest::class);
        $response = $this->client->post('/sdp/links/' . $link->id . '/payments', $params);
        $this->assertNotNull($response);
        $this->assertNotEquals($response->status_code, 200);
    }

    /**
     * Test to create payment for a free asset
     *
     * @test
     */
    public function invalidPricePaymentLinkTest()
    {
        // Link
        $link = new SDP_Link();
        $link->secure_link = rand(1000000000, 9999999999) . '' . rand(1000000000, 9999999999);
        $link->asset_id = $this->freeAsset;
        $link->active = true;
        $link->expiry = '2050-1-1 00:00:00';
        $link->user_id = $this->user;
        $this->assertTrue($link->create(), 'Impossible to create link');

        // Set currency of tenant same as currency of backend
        Tenant_Service::setSetting('local.currency', Link_AuthorizedRestTest::$zarinpalBackend->currency);
        $params = array(
            'callback' => 'testcallback.pluf.ir',
            'backend' => Link_AuthorizedRestTest::$zarinpalBackend->id
        );
        // Invalid price exception is expected
        $this->expectException(Pluf_Exception_BadRequest::class);
        $response = $this->client->post('/sdp/links/' . $link->id . '/payments', $params);
        $this->assertNotNull($response);
        $this->assertNotEquals($response->status_code, 200);
    }

    /**
     * Test to create payment for a free asset
     *
     * @test
     */
    public function paymentLinkTest()
    {
        // Link
        $link = new SDP_Link();
        $link->secure_link = rand(1000000000, 9999999999) . '' . rand(1000000000, 9999999999);
        $link->asset_id = $this->pricedAsset;
        $link->active = true;
        $link->expiry = '2050-1-1 00:00:00';
        $link->user_id = $this->user;
        $this->assertTrue($link->create(), 'Impossible to create link');

        // Set currency of tenant same as currency of backend
        Tenant_Service::setSetting('local.currency', Link_AuthorizedRestTest::$zarinpalBackend->currency);
        $params = array(
            'callback' => 'testcallback.pluf.ir',
            'backend' => Link_AuthorizedRestTest::$zarinpalBackend->id
        );
        $response = $this->client->post('/sdp/links/' . $link->id . '/payments', $params);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        $this->assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertEquals($actual['amount'], $this->pricedAsset->price);
        $this->assertEquals($actual['callbackURL'], $params['callback']);
        $this->assertEquals($actual['owner_class'], 'sdp-link');
        $this->assertEquals($actual['owner_id'], $link->id);
        $this->assertEquals($actual['backend_id'], Link_AuthorizedRestTest::$zarinpalBackend->id);
    }
}



