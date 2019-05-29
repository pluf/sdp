<?php

class SDP_Link extends Pluf_Model
{

    /**
     *
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_link';
        $this->_a['verbose'] = 'SDP Link';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Pluf_DB_Field_Sequence',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'secure_link' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            'expiry' => array(
                'type' => 'Pluf_DB_Field_Datetime',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            'download' => array(
                'type' => 'Pluf_DB_Field_Integer',
                'is_null' => false,
                'size' => 50,
                'editable' => false,
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
            'active' => array(
                'type' => 'Pluf_DB_Field_Boolean',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'discount_code' => array(
                'type' => 'Pluf_DB_Field_Varchar',
                'blank' => true,
                'is_null' => true,
                'size' => 50,
                'editable' => false,
                'readable' => true
            ),
            // relations
            'asset_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'asset',
                'graphql_name' => 'asset',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            'user_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'User_Account',
                'name' => 'user',
                'graphql_name' => 'user',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true,
            ),
            'payment_id' => array(
                'type' => 'Pluf_DB_Field_Foreignkey',
                'model' => 'Bank_Receipt',
                'name' => 'payment',
                'graphql_name' => 'payment',
                'relate_name' => 'links',
                'is_null' => false,
                'editable' => false,
                'readable' => true,
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

    public static function getLinkBySecureId($secure_link)
    {
        $sql = new Pluf_SQL('secure_link=%s', $secure_link);
        return Pluf::factory('SDP_Link')->getOne($sql->gen());
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

    function hasPayment(){
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