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

class SDP_Views_Category
{

    public static function assets($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        $asset = new SDP_Asset();
        $assetTable = $asset->_con->pfx . $asset->_a['table'];
        $assocTable = $asset->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Category');
        $asset->_a['views']['myView'] = array(
            'select' => $asset->getSelect(),
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $assetTable . '.id=' . $assocTable . '.sdp_asset_id'
        );

        $builder = new Pluf_Paginator_Builder($asset);
        return $builder->setWhereClause(new Pluf_SQL('sdp_category_id=%s', array(
            $category->id
        )))
            ->setView('myView')
            ->setRequest($request)
            ->build();
    }

    public static function addAsset($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = isset($request->REQUEST['id']) ? $request->REQUEST['id'] : $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $category->setAssoc($asset);
        return $asset;
    }

    public static function removeAsset($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = isset($request->REQUEST['id']) ? $request->REQUEST['id'] : $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $category->delAssoc($asset);
        return $asset;
    }
}