<?php

/**
 *
 * @author hadi <mohammad.hadi.mansouri@dpq.co.ir>
 *
 */
class SDP_AssetReview extends Pluf_Model
{

    /**
     *
     * {@inheritdoc}
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_asset_reviews';
        $this->_a['verbose'] = 'SDP Asset Reviews';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'blank' => false,
                'editable' => false,
                'readable' => true
            ),
            'text' => array(
                'type' => 'Text',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'mime_type' => array(
                'type' => 'Varchar',
                'size' => 64,
                'default' => 'text/plain',
                'is_null' => true,
                'editable' => true,
                'readable' => true
            ),
            'creation_dtime' => array(
                'type' => 'Datetime',
                'is_null' => false,
                'editable' => false,
                'readable' => true
            ),
            /*
             * Relations
             */
            'asset_id' => array(
                'type' => 'Foreignkey',
                'model' => 'SDP_Asset',
                'name' => 'asset',
                'relate_name' => 'reviews',
                'graphql_field' => true,
                'graphql_name' => 'asset',
                'is_null' => false,
                'editable' => true,
                'readable' => true
            ),
            'writer_id' => array(
                'type' => 'Foreignkey',
                'model' => 'User_Account',
                'name' => 'writer',
                'relate_name' => 'asset_reviews',
                'graphql_field' => true,
                'graphql_name' => 'writer',
                'is_null' => false,
                'editable' => false,
                'readable' => true
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
    }
}