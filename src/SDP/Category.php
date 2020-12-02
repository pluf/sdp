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
class SDP_Category extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_category';
        $this->_a['verbose'] = 'SDP Category';
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
            'slug' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'unique' => true,
                'size' => 256,
                'editable' => true
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
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 250,
                'editable' => true,
                'readable' => true
            ),
            'thumbnail' => array(
                'type' => 'Varchar',
                'size' => 1024,
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            // relations
            'parent_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Category',
                'name' => 'parent',
                'graphql_name' => 'parent',
                'relate_name' => 'children',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            // 'content_id' => array(
            // 'type' => 'Foreignkey',
            // 'model' => 'CMS_Content',
            // 'name' => 'content',
            // 'graphql_name' => 'content',
            // 'relate_name' => 'categories',
            // 'is_null' => true,
            // 'editable' => true,
            // 'readable' => true
            // ),
            'assets' => array(
                'type' => 'Manytomany',
                'model' => 'SDP_Asset',
                'relate_name' => 'categories',
                'blank' => false,
                'editable' => false,
                'readable' => false
            )
        );

        $this->_a['idx'] = array(
            'category_idx' => array(
                'col' => 'parent_id, name',
                'type' => 'unique', // normal, unique, fulltext, spatial
                'index_type' => '', // hash, btree
                'index_option' => '',
                'algorithm_option' => '',
                'lock_option' => ''
            )
        );
    }

    /**
     * Returns category by given slug
     *
     * @param string $slug
     * @return SDP_Category
     */
    public static function getCategory($slug)
    {
        $model = new SDP_Category();
        $where = new Pluf_SQL('slug = %s', array(
            $model->_toDb($slug, 'slug')
        ));
        $cats = $model->getList(array(
            'filter' => $where->gen()
        ));
        if ($cats === false or count($cats) !== 1) {
            return false;
        }
        return $cats[0];
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