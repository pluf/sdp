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
class Asset_OwnerRestTest extends TestCase
{

    /**
     *
     * @var Test_Client
     */
    public static $ownerClient;

    var $drive;

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
     * @before
     */
    public function init()
    {
        $this->drive = new SDP_Drive();
        $this->drive->title = 'CactusDrive-' . rand();
        $this->drive->home = 'www.test.com';
        $this->drive->setMeta('key', 'test_key');
        $this->drive->setMeta('algorithm', 'HS512');
        $this->drive->driver = 'cactus';
        Test_Assert::assertTrue($this->drive->create(), 'Impossible to create cactus drive');
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
    public function createRemoteAssetRestTest()
    {
        $name = 'asset-' . rand();
        $path = '/path/to/file';
        $fileName = 'example.txt';
        $size = 72313;
        $price = rand();
        $form = array(
            'name' => $name,
            'description' => 'description ' . rand(),
            'price' => $price,
            'path' => $path,
            'file_name' => $fileName,
            'size' => $size,
            'drive_id' => $this->drive->id
        );
        $response = self::$ownerClient->post('/api/sdp/assets', $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        Test_Assert::assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertEquals($actual['name'], $name);
        $this->assertEquals($actual['file_name'], $fileName);
        $this->assertEquals($actual['size'], $size);
        $this->assertEquals($actual['price'], $price);
        $this->assertEquals($actual['drive_id'], $this->drive->id);
        // Check unreadable feilds
        $newItem = new SDP_Asset($actual['id']);
        $this->assertEquals($newItem->path, $path);
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
        $response = self::$ownerClient->get('/api/sdp/assets/' . $item->id);
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
        $response = self::$ownerClient->post('/api/sdp/assets/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     *
     * @test
     */
    public function updateRemoteAssetRestTest()
    {
        $item = new SDP_Asset();
        $item->name = 'asset-' . rand();
        $item->description = 'description ' . rand();
        $item->price = rand();
        $item->path = '/path/to/file';
        $item->file_name = 'example.txt';
        $item->size = 72313;
        $item->drive_id = $this->drive;
        $item->create();
        Test_Assert::assertFalse($item->isAnonymous(), 'Could not create SDP_Asset');

        $newPath = '/new/path/to/file';
        $newFileName = 'newname.txt';
        $newName = 'newname' . rand();
        $newPrice = 72000;
        // Update item
        $form = array(
            'name' => $newName,
            'price' => $newPrice,
            'path' => $newPath,
            'file_name' => $newFileName
        );
        $response = self::$ownerClient->post('/api/sdp/assets/' . $item->id, $form);
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
        Test_Assert::assertResponseAsModel($response);
        $actual = json_decode($response->content, true);
        $this->assertEquals($actual['name'], $newName);
        $this->assertEquals($actual['file_name'], $newFileName);
        $this->assertEquals($actual['price'], $newPrice);
        
        // Chech unreadable feilds
        $updated = new SDP_Asset($item->id);
        $this->assertEquals($updated->path, $newPath);
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
        $response = self::$ownerClient->get('/api/sdp/assets');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
}



