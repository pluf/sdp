<?php

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
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_asset';
        $this->_a['verbose'] = 'SDP Asset';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'name' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 250,
                'editable' => true,
                'readable' => true
            ),
            'path' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 250,
                'editable' => false,
                'readable' => false
            ),
            'size' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'default' => 0,
                'editable' => false,
                'readable' => true
            ),
            'file_name' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'default' => 'noname',
                'size' => 256,
                'editable' => true,
                'readable' => true
            ),
            'download' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'default' => 0,
                'editable' => false,
                'readable' => true
            ),
            'creation_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => true,
                'editable' => false,
                'readable' => true
            ),
            'modif_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => true,
                'editable' => false,
                'readable' => true
            ),
            'type' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 250,
                'editable' => false,
                'readable' => true
            ),
            'description' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 250,
                'editable' => true,
                'readable' => true
            ),
            'mime_type' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => true,
                'size' => 250,
                'editable' => false,
                'readable' => true
            ),
            'price' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'default' => 0,
                'editable' => true,
                'readable' => true
            ),
            'thumbnail' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'size' => 1024,
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            // relations
            'parent_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'parent',
                'graphql_name' => 'parent',
                'relate_name' => 'children',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'content_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'CMS_Content',
                'name' => 'content',
                'graphql_name' => 'content',
                'relate_name' => 'assets',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'drive_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
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
                'col' => 'parent, name',
                'type' => 'unique', // normal, unique, fulltext, spatial
                'index_type' => '', // hash, btree
                'index_option' => '',
                'algorithm_option' => '',
                'lock_option' => ''
            )
        );
    }

    /**
     * \brief پیش ذخیره را انجام می‌دهد
     *
     * @param $create حالت
     *            ساخت یا به روز رسانی را تعیین می‌کند
     */
    function preSave($create = false)
    {
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    /**
     * حالت کار ایجاد شده را به روز می‌کند
     *
     * @see Pluf_Model::postSave()
     */
    function postSave($create = false)
    {
        //
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
}
