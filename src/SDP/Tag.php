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

class SDP_Tag extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_tag';
        $this->_a['verbose'] = 'SDP Tag';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'name' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 250,
                'editable' => true,
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
            'description' => array(
                'type' => 'Text',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            // relations
            'assets' => array(
                'type' => 'Manytomany',
                'model' => 'SDP_Asset',
                'relate_name' => 'tags',
                'blank' => false,
                'editable' => false,
                'readable' => false
            )
        );

        $this->_a['idx'] = array(
            'tag_name_idx' => array(
                'col' => 'name',
                'type' => 'unique', // normal, unique, fulltext, spatial
                'index_type' => '', // hash, btree
                'index_option' => '',
                'algorithm_option' => '',
                'lock_option' => ''
            )
        );
    }

    /**
     * Returns tag by given name
     *
     * @param string $name
     * @return SDP_Tag
     */
    public static function getTag($name)
    {
        $model = new SDP_Tag();
        $where = new Pluf_SQL('name = %s', array(
            $model->_toDb($name, 'name')
        ));
        $tags = $model->getList(array(
            'filter' => $where->gen()
        ));
        if ($tags === false or count($tags) !== 1) {
            return false;
        }
        return $tags[0];
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
}