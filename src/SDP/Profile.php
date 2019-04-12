<?php

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
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * تمام فیلدهای مورد نیاز برای این مدل داده‌ای در این متد تعیین شده و به
     * صورت کامل ساختار دهی می‌شود.
     *
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
     * پیش ذخیره را انجام می‌دهد
     *
     * در این فرآیند نیازهای ابتدایی سیستم به آن اضافه می‌شود. این نیازها مقادیری هستند که
     * در زمان ایجاد باید تعیین شوند. از این جمله می‌توان به کاربر و تاریخ اشاره کرد.
     *
     * @param $create حالت
     *            ساخت یا به روز رسانی را تعیین می‌کند
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