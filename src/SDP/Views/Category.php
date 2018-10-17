<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');

class SDP_Views_Category
{

    public static function assets($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        $asset = new SDP_Asset();
        $assetTable = $asset->_a['table'];
        $assocTable = 'sdp_asset_sdp_category_assoc';
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
            ->build()
            ->render_object();
    }

    public static function addAsset($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $category->setAssoc($asset);
        return new Pluf_HTTP_Response_Json($asset);
    }

    public static function removeAsset($request, $match)
    {
        $category = Pluf_Shortcuts_GetObjectOr404('SDP_Category', $match['categoryId']);
        if (isset($match['assetId'])) {
            $assetId = $match['assetId'];
        } else {
            $assetId = $request->REQUEST['assetId'];
        }
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $assetId);
        $category->delAssoc($asset);
        return new Pluf_HTTP_Response_Json($asset);
    }
}