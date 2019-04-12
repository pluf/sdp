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
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

/**
 *
 * @author hadi
 *        
 */
class SDP_Views_Drive extends Pluf_Views
{

    /**
     * Creates a new instance of drive
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * 
     * @return SDP_Drive
     */
    public function create($request, $match)
    {
        $type = 'not set';
        if (array_key_exists('type', $request->REQUEST)) {
            $type = $request->REQUEST['type'];
        }
        $driver = SDP_Shortcuts_GetDriverOr404($type);
        $params = array(
            'driver' => $driver
        );
        $form = new SDP_Form_DriveNew($request->REQUEST, $params);
        $drive = $form->save();
        return $drive;
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * 
     * @return SDP_Drive
     */
    public function update($request, $match)
    {
        $drive = Pluf_Shortcuts_GetObjectOr404('SDP_Drive', $match['id']);
        $params = array(
            'drive' => $drive
        );
        $form = new SDP_Form_DriveUpdate($request->REQUEST, $params);
        $drive = $form->update();
        return $drive;
    }
    
}
