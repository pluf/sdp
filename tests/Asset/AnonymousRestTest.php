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

class Asset_AnonymousRestTest extends TestCase
{

    public static $client;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
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

        $per = User_Role::getFromString('tenant.owner');
        $user->setAssoc($per);

        // Anonymouse Client
        self::$client = new Client();
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
     * Anonymous user should not be able to create new asset
     *
     * @test
     */
    public function createRestTest()
    {
        $this->expectException(Pluf_Exception_Unauthorized::class);
        $form = array(
            'name' => 'asset-' . rand(),
            'description' => 'description ' . rand(),
            'price' => rand()
        );
        $response = self::$client->post('/sdp/assets', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 401);
    }

    /**
     *
     * @test
     */
    public function getRestTest()
    {
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->price = rand();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        // Get item
        $response = self::$client->get('/sdp/assets/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Anonymous user should not be able to update an asset
     *
     * @test
     */
    public function updateRestTest()
    {
        $this->expectException(Pluf_Exception_Unauthorized::class);
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->price = rand();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        // Update item
        $form = array(
            'price' => rand()
        );
        $response = self::$client->post('/sdp/assets/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 401);
    }

    /**
     * Anonymous user should not be able to delete an asset
     *
     * @test
     */
    public function deleteRestTest()
    {
        $this->expectException(Pluf_Exception_Unauthorized::class);
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->price = rand();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');

        // delete
        $response = self::$client->delete('/sdp/assets/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 401);
    }

    /**
     *
     * @test
     */
    public function findRestTest()
    {
        $response = self::$client->get('/sdp/assets');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function findWithGraphqlRestTest()
    {
        $params = array(
            'graphql' => '{items{id,name,price,thumbnail,parent{id,name},drive{id,home,driver}}}'
        );
        $response = self::$client->get('/sdp/assets', $params);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function getListofAssetsTest()
    {
        $response = self::$client->get('/sdp/assets');
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');
    }
}



