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
 * ارتباط بین دو SDP_Asset را تعریف می‌کند. در یک ارتباط بین دو دارایی موارد زیر باید تعریف شوند:
 * - type: نوع ارتباط. مثلا یک دارایی خلاصه دارایی دیگر است. یا یک دارایی نسخه قبلی دارایی دیگر است.
 * - start: ابتدای ارتباط یا به عبارتی پدر
 * - end: انتهای ارتباط یا به عبارتی فرزند

 * مثال: به عنوان مثال اگر یک دارایی با شناسه ۱ داشته باشیم که یک کتاب باشد و 
 * یک دارایی دیگر با شناسه ۲ داشته باشیم که خلاصه آن کتاب باشد می‌توان رابطه‌ای به صورت زیر بین آن‌ها تعریف کرد:
 * {
 *      type : summary
 *      start : 1
 *      end : 2
 * }
 * این یعنی دارایی ۲ خلاصه داریی ۱ است 
 * @author hadi
 *
 */
class SDP_AssetRelation extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_assetrelation';
        $this->_a['verbose'] = 'AssetRelation';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'type' => array(
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
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 250,
                'editable' => true,
                'readable' => true
            ),
            // relations
            'start_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'is_null' => false,
                'name' => 'start',
                'graphql_name' => 'start',
                'relate_name' => 'start_relations',
                'editable' => true,
                'readable' => true
            ),
            'end_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'is_null' => false,
                'name' => 'end',
                'graphql_name' => 'end',
                'relate_name' => 'end_relations',
                'editable' => true,
                'readable' => true
            )
        );

        $this->_a['idx'] = array(
            'assetrelation_class_idx' => array(
                'col' => 'type, start_id, end_id',
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
}