<?php

class SDP_Category extends Pluf_Model
{

    /**
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_category';
        $this->_a['verbose'] = 'SDP Category';
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
            'creation_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'modif_dtime' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => false,
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
                'model' => 'SDP_Category',
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
                'relate_name' => 'categories',
                'is_null' => true,
                'editable' => true,
                'readable' => true,
            ),
            'assets' => array(
                'type' => 'Pluf_DB_Field_Manytomany',
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
        
    }
}