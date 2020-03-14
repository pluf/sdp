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
 * ایجاد یک لینک امن جدید
 *
 * با استفاده از این فرم می‌توان یک لینک امن جدید را ایجاد کرد.
 *
 * @author Mahdi
 *
 */
class SDP_Form_LinkCreate extends Pluf_Form
{

    public $asset = null;

    public $user = null;

    public function initFields($extra = array())
    {
        $this->asset = $extra['asset'];
        $this->user = $extra['user'];

        $this->fields['secure_link'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'SecureLink',
            'help_text' => 'Secure Link'
        ));
        $this->fields['expiry'] = new Pluf_Form_Field_Varchar(array(
            'required' => false,
            'label' => 'expiry',
            'help_text' => 'Datetime of expiry'
        ));
        $this->fields['download'] = new Pluf_Form_Field_Integer(array(
            'required' => false,
            'label' => 'Path',
            'help_text' => 'Path of asset'
        ));
    }

    function save($commit = true)
    {
        if (! $this->isValid()) {
            throw new Pluf_Exception('cannot save the link from an invalid form');
        }
        // Create the link
        $link = new SDP_Link();
        $link->secure_link = chunk_split(substr(md5(time() . rand(10000, 99999)), 0, 20), 6, '');
        // Note: Hadi - 1396-04: time is base on day
        $day = Tenant_Service::setting('temporary_link_valid_time', '1');
        $expiryDay = ' +' . $day . ' day';
        $link->expiry = date('Y-m-d H:i:s', strtotime($expiryDay));
        $link->setFromFormData($this->cleaned_data);
        $link->asset_id = $this->asset;
        $link->user_id = $this->user;
        if ($commit) {
            $link->create();
        }
        return $link;
    }
}
