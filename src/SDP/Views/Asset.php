<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('SDP_Shortcuts_NormalizeItemPerPage');
Pluf::loadFunction('Pluf_Shortcuts_GetAssociationTableName');

class SDP_Views_Asset
{

    public static function create($request, $match)
    {
        $extra = array(
            'request' => $request
        );
        // Create asset and get its ID
        $form = new SDP_Form_AssetCreate($request->REQUEST, $extra);
        $asset = $form->save();

        // Upload asset file and extract information about it (by updating
        // asset)
        $extra['asset'] = $asset;
        $form = new SDP_Form_AssetUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        try {
            $asset = $form->update();
        } catch (Pluf_Exception $e) {
            $asset->delete();
            throw $e;
        }

        return new Pluf_HTTP_Response_Json($asset);
    }

    /**
     *
     * @param Pluf_HTTP_Request $request
     * @param unknown $match
     * @return Pluf_HTTP_Response_Json
     */
    public static function find($request, $match)
    {
        $asset = new SDP_Asset();
        $assetTable = $asset->_con->pfx . $asset->_a['table'];
        $builder = new Pluf_Paginator_Builder($asset);

        $queryView = SDP_Views_Asset::createViewQuery($request);
        if ($queryView != null) {
            $asset->_a['views']['myView'] = array(
                'join' => 'JOIN (' . $queryView . ') AS C ON ' . $assetTable . '.id=C.sdp_asset_id'
            );
            $builder->setView('myView');
        }
        // TODO: maso, 2018: set item per page SDP_Shortcuts_NormalizeItemPerPage($request);
        $builder->setRequest($request);
        return $builder->build()->render_object();
    }

    /**
     * Creates a returns a query to get id of assets with some property about tag and category.
     * Valid parameters in request could be as below:
     * include_tag : assets which have tag with determined id
     * exclude_tag : assets which have not tag with determined id
     * include_category : assets which exist in category with determined id
     * exclude_category : assets which not exist in category with determined id
     *
     * Returns nulll if no one mentioned parameters exist in request
     *
     * @param Pluf_HTTP_Request $request
     * @return NULL|string
     */
    private static function createViewQuery($request)
    {
        $includeTag = isset($request->REQUEST['include_tag']) ? $request->REQUEST['include_tag'] : null;
        $excludeTag = isset($request->REQUEST['exclude_tag']) ? $request->REQUEST['exclude_tag'] : 0;
        $includeCategory = isset($request->REQUEST['include_category']) ? $request->REQUEST['include_category'] : null;
        $excludeCategory = isset($request->REQUEST['exclude_category']) ? $request->REQUEST['exclude_category'] : 0;
        if ($includeTag == null && $excludeTag == 0 && $includeCategory == null && $excludeCategory == 0)
            return null;

        $assetModel = new SDP_Asset();
        $asset_tag_assoc = $assetModel->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Tag');
        $asset_category_assoc = $assetModel->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Category');

        // NOT IN expression
        $notin = $excludeTag == 0 && $excludeCategory == 0 ? '' : '(' . 'SELECT sdp_asset_id FROM ' . $asset_tag_assoc . ' WHERE sdp_tag_id=' . $excludeTag . ' UNION ' . 'SELECT sdp_asset_id FROM ' . $asset_category_assoc . ' WHERE sdp_category_id=' . $excludeCategory . ')';
        // Query
        if ($includeTag !== null && $includeCategory !== null) {
            $query = 'SELECT A.sdp_asset_id FROM ' . $asset_tag_assoc . ' AS A JOIN ' . $asset_category_assoc . ' AS B ON A.sdp_asset_id=B.sdp_asset_id' . ' WHERE A.sdp_tag_id=' . $includeTag . ' AND B.sdp_category_id=' . $includeCategory;
            if (! empty($notin))
                $query .= ' AND A.sdp_asset_id NOT IN ' . $notin;
        } elseif ($includeTag !== null && $includeCategory === null) {
            $query = 'SELECT A.sdp_asset_id FROM ' . $asset_tag_assoc . ' AS A' . ' WHERE A.sdp_tag_id=' . $includeTag;
            if (! empty($notin))
                $query .= ' AND A.sdp_asset_id NOT IN ' . $notin;
        } elseif ($includeTag === null && $includeCategory !== null) {
            $query = 'SELECT A.sdp_asset_id FROM ' . $asset_category_assoc . ' AS A' . ' WHERE A.sdp_category_id=' . $includeCategory;
            if (! empty($notin))
                $query .= ' AND A.sdp_asset_id NOT IN ' . $notin;
        } else {
            $query = 'SELECT A.id AS sdp_asset_id FROM sdp_asset AS A';
            if (! empty($notin))
                $query .= ' WHERE A.id NOT IN ' . $notin;
        }
        return $query;
    }

    public static function get($request, $match)
    {
        // تعیین داده‌ها
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match["id"]);
        // حق دسترسی
        // CMS_Precondition::userCanAccessContent($request, $content);
        // اجرای درخواست
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function update($request, $match)
    {
        // تعیین داده‌ها
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match["id"]);
        // حق دسترسی
        // CMS_Precondition::userCanUpdateContent($request, $content);
        // اجرای درخواست
        $extra = array(
            'request' => $request,
            'asset' => $asset
        );
        $form = new SDP_Form_AssetUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
        $asset = $form->update();
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function delete($request, $match)
    {
        // تعیین داده‌ها
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match["id"]);
        // دسترسی
        // CMS_Precondition::userCanDeleteContent($request, $content);
        // اجرا
        $asset_copy = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $asset->id);
        $asset_copy->path = "";

        $asset->delete();

        return new Pluf_HTTP_Response_Json($asset_copy);
    }

    public static function updateFile($request, $match)
    {
        // GET data
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match["id"]);
        // Check permission
        // Precondition::userCanAccessApplication($request, $app);
        // Precondition::userCanAccessResource($request, $content);

        if (array_key_exists('file', $request->FILES)) {
            $extra = array(
                'asset' => $asset
            );
            $form = new SDP_Form_AssetUpdate(array_merge($request->REQUEST, $request->FILES), $extra);
            $asset = $form->update();
            // return new Pluf_HTTP_Response_Json($content);
        } else {

            // Do
            $myfile = fopen($asset->path . '/' . $asset->id, "w") or die("Unable to open file!");
            $entityBody = file_get_contents('php://input', 'r');
            fwrite($myfile, $entityBody);
            fclose($myfile);
            $asset->file_size = filesize($asset->path . '/' . $asset->id);
            $asset->update();
        }
        return new Pluf_HTTP_Response_Json($asset);
    }

    // *******************************************************************
    // Tags of Asset
    // *******************************************************************
    public static function tags($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        $tag = new SDP_Tag();
        $tagTable = $tag->_con->pfx . $tag->_a['table'];
        $assocTable = $tag->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Tag');
        $tag->_a['views']['myView'] = array(
            'select' => $tag->getSelect(),
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $tagTable . '.id=' . $assocTable . '.sdp_tag_id'
        );

        $paginator = new Pluf_Paginator($tag);
        $sql = new Pluf_SQL('sdp_asset_id=%s', array(
            $asset->id
        ));
        $paginator->forced_where = $sql;
        $paginator->model_view = 'myView';
        $paginator->list_filters = array(
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
            'creation_dtime',
            'modif_dtime'
        );
        $paginator->configure(array(), $search_fields, $sort_fields);
        $paginator->items_per_page = SDP_Shortcuts_NormalizeItemPerPage($request);
        $paginator->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($paginator->render_object());
    }

    public static function addTag($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['tagId'])) {
            $tagId = $match['tagId'];
        } else {
            $tagId = $request->REQUEST['tagId'];
        }
        $tag = Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $tagId);
        $asset->setAssoc($tag);
        return new Pluf_HTTP_Response_Json($tag);
    }

    public static function removeTag($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['tagId'])) {
            $tagId = $match['tagId'];
        } else {
            $tagId = $request->REQUEST['tagId'];
        }
        $tag = Pluf_Shortcuts_GetObjectOr404('SDP_Tag', $tagId);
        $asset->delAssoc($tag);
        return new Pluf_HTTP_Response_Json($tag);
    }

    // *******************************************************************
    // Categories of Asset
    // *******************************************************************
    public static function categories($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        $category = new SDP_Category();
        $categoryTable = $category->_con->pfx . $category->_a['table'];
        $assocTable = $category->_con->pfx . Pluf_Shortcuts_GetAssociationTableName('SDP_Asset', 'SDP_Category');
        $category->_a['views']['myView'] = array(
            'select' => $category->getSelect(),
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $categoryTable . '.id=' . $assocTable . '.sdp_category_id'
        );

        $paginator = new Pluf_Paginator($category);
        $sql = new Pluf_SQL('sdp_asset_id=%s', array(
            $asset->id
        ));
        $paginator->forced_where = $sql;
        $paginator->model_view = 'myView';
        $paginator->list_filters = array(
            'id',
            'name',
            'parent'
        );
        $search_fields = array(
            'name',
            'description'
        );
        $sort_fields = array(
            'id',
            'name',
            'parent',
            'creation_dtime',
            'modif_dtime'
        );
        $paginator->configure(array(), $search_fields, $sort_fields);
        $paginator->items_per_page = SDP_Shortcuts_NormalizeItemPerPage($request);
        $paginator->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($paginator->render_object());
    }

    public static function addCategory($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['categoryId'])) {
            $categoryId = $match['categoryId'];
        } else {
            $categoryId = $request->REQUEST['categoryId'];
        }
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $categoryId);
        $asset->setAssoc($category);
        return new Pluf_HTTP_Response_Json($category);
    }

    public static function removeCategory($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['categoryId'])) {
            $categoryId = $match['categoryId'];
        } else {
            $categoryId = $request->REQUEST['categoryId'];
        }
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $categoryId);
        $asset->delAssoc($category);
        return new Pluf_HTTP_Response_Json($category);
    }

    // *******************************************************************
    // Relations of Asset
    // *******************************************************************
    public static function relations($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        $relatedAsset = new SDP_Asset();
        $relatedAssetTable = $relatedAsset->_a['table'];
        $assocTable = 'sdp_assetrelation';
        $relatedAsset->_a['views']['myView'] = array(
            'select' => $relatedAsset->getSelect(),
            'join' => 'LEFT JOIN ' . $assocTable . ' ON ' . $relatedAssetTable . '.id=' . $assocTable . '.end'
        );

        $page = new Pluf_Paginator($relatedAsset);
        $sql = new Pluf_SQL('start=%s', array(
            $asset->id
        ));
        $page->forced_where = $sql;
        $page->model_view = 'myView';
        $page->list_filters = array(
            'id',
            'name',
            'size',
            'download',
            'driver_type',
            'driver_id',
            'creation_dtime',
            'modif_dtime',
            'type',
            'mime_type',
            'price',
            'parent'
        );
        $search_fields = array(
            'name',
            'driver_type',
            'driver_id',
            'type',
            'description',
            'mime_type'
        );
        $sort_fields = array(
            'id',
            'name',
            'size',
            'download',
            'driver_type',
            'driver_id',
            'creation_dtime',
            'modif_dtime',
            'type',
            'mime_type',
            'price',
            'parent'
        );
        $page->configure(array(), $search_fields, $sort_fields);
        $page->items_per_page = SDP_Shortcuts_NormalizeItemPerPage($request);
        $page->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($page->render_object());
    }

    public static function addRelation($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['endId'])) {
            $endId = $match['endId'];
        } else {
            $endId = $request->REQUEST['endId'];
        }
        $endAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $endId);
        $request->REQUEST['start'] = $asset->getId();
        $request->REQUEST['end'] = $endAsset->getId();
        $form = Pluf_Shortcuts_GetFormForModel(new SDP_AssetRelation(), $request->REQUEST, array());
        return new Pluf_HTTP_Response_Json($form->save());
    }

    public static function removeRelation($request, $match)
    {
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['assetId']);
        if (isset($match['endId'])) {
            $endId = $match['endId'];
        } else {
            $endId = $request->REQUEST['endId'];
        }
        $endAsset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $endId);
        $relation = new SDP_AssetRelation();
        $relationList = $relation->getList(array(
            'filter' => array(
                'start=' . $asset->id,
                'end=' . $endAsset->id
            )
        ));
        $relateListCopy = array();
        foreach ($relationList as $rel) {
            $val = clone $rel;
            array_push($relateListCopy, $val);
            $rel->delete();
        }
        return new Pluf_HTTP_Response_Json($relateListCopy);
    }
}