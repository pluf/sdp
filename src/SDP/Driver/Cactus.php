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
use Firebase\JWT\JWT;

/**
 *
 * @author hadi
 *        
 */
class SDP_Driver_Cactus extends SDP_Driver
{

    var $client = false;

    /*
     *
     */
    public function getTitle()
    {
        return 'Cactus';
    }

    /*
     *
     */
    public function getDescription()
    {
        return 'Driver for cactus drive';
    }

    /*
     *
     */
    public function getExtraParam()
    {
        return array(
            array(
                'name' => 'key',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'Key',
                'description' => 'Key to encript/decript JWT',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'key',
                'defaultValue' => 'examplekey',
                'validators' => [
                    'NotNull',
                    'NotEmpty'
                ]
            ),
            array(
                'name' => 'algorithm',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'Algorithm',
                'description' => 'Algorithm to encript/decript JWT',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'algorithm',
                'defaultValue' => 'HS512',
                'validators' => [
                    'NotNull',
                    'NotEmpty'
                ]
            )
        );
    }

    /**
     * Creats a permanent redirect (code 301) response with an URL as the following pattern:
     *
     * <code>{cactus_home}/api/v2/cactus/files/{jwt}/content</code>
     *
     * The parameter 'cactus_home' will be fetched from drive of the asset which is related to the given link.
     * The parameter 'jwt' is a JSON Web Token which is contain at least the following information:
     * - file: path to file
     * - expiry: unix timestamp
     * - access: r, w, rw
     * The following information may be existed in the token:
     * - account: a JSON object. Here we place 'id' of requester account.
     * - host: a JSON object. Here we place 'host' of requester which is the domain of it.
     *
     * Note: The key and algorithm to encode/decode the JWT should be determined in the meta information
     * of the drive which is host of the asset.
     *
     * {@inheritdoc}
     * @see SDP_Driver::getDownloadResponse()
     */
    public function getDownloadResponse($link, $request)
    {
        $asset = $link->get_asset();
        $requester = isset($request->user) && $request->user->id ? $request->user : $link->get_user();
        $token = array(
            'file' => $asset->path . '/' . $asset->file_name,
            'expiry' => $link->expiry,
            'access' => 'r',
            'account' => array(
                'id' => $requester->id
            ),
            'host' => array(
                'domain' => $request->http_host
            )
        );
        $drive = $asset->get_drive();
        $key = $drive->getMeta('key');
        $alg = $drive->getMeta('algorithm');

        $jwt = JWT::encode($token, $key, $alg);
        $url = $drive->home . '/api/v2/cactus/files/' . $jwt . '/content';

        $response = new Pluf_HTTP_Response_Redirect($url, 301);
        return $response;
    }
}


