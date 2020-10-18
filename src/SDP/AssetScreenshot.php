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

class AssetScreenshot extends Pluf_ModelBinary
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_ModelBinary::init()
     */
    function init()
    {
        parent::init();
        $this->_a['table'] = 'sdp_asset_screenshots';
        $this->_a['cols'] = array_merge($this->_a['cols'], array(
            // Model
            // relations
            'asset_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'is_null' => false,
                'name' => 'asset',
                'relate_name' => 'screenshots',
                'graphql_name' => 'asset',
                'editable' => true
            )
        ));
    }
}
