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
use Pluf\Test\TestCase;

class SDP_ApiTest extends TestCase
{

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
    }

    /**
     *
     * @test
     */
    public function testClassInstance()
    {
        $object = new SDP_Asset();
        $this->assertTrue(isset($object), 'SDP_Asset could not be created!');
        $object = new SDP_AssetRelation();
        $this->assertTrue(isset($object), 'SDP_AssetRelation could not be created!');
        $object = new SDP_Category();
        $this->assertTrue(isset($object), 'SDP_Category could not be created!');
        $object = new SDP_Tag();
        $this->assertTrue(isset($object), 'SDP_Tag could not be created!');
        $object = new SDP_Link();
        $this->assertTrue(isset($object), 'SDP_Link could not be created!');
        $object = new SDP_Profile();
        $this->assertTrue(isset($object), 'SDP_Profile could not be created!');
        $object = new SDP_Drive();
        $this->assertTrue(isset($object), 'SDP_Drive could not be created!');
        $object = new SDP_Driver_Local();
        $this->assertTrue(isset($object), 'SDP_Driver_Local could not be created!');
        $object = new SDP_Driver_Cactus();
        $this->assertTrue(isset($object), 'SDP_Driver_Cactus could not be created!');
    }
}

