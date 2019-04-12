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
 * This form creates a new drive.
 * It determines needed parameters to create a drive and filters other sent data automatically.
 *
 * @author hadi
 *        
 */
class SDP_Form_DriveNew extends Pluf_Form
{

    /**
     * Type of the drive
     *
     * @var SDP_Driver
     */
    var $driver;

    /*
     *
     */
    public function initFields($extra = array())
    {
        $this->driver = $extra['driver'];

        $params = $this->driver->getParameters();
        foreach ($params['children'] as $param) {
            $options = array(
                // 'required' => $param['required']
                'required' => false
            );
            $field = null;
            switch ($param['type']) {
                case 'Integer':
                    $field = new Pluf_Form_Field_Integer($options);
                    break;
                case 'String':
                    $field = new Pluf_Form_Field_Varchar($options);
                    break;
            }
            $this->fields[$param['name']] = $field;
        }
    }

    /**
     * Creates a new instance of drive
     *
     * @param string $commit
     * @throws Pluf_Exception
     * @return SDP_Drive
     */
    function save($commit = true)
    {
        if (! $this->isValid()) {
            // TODO: maso, 1395: باید از خطای مدل فرم استفاده شود.
            throw new Pluf_Exception(__('Cannot save the drive from an invalid form.'));
        }
        // Set attributes
        $drive = new SDP_Drive();
        $drive->setFromFormData($this->cleaned_data);
        $drive->driver = $this->driver->getType();
        $params = $this->driver->getParameters();
        // Note: extra parameters will be stored as meta
        foreach ($params['children'] as $param) {
            if ($param['name'] === 'title' || $param['name'] === 'description' || 
                $param['name'] === 'home')
                continue;
            $drive->setMeta($param['name'], $this->cleaned_data[$param['name']]);
        }
        if ($commit) {
            if (! $drive->create()) {
                throw new Pluf_Exception(__('Fail to create the drive.'));
            }
        }
        return $drive;
    }
}

