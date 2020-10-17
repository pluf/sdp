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
use Firebase\JWT\JWT;
use Pluf\Test\Client;
use Pluf\Test\TestCase;

class Driver_CactusTest extends TestCase
{

    /**
     *
     * @var User_Account
     */
    var $user;

    /**
     *
     * @var SDP_Link
     */
    var $link;

    /**
     *
     * @var SDP_Asset
     */
    var $asset;

    var $client;

    var $drive;

    var $jwt_key = 'test_key';

    var $jwt_alg = 'HS512';

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

        // Drive
        $this->drive = new SDP_Drive();
        $this->drive->title = 'CactusDrive-' . rand();
        $this->drive->home = 'www.test.com';
        $this->drive->setMeta('encrypt_key', $this->jwt_key);
        $this->drive->setMeta('decrypt_key', $this->jwt_key);
        $this->drive->setMeta('algorithm', $this->jwt_alg);
        $this->drive->driver = 'cactus';
        $this->assertTrue($this->drive->create(), 'Impossible to create cactus drive');

        // Asset
        $this->asset = new SDP_Asset();
        $this->asset->name = 'asset-' . rand();
        $this->asset->description = 'It is my asset description';
        $this->asset->price = 0;
        $this->asset->path = '/test/for/cactus';
        $this->asset->file_name = 'test.png';
        $this->asset->drive_id = $this->drive;
        $this->assertTrue($this->asset->create(), 'Impossible to create asset');

        // Link
        $this->link = new SDP_Link();
        $this->link->secure_link = rand(1000000000, 9999999999) . '' . rand(1000000000, 9999999999);
        $this->link->asset_id = $this->asset;
        $this->link->active = true;
        $this->link->expiry = '2050-1-1 00:00:00';
        $this->link->user_id = $this->user;
        $this->assertTrue($this->link->create(), 'Impossible to create link');
    }

    /**
     *
     * @test
     */
    public function encodeDecodeTest()
    {
        $token = array(
            'key1' => 'value1',
            'key2' => 100,
            'obj1' => array(
                'obj_key1' => 'obj_value1',
                'obj_key2' => true
            )
        );
        $encode = JWT::encode($token, $this->jwt_key, $this->jwt_alg);
        $this->assertNotNull($encode);

        $decode = JWT::decode($encode, $this->jwt_key, array(
            $this->jwt_alg
        ));
        $this->assertEquals($decode->key1, $token['key1']);
        $this->assertEquals($decode->key2, $token['key2']);
        $this->assertEquals($decode->obj1->obj_key1, $token['obj1']['obj_key1']);
        $this->assertEquals($decode->obj1->obj_key2, $token['obj1']['obj_key2']);
    }

    /**
     *
     * @test
     */
    public function cactusResponseTest()
    {
        $response = $this->client->get('/sdp/links/' . $this->link->secure_link . '/content');

        $this->assertResponseNotNull($response);
        $this->assertResponseStatusCode($response, 301);

        $url = $response->headers['Location'];
        $matches = null;
        preg_match("/^(?P<home>.+)\/api\/v2\/cactus\/files\/(?P<jwt>.+)\/content$/", $url, $matches);
        $this->assertNotNull($matches);
        $this->assertNotNull($matches['jwt']);
        $this->assertEquals($matches['home'], $this->drive->home);

        $decode = JWT::decode($matches['jwt'], $this->drive->getMeta('decrypt_key'), array(
            $this->drive->getMeta('algorithm')
        ));

        $this->assertEquals($decode->path, $this->asset->path . '/' . $this->asset->file_name);
        $this->assertEquals($decode->expiry, $this->link->expiry);
        $this->assertEquals($decode->access, 'r');
        $this->assertEquals($decode->account->id, $this->user->id);
    }
}



