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
class Profile_RestTest extends TestCase
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
        $user = new User_Account();
        $user = $user->getUser('test');

        $form = array(
            'activity_field' => 'field-' . rand(),
            'address' => 'address-' . rand(),
            'mobile_number' => '09171112233 '
        );
        $response = self::$ownerClient->post('/api/sdp/accounts/' . $user->id . '/profiles', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function getRestTest()
    {
        $user = new User_Account();
        $user = $user->getUser('test');

        $item = new SDP_Profile();
        $item = $item->getOne('account_id=' . $user->id);
        if ($item == null) {
            $item = new SDP_Profile();
            $item->activity_field = 'field-' . rand();
            $item->address = 'address-' . rand();
            $item->mobile_number = '09171112233';
            $item->account_id = $user;
            $item->create();
        }
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Profile');
        // Get item
        $response = self::$client->get('/api/sdp/accounts/' . $user->id . '/profiles/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function updateRestTest()
    {
        $user = new User_Account();
        $user = $user->getUser('test');
        
        $item = new SDP_Profile();
        $item = $item->getOne('account_id=' . $user->id);
        if ($item == null) {
            $item = new SDP_Profile();
            $item->activity_field = 'updated-field-' . rand();
            $item->address = 'aupdated-ddress-' . rand();
            $item->mobile_number = '09171112233';
            $item->account_id = $user;
            $item->create();
        }
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Profile');
        // Update item
        $form = array(
            'activity_field' => 'updated-field-' . rand(),
            'address' => 'updated-address-' . rand()
        );
        $response = self::$client->post('/api/sdp/accounts/' . $user->id . '/profiles/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function deleteRestTest()
    {
        $user = new User_Account();
        $user = $user->getUser('test');

        $item = new SDP_Profile();
        $item = $item->getOne('account_id=' . $user->id);
        if ($item == null) {
            $item = new SDP_Profile();
            $item->activity_field = 'field-' . rand();
            $item->address = 'address-' . rand();
            $item->mobile_number = '09171112233';
            $item->account_id = $user;
            $item->create();
        }
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Profile');

        // delete
        $response = self::$ownerClient->delete('/api/sdp/accounts/' . $user->id . '/profiles/' . $item->id);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function findRestTest()
    {
        $user = new User_Account();
        $user = $user->getUser('test');

        $response = self::$client->get('/api/sdp/accounts/' . $user->id . '/profiles');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function getListofProfilesTest()
    {
        $user = new User_Account();
        $user = $user->getUser('test');

        $response = self::$client->get('/api/sdp/accounts/' . $user->id . '/profiles');
        Test_Assert::assertResponseNotNull($response, 'Find result is empty');
        Test_Assert::assertResponseStatusCode($response, 200, 'Find status code is not 200');
        Test_Assert::assertResponsePaginateList($response, 'Find result is not JSON paginated list');
    }
}



