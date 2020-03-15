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
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

/**
 * AssetRelation views
 *
 * @author hadi<mohammad.hadi.mansouri@dpq.co.ir>
 */
class SDP_Views_AssetRelation
{

    /**
     * Creates new instance of a asset relation.
     * If bidirectional param in request is true it create two asset relation.
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @param array $p
     * @return Pluf_HTTP_Response
     */
    public function create($request, $match, $p)
    {
        // check start
        $startAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $request->REQUEST['start_id']);
        // check end
        $endAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $request->REQUEST['end_id']);
        // create relation
        $plufService = new Pluf_Views();
        $exception = null;
        try {
            $resultObj = $plufService->createObject($request, $match, $p);
        } catch (Exception $e) {
            if ($e->getStatus() === 400 && strpos($e->getMessage(), 'Duplicate entry') === 0) {
                $exception = $e;
            } else {
                throw $e;
            }
        }
        // create reverse relation if relation should be bidirectional
        if (array_key_exists('bidirectional', $request->REQUEST) && $request->REQUEST['bidirectional'] == 'true') {
            // swap start and end
            $start = $request->REQUEST['start_id'];
            $request->REQUEST['start_id'] = $request->REQUEST['end_id'];
            $request->REQUEST['end_id'] = $start;
            // create reverse relation
            try {
                $plufService->createObject($request, $match, $p);
            } catch (Exception $e) {
                // do nothing
            }
        }
        if($exception == null)
            return $resultObj;
        throw $exception;
    }
}