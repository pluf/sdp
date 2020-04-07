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
Pluf::loadFunction('SDP_Shortcuts_GetDriverOr404');

/**
 * Remote or local drives to store content of asstes
 *
 * @author hadi
 *        
 */
class SDP_Drive extends Pluf_Model
{

    public $data = array();

    public $touched = false;

    /**
     *
     * @brief Determines the data model
     *
     * All necessary fields for this data model are determined in this method.
     *
     * @see Pluf_Model::init()
     */
    function init()
    {
        $this->_a['table'] = 'sdp_drives';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => 'Sequence',
                'blank' => false,
                'editable' => false,
                'readable' => true
            ),
            'title' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 64,
                'editable' => true,
                'readable' => true
            ),
            'description' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 512,
                'editable' => true,
                'readable' => true
            ),
            'home' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'size' => 256,
                'editable' => true,
                'readable' => true
            ),
            'meta' => array(
                'type' => 'Varchar',
                'is_null' => true,
                'secure' => true,
                'size' => 3000,
                'editable' => false,
                'readable' => false
            ),
            'driver' => array(
                'type' => 'Varchar',
                'is_null' => false,
                'size' => 50
            ),
            'deleted' => array(
                'type' => 'Boolean',
                'is_null' => false,
                'default' => false,
                'readable' => true,
                'editable' => false
            ),
            'creation_dtime' => array(
                'type' => 'Datetime',
                'is_null' => true,
                'editable' => false,
                'readable' => true
            ),
            'modif_dtime' => array(
                'type' => 'Datetime',
                'is_null' => true,
                'editable' => false,
                'readable' => true
            )
        );
    }

    /*
     * @see Pluf_Model::preSave()
     */
    function preSave($create = false)
    {
        $this->meta = serialize($this->data);
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    /**
     * داده‌های ذخیره شده را بازیابی می‌کند
     */
    function restore()
    {
        $this->data = unserialize($this->meta);
    }

    /**
     * تمام داده‌های موجود در نشت را پاک می‌کند.
     *
     * تمام داده‌های ذخیره شده در نشست را پاک می‌کند.
     */
    function clear()
    {
        $this->data = array();
        $this->touched = true;
    }

    /**
     * تعیین یک داده در نشست
     *
     * با استفاده از این فراخوانی می‌توان یک داده با کلید جدید در نشست ایجاد
     * کرد. این کلید برای دستیابی‌های
     * بعد مورد استفاده قرار خواهد گرفت.
     *
     * @param
     *            کلید داده
     * @param
     *            داده مورد نظر. در صورتی که مقدار آن تهی باشد به معنی
     *            حذف است.
     */
    function setMeta($key, $value = null)
    {
        if (is_null($value)) {
            unset($this->data[$key]);
        } else {
            $this->data[$key] = $value;
        }
        $this->touched = true;
    }

    /**
     * داده معادل با کلید تعیین شده را برمی‌گرداند
     *
     * در صورتی که داده تعیین نشده بود مقدار پیش فرض تعیین شده به عنوان نتیجه
     * این فراخوانی
     * برگردانده خواهد شد.
     */
    function getMeta($key = null, $default = '')
    {
        if (is_null($key)) {
            return parent::getData();
        }
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }

//     private function getGlobalSelect()
//     {
//         if (isset($this->_cache['getGlobalSelect']))
//             return $this->_cache['getGlobalSelect'];
//         $select = array();
//         $table = $this->getSqlTable();
//         foreach ($this->_a['cols'] as $col => $val) {
//             if (($val['type'] == 'Manytomany') || (array_key_exists('secure', $val) && $val['secure'])) {
//                 continue;
//             }
//             $select[] = $table . '.' . $this->_con->qn($col) . ' AS ' . $this->_con->qn($col);
//         }
//         $this->_cache['getSelect'] = implode(', ', $select);
//         return $this->_cache['getSelect'];
//     }

    /**
     *
     * @return SDP_Driver
     */
    public function get_Driver()
    {
        return SDP_Shortcuts_GetDriverOr404($this->driver);
    }
}