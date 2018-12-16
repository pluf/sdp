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
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\IncompleteTestError;
require_once 'Pluf.php';

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Asset_RestTest extends TestCase
{

    /**
     * 
     * @var Test_Client
     */
    public static $ownerClient;
    public static $client;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__.'/../conf/config.php');
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
        self::$client = new Test_Client(array(
            array(
                'app' => 'SDP',
                'regex' => '#^/api/sdp#',
                'base' => '',
                'sub' => include 'SDP/urls.php'
            ),
            array(
                'app' => 'User',
                'regex' => '#^/api/user#',
                'base' => '',
                'sub' => include 'User/urls.php'
            )
        ));
        // Owner Client
        self::$ownerClient = new Test_Client(array(
            array(
                'app' => 'SDP',
                'regex' => '#^/api/sdp#',
                'base' => '',
                'sub' => include 'SDP/urls.php'
            ),
            array(
                'app' => 'User',
                'regex' => '#^/api/user#',
                'base' => '',
                'sub' => include 'User/urls.php'
            )
        ));
        self::$ownerClient->post('/api/user/login', array(
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
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->unInstall();
    }

    /**
     *
     * @test
     */
    public function createRestTest()
    {
        $form = array(
            'name' => 'asset-' . rand(),
            'description' => 'description ' . rand(),
            'price' => rand()
        );
        $response = self::$ownerClient->post('/api/sdp/assets', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        
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
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        // Get item
        $response = self::$client->get('/api/sdp/assets/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    /**
     *
     * @test
     */
    public function updateRestTest()
    {
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->price = rand();
        $item->create();
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        // Update item
        $form = array(
            'price' => rand()
        );
        $response = self::$client->post('/api/sdp/assets/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    /**
     *
     * @test
     */
    public function deleteRestTest()
    {
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description';
        $item->price = rand();
        $item->create();
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');
        
        // delete
        $response = self::$ownerClient->delete('/api/sdp/assets/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    /**
     *
     * @test
     */
    public function findRestTest()
    {
        $response = self::$client->get('/api/sdp/assets');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    /**
     *
     * @test
     */
    public function getListofAssetsTest()
    {
        $response = self::$client->get('/api/sdp/assets');
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
    }

    /**
     * Sort assets based on id
     * @test
     */
    public function getListofAssetsSortByIdTest()
    {
        $asset1 = new SDP_Asset();
        $asset1->name ='name'. rand();
        $asset1->create();
        
        $asset2 = new SDP_Asset();
        $asset2->name ='name'. rand();
        $asset2->create();
        
        // DESC
        $response = self::$client->get('/api/sdp/assets', array(
            '_px_fk' => array('id', 'id'),
            '_px_fv' => array($asset1->id, $asset2->id),
            '_px_sk' => 'id',
            '_px_so' => 'd'
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
        $actual = json_decode($response->content, true);
        for ($i = 1; $i < sizeof($actual['items']); $i ++) {
            $a = $actual['items'][$i];
            $b = $actual['items'][$i - 1];
            $this->assertTrue($a['id'] < $b['id']);
        }
        
        // ASC
        $response = self::$client->get('/api/sdp/assets', array(
            '_px_fk' => array('id', 'id'),
            '_px_fv' => array($asset1->id, $asset2->id),
            '_px_sk' => 'id',
            '_px_so' => 'a'
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
        $actual = json_decode($response->content, true);
        for ($i = 1; $i < sizeof($actual['items']); $i ++) {
            $a = $actual['items'][$i];
            $b = $actual['items'][$i - 1];
            $this->assertTrue($a['id'] > $b['id']);
        }
        
        $asset1->delete();
        $asset2->delete();
    }

    
    /**
     * Sort assets based on id
     * @test
     */
    public function getListofAssetsFilteredByCategoryTest()
    {
        $asset1 = new SDP_Asset();
        $asset1->name ='name'. rand();
        $asset1->create();
        
        $asset2 = new SDP_Asset();
        $asset2->name ='name'. rand();
        $asset2->create();
        
        $cat = new SDP_Category();
        $cat->name = 'category-' . rand();
        $cat->description = 'description';
        $cat->price = rand();
        $cat->create();
        
        // add asset1 to category
        $asset1->setAssoc($cat);
        
        // Get assets in category
        $response = self::$client->get('/api/sdp/assets', array(
            'include_category' => $cat->id
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
        $actual = json_decode($response->content, true);
        $this->assertTrue(sizeof($actual['items']) === 1);
        $this->assertTrue($actual['items'][0]['id'] === $asset1->id);
        
        $asset1->delete();
        $asset2->delete();
        $cat->delete();
    }
    
    /**
     * Sort assets based on id
     * @test
     */
    public function getListofAssetsFilteredByTagTest()
    {
        $asset1 = new SDP_Asset();
        $asset1->name ='name'. rand();
        $asset1->create();
        
        $asset2 = new SDP_Asset();
        $asset2->name ='name'. rand();
        $asset2->create();
        
        $tag = new SDP_Tag();
        $tag->name = 'tag-' . rand();
        $tag->description = 'description';
        $tag->create();
        
        // add tag to asset1
        $asset1->setAssoc($tag);
        
        // Get assets with tag
        $response = self::$client->get('/api/sdp/assets', array(
            'include_tag' => $tag->id
        ));
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
        $actual = json_decode($response->content, true);
        $this->assertTrue(sizeof($actual['items']) === 1);
        $this->assertTrue($actual['items'][0]['id'] === $asset1->id);
        
        $asset1->delete();
        $asset2->delete();
        $tag->delete();
    }
    
}



