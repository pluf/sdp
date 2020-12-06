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

class SDP_Views_Category extends Pluf_Views
{

    public function updateBySlug($request, $match)
    {
        $p = array(
            'model' => 'SDP_Category'
        );
        $cat = self::getBySlug($request, $match);
        $match['modelId'] = $cat->id;
        return $this->updateObject($request, $match, $p);
    }

    public function deleteBySlug($request, $match)
    {
        $p = array(
            'model' => 'SDP_Category'
        );
        $cat = self::getBySlug($request, $match);
        $match['modelId'] = $cat->id;
        return $this->deleteObject($request, $match, $p);
    }

    /**
     * Extract slug of category from $match and returns related SDP_Category
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @throws Pluf_Exception_DoesNotExist if the category with given slug does not exist
     * @return SDP_Category
     */
    public static function getBySlug($request, $match)
    {
        if (! isset($match['slug'])) {
            throw new Pluf_Exception_BadRequest('The slug is not set');
        }
        $cat = SDP_Category::getCategory($match['slug']);
        if ($cat === null) {
            throw new Pluf_HTTP_Error404("Object not found (SDP_Category," . $match['slug'] . ")");
        }
        return $cat;
    }

    /**
     * Creates a category and add it as the child of the given parent category.
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public static function addChild($request, $match)
    {
        // Find parent category
        $category = array_key_exists('categoryId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']) : //
            self::getBySlug($request, $match);
        
        $request->REQUEST['parent_id'] = $category->id;
        $params = array(
            'model' => 'SDP_Category'
        );
        return self::createObject($request, $match, $params);
    }
    
    /**
     * Returns categories which are the child of the given parent category
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     */
    public static function children($request, $match)
    {
        // Find parent category
        $category = array_key_exists('categoryId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']) : //
            self::getBySlug($request, $match); 
        $params = array(
            'model' => 'SDP_Category',
            'sql' => 'parent_id=' . $category->id
        );
        return self::findObject($request, $match, $params);
    }

    public static function assets($request, $match)
    {
        $category = array_key_exists('categoryId', $match) ? //
            Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']) : //
            self::getBySlug($request, $match);
        $asset = new SDP_Asset();

        $engine = $asset->getEngine();
        $schema = $engine->getSchema();

        $assetTable = $schema->getTableName($asset);
        $assocTable = $schema->getRelationTable($asset, $category);

        $asset->setView('myView', array(
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $assetTable . '.id=' . $assocTable . '.sdp_asset_id'
        ));

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
        $category = array_key_exists('categoryId', $match) ? //
        Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']) : //
        self::getBySlug($request, $match);
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
        $category = array_key_exists('categoryId', $match) ? //
        Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']) : //
        self::getBySlug($request, $match);
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