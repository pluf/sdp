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
Pluf::loadFunction('SDP_Shortcuts_GetTagByNameOr404');

class SDP_Views_Tag
{

    public static function getByName($request, $match)
    {
        $tag = SDP_Shortcuts_GetTagByNameOr404($match['name']);
        // حق دسترسی
        // CMS_Precondition::userCanAccessContent($request, $content);
        // اجرای درخواست
        return $tag;
    }

    public static function assets($request, $match)
    {
        $tag = Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']);
        $asset = new SDP_Asset();
        $assetTable = $asset->_con->pfx . $asset->_a['table'];
        $assocTable = $asset->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Tag');
        $asset->_a['views']['myView'] = array(
            'select' => $asset->getSelect(),
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $assetTable . '.id=' . $assocTable . '.sdp_asset_id'
        );

        $page = new Pluf_Paginator($asset);
        $sql = new Pluf_SQL('sdp_tag_id=%s', array(
            $tag->id
        ));
        $page->forced_where = $sql;
        $page->model_view = 'myView';
        $page->list_filters = array(
            'id',
            'name'
        );
        $search_fields = array(
            'name',
            'description'
        );
        $sort_fields = array(
            'id',
            'name',
            'creation_date',
            'modif_dtime'
        );
        $page->configure(array(), $search_fields, $sort_fields);
        $page->setFromRequest($request);
        return $page;
    }

    public static function addAsset($request, $match)
    {
        $tag = Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']);
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
        $tag = Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $match['tagId']);
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