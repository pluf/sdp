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
class SDP_Link extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_link';
        $this->_a['verbose'] = 'SDP Link';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'secure_link' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            'expiry' => array(
                'type' => 'Datetime',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            'download' => array(
                'type' => 'Integer',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            'creation_dtime' => array(
                'type' => 'Datetime',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'modif_dtime' => array(
                'type' => 'Datetime',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'active' => array(
                'type' => 'Boolean',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'discount_code' => array(
                'type' => 'Varchar',
                'blank' => true,
                'is_null' => true,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            // relations
            'asset_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'asset',
                'graphql_name' => 'asset',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'user_id' => array(
                'type' => 'Foreignkey',
                'model' => 'User_Account',
                'name' => 'user',
                'graphql_name' => 'user',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'payment_id' => array(
                'type' => 'Foreignkey',
                'model' => 'Bank_Receipt',
                'name' => 'payment',
                'graphql_name' => 'payment',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            )
        );

        $this->_a['idx'] = array(
            'secure_link_idx' => array(
                'col' => 'secure_link',
                'type' => 'unique', // normal, unique, fulltext, spatial
                'index_type' => '', // hash, btree
                'index_option' => '',
                'algorithm_option' => '',
                'lock_option' => ''
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
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    public static function getLinkBySecureId($secure_link)
    {
        $sql = new Pluf_SQL('secure_link=%s', $secure_link);
        return Pluf::factory(SDP_Link::class)->getOne($sql->gen());
    }

    function isActive()
    {
        return $this->active;
    }

    function activate()
    {
        if ($this->active) {
            return;
        }
        // It is first time to activate link
        // Note: Hadi - 1396-04: time is base on day
        $day = Tenant_Service::setting(SDP_Constants::SETTING_KEY_LINK_VALID_DAY, '30');
        $expiryDay = ' +' . $day . ' day';
        $this->expiry = date('Y-m-d H:i:s', strtotime($expiryDay));
        $this->active = true;
        $this->update();
    }

    function hasPayment()
    {
        return $this->payment_id != null && $this->payment_id != 0;
    }

    function isPayed()
    {
        if (! $this->hasPayment()) {
            return false;
        }
        $receipt = $this->get_payment();
        Bank_Service::update($receipt);
        return $this->get_payment()->isPayed();
    }
}