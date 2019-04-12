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
 * Determines the service to create links to upload to/download from a drive
 *
 * @author hadi
 *        
 */
class SDP_Driver implements JsonSerializable
{

    const DRIVER_PREFIX = 'sdp_driver_';

    /**
     *
     * @return string
     */
    public function getType()
    {
        $name = strtolower(get_class($this));
        // NOTE: hadi, 2019: All drivers should be defined in the determined folder 
        if (strpos($name, SDP_Driver::DRIVER_PREFIX) !== 0) {
            throw new SDP_Exception_DriverLoad('Driver class must be placed in driver package.');
        }
        return substr($name, strlen(SDP_Driver::DRIVER_PREFIX));
    }

    /**
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->getType();
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return '';
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * Returns a http response to given request to download given link.
     *
     * The information to create link should be placed in the meta.
     * All other needed information should be given from request.
     *
     * @param SDP_Link $link
     * @param Pluf_Http_Request $request
     * @return Pluf_Http_Response
     */
    public function getDownloadResponse($link, $request)
    {
        // XXX: hadi, 1398: create a link
        return '';
    }

    /**
     * (non-PHPdoc)
     *
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        $coded = array(
            'type' => $this->getType(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'symbol' => $this->getSymbol()
        );
        return $coded;
    }

    /**
     * Returns a list of needed parameters of a driver
     * 
     * Each drive needs some parameter which should be provided by the user.
     * This function determines these parameters.
     * 
     * Result of this function is a list of property descriptors.
     */
    public function getParameters()
    {
        $param = array(
            'id' => $this->getType(),
            'name' => $this->getType(),
            'type' => 'struct',
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'editable' => true,
            'visible' => true,
            'priority' => 5,
            'symbol' => $this->getSymbol(),
            'children' => []
        );
        $general = $this->getGeneralParam();
        foreach ($general as $gp) {
            $param['children'][] = $gp;
        }

        $extra = $this->getExtraParam();
        foreach ($extra as $ep) {
            $param['children'][] = $ep;
        }
        return $param;
    }

    /**
     * فهرست خصوصیت‌های عمومی را تعیین می‌کند.
     *
     * @return
     *
     */
    public function getGeneralParam()
    {
        $params = array();
        $params[] = array(
            'name' => 'title',
            'type' => 'String',
            'unit' => 'none',
            'title' => 'title',
            'description' => 'beackend title',
            'editable' => true,
            'visible' => true,
            'priority' => 5,
            'symbol' => 'title',
            'defaultValue' => 'no title',
            'validators' => [
                'NotNull',
                'NotEmpty'
            ]
        );
        $params[] = array(
            'name' => 'description',
            'type' => 'String',
            'unit' => 'none',
            'title' => 'description',
            'description' => 'beackend description',
            'editable' => true,
            'visible' => true,
            'priority' => 5,
            'symbol' => 'title',
            'defaultValue' => 'description',
            'validators' => []
        );
        $params[] = array(
            'name' => 'symbol',
            'type' => 'String',
            'unit' => 'none',
            'title' => 'Symbol',
            'description' => 'beackend symbol',
            'editable' => true,
            'visible' => true,
            'priority' => 5,
            'symbol' => 'icon',
            'defaultValue' => '',
            'validators' => []
        );
        return $params;
    }

    /**
     * خصوصیت‌های اضافه را تعیین می‌کند.
     */
    public function getExtraParam()
    {
        // TODO: maso, 1395: فرض شده که این فراخوانی توسط پیاده‌سازی‌ها بازنویسی
        // شود
        return array();
    }
}