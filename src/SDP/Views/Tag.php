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

class SDP_Views_Tag extends Pluf_Views
{
    public function updateByName($request, $match)
    {
        $p = array(
            'model' => 'SDP_Tag'
        );
        $tag = self::getByName($request, $match);
        $match['modelId'] = $tag->id;
        return $this->updateObject($request, $match, $p);
    }
    
    public function deleteByName($request, $match)
    {
        $p = array(
            'model' => 'SDP_Tag'
        );
        $tag = self::getByName($request, $match);
        $match['modelId'] = $tag->id;
        return $this->deleteObject($request, $match, $p);
    }
    
    public static function getByName($request, $match)
    {
        if (! isset($match['name'])) {
            throw new Pluf_Exception_BadRequest('The name is not set');
        }
        $tag = SDP_Tag::getTag($match['name']);
        if ($tag === null) {
            throw new Pluf_HTTP_Error404("Object not found (SDP_Tag," . $match['name'] . ")");
        }
        return $tag;
    }

    public static function assets($request, $match)
    {
        $tag = array_key_exists('tagId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']) : //
            self::getByName($request, $match);
        $asset = new SDP_Asset();

        $engine = $asset->getEngine();
        $schema = $engine->getSchema();

        $assetTable = $schema->getTableName($asset);
        // $asset->_con->pfx . $asset->_a['table'];
        $assocTable = $schema->getRelationTable($asset, $tag);
        // $asset->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Tag');

        $asset->setView('myView', array(
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $assetTable . '.id=' . $assocTable . '.sdp_asset_id'
        ));

        $builder = new Pluf_Paginator_Builder($asset);
        return $builder->setWhereClause(new Pluf_SQL('sdp_tag_id=%s', array(
            $tag->id
        )))
            ->setView('myView')
            ->setRequest($request)
            ->build();
    }

    public static function addAsset($request, $match)
    {
        $tag = array_key_exists('tagId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']) : //
            self::getByName($request, $match);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = isset($request->REQUEST['id']) ? $request->REQUEST['id'] : $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $tag->setAssoc($asset);
        return $asset;
    }

    public static function removeAsset($request, $match)
    {
        $tag = array_key_exists('tagId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']) : //
            self::getByName($request, $match);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = isset($request->REQUEST['id']) ? $request->REQUEST['id'] : $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $tag->delAssoc($asset);
        return $asset;
    }
}