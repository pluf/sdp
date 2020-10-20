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
 * Determines an asset. The content of the asset may be stored on the local storage
 * or on a remote storage.
 * 
 * Attributes of an asset are as the following:
 * <ul>
 * <li>name: the name of the asset</li>
 * <li>description: a description about the asset</li>
 * <li>drive_id: a foreign key to a SDP_Drive entity which determines where the content of the asset is placed.</li>
 * <li>path: the path which content of the asset is stored. This field is not editable/readable for assets on local storage (local drive).</li>
 * <li>size: the size of the content of the asset in byte. This field is not editable for assets stored on local storage (local drive) and will be computed automatically from given file.</li>
 * <li>file_name: the name of the file which is set as content of the asset.</li>
 * <li>mime_type: the mime_type of file which is set as content of the asset. This field should be manually set for assets stored on the remote storages.</li>
 * </ul>
 * 
 * @author hadi
 *
 */
class SDP_Asset extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_asset';
        $this->_a['verbose'] = 'SDP Asset';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'title' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 256,
                'editable' => true,
                'readable' => true
            ),
            'path' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 256,
                'editable' => false,
                'readable' => false
            ),
            'size' => array(
                'type' => 'Integer',
                'is_null' => false,
                'default' => 0,
                'editable' => false,
                'readable' => true
            ),
            'file_name' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'default' => 'noname',
                'size' => 256,
                'editable' => true,
                'readable' => true
            ),
            'download' => array(
                'type' => 'Integer',
                'is_null' => false,
                'default' => 0,
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
            'description' => array(
                'type' => 'Text',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'mime_type' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 64,
                'editable' => false,
                'readable' => true
            ),
            'media_type' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 64,
                'editable' => true,
                'readable' => true
            ),
            'price' => array(
                'type' => 'Integer',
                'is_null' => false,
                'default' => 0,
                'editable' => true,
                'readable' => true
            ),
            'cover' => array(
                'type' => 'Varchar',
                'size' => 1024,
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'state' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 64,
                'default' => '',
                'editable' => false
            ),
            // relations
            'parent_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'parent',
                'graphql_name' => 'parent',
                'relate_name' => 'children',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'owner_id' => array(
                'type' => 'Foreignkey',
                'model' => 'User_Account',
                'is_null' => false,
                'name' => 'owner',
                'relate_name' => 'assets',
                'graphql_name' => 'owner',
                'editable' => false
            ),
//             'content_id' => array(
//                 'type' => 'Foreignkey',
//                 'model' => 'CMS_Content',
//                 'name' => 'content',
//                 'graphql_name' => 'content',
//                 'relate_name' => 'assets',
//                 'is_null' => true,
//                 'editable' => true,
//                 'readable' => true
//             ),
            'drive_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Drive',
                'is_null' => true,
                // Note: Hadi, 1398: do not set 'name' => 'drive'. It will cause to error.
                'relate_name' => 'assets',
                'graphql_name' => 'drive',
                'editable' => false,
                'readable' => true
            )
        );

        $this->_a['idx'] = array(
            'page_class_idx' => array(
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
        if ($this->isLocal()) {
            // File path
            $path = $this->getAbsloutPath();
            // file size
            if (file_exists($path)) {
                $this->size = filesize($path);
            } else {
                $this->size = 0;
            }
        }
        // mime type (based on file name)
        $mime_type = $this->mime_type;
        if (! isset($mime_type) || $mime_type === 'application/octet-stream') {
            $fileInfo = Pluf_FileUtil::getMimeType($this->file_name);
            $this->mime_type = $fileInfo[0];
        }
    }

    /**
     * \brief عملیاتی که قبل از پاک شدن است انجام می‌شود
     *
     * عملیاتی که قبل از پاک شدن است انجام می‌شود
     * در این متد فایل مربوط به است حذف می شود. این عملیات قابل بازگشت نیست
     */
    function preDelete()
    {
        if (file_exists($this->path . '/' . $this->id)) {
            unlink($this->path . '/' . $this->id);
        }
    }

    /**
     * Returns true if asset is stored on local drive
     *
     * @return boolean
     */
    function isLocal()
    {
        return $this->drive_id == 0;
    }

    function get_drive()
    {
        if ($this->isLocal()) {
            return SDP_Service::defaultLocalDrive();
        }
        return $this->get_drive_id();
    }

    /**
     * Returns the full path to the content of the asset.
     * This path contains the name of the file also.
     *
     * @return string
     */
    public function getAbsloutPath()
    {
        return $this->path . '/' . $this->id;
    }
}
