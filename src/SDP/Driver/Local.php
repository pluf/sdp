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
 *
 * @author hadi
 *        
 */
class SDP_Driver_Local extends SDP_Driver
{

    var $client = false;

    /*
     *
     */
    public function getTitle()
    {
        return 'Local';
    }

    /*
     *
     */
    public function getDescription()
    {
        return 'Driver for local drive';
    }

    /*
     *
     */
    public function getExtraParam()
    {
        return array();
    }

    /**
     *
     * {@inheritdoc}
     * @see SDP_Driver::getDownloadResponse()
     */
    public function getDownloadResponse($link, $request)
    {
        $asset = $link->get_asset();
        $filepath = $asset->path . '/' . $asset->id;
        $httpRange = isset($request->SERVER['HTTP_RANGE']) ? $request->SERVER['HTTP_RANGE'] : null;
        $response = new Pluf_HTTP_Response_ResumableFile($filepath, $httpRange, $asset->name . '.' . SDP_Shortcuts_Mime2Ext($asset->mime_type), $asset->mime_type);
        return $response;
    }
}


