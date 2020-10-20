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
 * 
 */
class SDP_AssetMeta extends Pluf_Model
{

    /**
     * Initial content meta data
     * 
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_asset_metas';
        $this->_a['cols'] = array(
            // Identifier
            'id' => array(
                'type' => 'Sequence',
                'is_null' => false,
                'editable' => false
            ),
            // Fields
            'key' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 256,
                'unique' => true,
                'editable' => true
            ),
            'value' => array(
                'type' => 'Text',
                'is_null' => true,
                'default' => '',
                'editable' => true
            ),
            // Foreign keys
            'asset_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'asset',
                'graphql_name' => 'asset',
                'relate_name' => 'metas',
                'is_null' => true,
                'editable' => true
            ),
        );
    }
    
    /**
     * Extract information of a meta and returns it.
     *
     * @param string $key
     * @param int $assetId
     * @return SDP_AssetMeta
     */
    public static function getMeta($key, $assetId)
    {
        $model = new SDP_AssetMeta();
        $where = new Pluf_SQL('`key`=%s AND `asset_id`=%s', array(
            $model->_toDb($key, 'key'),
            $model->_toDb($assetId, 'asset_id')
        ));
        $metas = $model->getList(array(
            'filter' => $where->gen()
        ));
        if ($metas === false or count($metas) !== 1) {
            return false;
        }
        return $metas[0];
    }
    
}