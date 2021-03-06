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

class AssetRelation_RestTest extends TestCase
{

    public static $ownerClient;

    public static $client;

    public static $assetList = array();

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
        // Owner Client
        self::$ownerClient = new Client();
        self::$ownerClient->post('/user/login', array(
            'login' => 'test',
            'password' => 'test'
        ));
    }

    /**
     *
     * @afterClass
     */
    public static function removeDatabses()
    {
        for ($i = 0; $i < sizeof(self::$assetList); $i ++) {
            $item = self::$assetList[$i];
            $item->delete();
        }
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->unInstall();
    }

    private static function getRandomAsset()
    {
        // Create asset
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->create();
        self::assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        self::$assetList[] = $item;
        return $item;
    }

    /**
     *
     * @test
     */
    public function createRestTest()
    {
        $form = array(
            'type' => 'sample',
            'description' => 'description',
            'start_id' => self::getRandomAsset()->id,
            'end_id' => self::getRandomAsset()->id
        );
        $response = self::$ownerClient->post('/sdp/asset-relations', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function getRestTest()
    {
        $item = new SDP_AssetRelation();
        $item->type = 'sample';
        $item->description = 'description';
        $item->start_id = self::getRandomAsset();
        $item->end_id = self::getRandomAsset();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_AssetRelation');
        // Get item
        $response = self::$client->get('/sdp/asset-relations/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function updateRestTest()
    {
        $item = new SDP_AssetRelation();
        $item->type = 'sample';
        $item->description = 'description';
        $item->start_id = self::getRandomAsset();
        $item->end_id = self::getRandomAsset();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_AssetRelation');
        // Update item
        $form = array(
            'type' => 'relate'
        );
        $response = self::$client->post('/sdp/asset-relations/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function deleteRestTest()
    {
        $item = new SDP_AssetRelation();
        $item->type = 'sample';
        $item->description = 'description';
        $item->start_id = self::getRandomAsset();
        $item->end_id = self::getRandomAsset();
        $item->create();
        $this->assertFalse($item->isAnonymous(), 'Could not create SDP_AssetRelation');

        // delete
        $response = self::$ownerClient->delete('/sdp/asset-relations/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function findRestTest()
    {
        $response = self::$client->get('/sdp/asset-relations');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function getListofAssetRelationsTest()
    {
        $response = self::$client->get('/sdp/asset-relations');
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');
    }

    /**
     * Sort asset-relations based on id
     *
     * @test
     */
    public function getListofAssetRelationsSortByIdTest()
    {
        $item1 = new SDP_AssetRelation();
        $item1->type = 'sample';
        $item1->description = 'description';
        $item1->start_id = self::getRandomAsset();
        $item1->end_id = self::getRandomAsset();
        $item1->create();

        $item2 = new SDP_AssetRelation();
        $item2->type = 'sample';
        $item2->description = 'description';
        $item2->start_id = self::getRandomAsset();
        $item2->end_id = self::getRandomAsset();
        $item2->create();

        // DESC
        $response = self::$client->get('/sdp/asset-relations', array(
            '_px_fk' => array(
                'id',
                'id'
            ),
            '_px_fv' => array(
                $item1->id,
                $item2->id
            ),
            '_px_sk' => 'id',
            '_px_so' => 'd'
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');

        $actual = json_decode($response->content, true);
        for ($i = 1; $i < sizeof($actual['items']); $i ++) {
            $a = $actual['items'][$i];
            $b = $actual['items'][$i - 1];
            $this->assertTrue($a['id'] < $b['id']);
        }

        // ASC
        $response = self::$client->get('/sdp/asset-relations', array(
            '_px_fk' => array(
                'id',
                'id'
            ),
            '_px_fv' => array(
                $item1->id,
                $item2->id
            ),
            '_px_sk' => 'id',
            '_px_so' => 'a'
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');

        $actual = json_decode($response->content, true);
        for ($i = 1; $i < sizeof($actual['items']); $i ++) {
            $a = $actual['items'][$i];
            $b = $actual['items'][$i - 1];
            $this->assertTrue($a['id'] > $b['id']);
        }

        $item1->delete();
        $item2->delete();
    }

    /**
     * Filter asset-relations based on type
     *
     * @test
     */
    public function getListofAssetRelationsFilteredByTypeTest()
    {
        $item1 = new SDP_AssetRelation();
        $item1->type = 'sample';
        $item1->description = 'description';
        $item1->start_id = self::getRandomAsset();
        $item1->end_id = self::getRandomAsset();
        $item1->create();

        $item2 = new SDP_AssetRelation();
        $item2->type = 'relate';
        $item2->description = 'description';
        $item2->start_id = self::getRandomAsset();
        $item2->end_id = self::getRandomAsset();
        $item2->create();

        $item3 = new SDP_AssetRelation();
        $item3->type = 'sample';
        $item3->description = 'description';
        $item3->start_id = self::getRandomAsset();
        $item3->end_id = self::getRandomAsset();
        $item3->create();

        // Filter types sample
        $response = self::$client->get('/sdp/asset-relations', array(
            '_px_fk' => 'type',
            '_px_fv' => 'sample'
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');

        $actual = json_decode($response->content, true);
        for ($i = 0; $i < sizeof($actual['items']); $i ++) {
            $this->assertTrue($actual['items'][$i]['type'] === 'sample');
        }

        // Filter types relate
        $response = self::$client->get('/sdp/asset-relations', array(
            '_px_fk' => 'type',
            '_px_fv' => 'relate'
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');

        $actual = json_decode($response->content, true);
        for ($i = 0; $i < sizeof($actual['items']); $i ++) {
            $this->assertTrue($actual['items'][$i]['type'] === 'relate');
        }

        $item1->delete();
        $item2->delete();
        $item3->delete();
    }

    /**
     *
     * @test
     */
    public function getListofAssetRelationsWithGraphqlTest()
    {
        $params = array(
            'graphql' => '{items{id,type,description,start{id,name},end{id,name}}}'
        );
        $response = self::$client->get('/sdp/asset-relations', $params);
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
    }
}



