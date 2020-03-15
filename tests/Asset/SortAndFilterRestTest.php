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
class Asset_SortAndFilterRestTest extends TestCase
{

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
        $response = self::$client->get('/sdp/assets', array(
            '_px_fk' => array('id', 'id'),
            '_px_fv' => array($asset1->id, $asset2->id),
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
        $response = self::$client->get('/sdp/assets', array(
            '_px_fk' => array('id', 'id'),
            '_px_fv' => array($asset1->id, $asset2->id),
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
        $response = self::$client->get('/sdp/assets', array(
            'include_category' => $cat->id
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
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
        $response = self::$client->get('/sdp/assets', array(
            'include_tag' => $tag->id
        ));
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertResponsePaginateList($response, 'Find result is not JSON paginated list');
        
        $actual = json_decode($response->content, true);
        $this->assertTrue(sizeof($actual['items']) === 1);
        $this->assertTrue($actual['items'][0]['id'] === $asset1->id);
        
        $asset1->delete();
        $asset2->delete();
        $tag->delete();
    }
    
}



