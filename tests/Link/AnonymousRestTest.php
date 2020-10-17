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

class Link_AnonymousRestTest extends TestCase
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

        // Asset
        $this->asset = new SDP_Asset();
        $this->asset->name = 'asset-' . rand();
        $this->asset->description = 'It is my asset description';
        $this->asset->price = 0;
        // $this->asset->drive_id = 0;
        $this->asset->path = Pluf::f('upload_path');
        $this->assertTrue($this->asset->create(), 'Impossible to create asset');

        $res = copy(__DIR__ . '/../data/sample.txt', $this->asset->path . '/' . $this->asset->id);
        $this->assertTrue($res, 'Impossible to copy file');

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
     * Anonymous user should not be able to create new link
     *
     * @expectedException \Pluf_Exception_Unauthorized
     * @test
     */
    public function createLinkTest()
    {
        $response = $this->client->post('/sdp/assets/' . $this->asset->id . '/links');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 401);
    }

    /**
     * Anyone (logged in or not) should be able to download an asset from secure link
     *
     * @test
     */
    public function downloadFromLinkTest()
    {
        $response = $this->client->get('/sdp/links/' . $this->link->secure_link . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Anonymous user should not be able to get list of links
     *
     * @test
     */
    public function getListOfLinksTest()
    {
        $this->expectException(Pluf_Exception_Unauthorized::class);
        $response = $this->client->get('/sdp/links');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 401);
    }
}



