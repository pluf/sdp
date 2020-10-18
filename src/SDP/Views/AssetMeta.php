<?php

class SDP_Views_AssetMeta extends Pluf_Views
{

    /**
     * Returns the meta of given asset determined by $assetId and given key by $key.
     * Returns null if such meta does not exist.
     *
     * @param string $key
     * @param integer $assetId
     *            id of the sdp-asset
     * @return SDP_AssetMeta|NULL
     */
    public static function getMetaByKey($key, $itemId)
    {
        $sql = new Pluf_SQL('`key`=%s AND `asset_id`=%s', array(
            $key,
            $itemId
        ));
        $str = $sql->gen();
        $meta = Pluf::factory('SDP_AssetMeta')->getOne($str);
        return $meta;
    }

    /**
     * Extract Key of the meta from $match and returns related AssetMeta
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @throws Pluf_Exception_DoesNotExist if Id is given and meta with given id does not exist or is not blong to given asset
     * @return NULL|SDP_AssetMeta
     */
    public static function getByKey($request, $match)
    {
        Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['parentId']);
        if (! isset($match['modelKey'])) {
            throw new Pluf_Exception_BadRequest('The modelKey is not set');
        }
        $meta = self::getMetaByKey($match['modelKey'], $asset->id);
        if ($meta === null) {
            throw new Pluf_HTTP_Error404('Object not found (SDP_AssetMeta,' . $match['modelKey'] . ')');
        }
        return $meta;
    }

    public function updateByKey($request, $match)
    {
        $meta = self::getByKey($request, $match);
        $match['modelId'] = $meta->id;
        $match['parentId'] = $meta->asset_id;
        $p = array(
            'parent' => 'SDP_Account',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        );
        $meta = $this->updateManyToOne($request, $match, $p);
        return $meta;
    }

    public function createOrUpdate($request, $match, $param)
    {
        Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['parentId']);
        $meta = SDP_AssetMeta::getMeta($request->REQUEST['key'], $asset->id);

        $myParams = array_merge(array(
            'parent' => 'SDP_Account',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        ), $param);

        if (! $meta) {
            return $this->createManyToOne($request, $match, $myParams);
        }
        $match['modelId'] = $meta->id;
        return $this->updateManyToOne($request, $match, $myParams);
    }

}

