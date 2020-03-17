<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. http://dpq.co.ir
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
namespace Pluf\SDP;

use Pluf;

class Module extends \Pluf\Module
{

    const moduleJsonPath = __DIR__ . '/module.json';

    const relations = array(
        'SDP_Link' => array(
            'relate_to' => array(
                'SDP_Asset',
                'User_Account',
                'Bank_Receipt'
            )
        ),
        'SDP_Asset' => array(
            // XXX: note: hadi, 1396-03: commented to avoid casecade deleting *****
            // 'relate_to' => array(
            // 'SDP_Asset',
            // 'CMS_Content',
            // 'SDP_Drive'
            // )
            // ******
            // ,
            // 'relate_to_many' => array(
            // 'SDP_Tag',
            // 'SDP_Category'
            // )
        ),
        'SDP_Category' => array(
            // XXX: note: hadi, 1396-03: commented to avoid casecade deleting *****
            // 'relate_to' => array(
            // 'CMS_Content',
            // 'SDP_Category'
            // ),
            // *****
            'relate_to_many' => array(
                'SDP_Asset'
            )
        ),
        'SDP_Tag' => array(
            'relate_to_many' => array(
                'SDP_Asset'
            )
        ),
        'SDP_Profile' => array(
            'relate_to' => array(
                'User_Account'
            )
        )
    );

    public function init(Pluf $bootstrap): void
    {}
}

