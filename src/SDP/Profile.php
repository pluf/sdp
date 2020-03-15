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

/**
 * ساختار داده‌ای پروفایل کاربر را تعیین می‌کند.
 * 
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *
 */
class SDP_Profile extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_profile';
        $this->_a['model'] = 'SDP_Profile';
        $this->_model = 'SDP_Profile';

        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'is_null' => false,
                'editable' => false
            ),
            'level' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'unique' => false,
                'editable' => false
            ),
            'access_count' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'unique' => false,
                'editable' => false
            ),
            'validate' => array(
                'type' => 'Pluf_DB_Field_Boolean',
                'default' => false,
                'is_null' => false,
                'editable' => false
            ),
            'activity_field' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'size' => 100,
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'address' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 200
            ),
            'mobile_number' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 50,
                'unique' => false
            ),
            'creation_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => false,
                'editable' => false
            ),
            'modif_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => false,
                'editable' => false
            ),
            /*
             * Foreign Keys
             */
            'account_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'User_Account',
                'unique' => true,
                'name' => 'account',
                'graphql_name' => 'account',
                'relate_name' => 'sdp_profiles',
                'is_null' => false,
                'editable' => false
            )
        );
    }

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::preSave()
     */
    function preSave($create = false)
    {
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
            $this->access_count = 0;
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }
}