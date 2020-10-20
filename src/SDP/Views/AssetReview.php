<?php

class SDP_Views_AssetReview extends Pluf_Views
{

    /**
     * Creates new asset review
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return SDP_AssetReview
     */
    public static function create($request, $match)
    {
        Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
        $asset = Pluf_Shortcuts_GetObjectOr404('SDP_Asset', $match['parentId']);
        $form = Pluf_ModelUtils::getCreateForm(new SDP_AssetReview(), $request->REQUEST);
        $review = $form->save(false);
        $review->writer_id = $request->user;
        $review->asset_id = $asset;
        $review->create();
        return $review;
    }
    
    public function update($request, $match)
    {
        $can = SDP_Precondition::canUpdateReview($request->user, $match['modelId']);
        if(!$can){
            throw new Pluf_Exception_PermissionDenied('Your not allowed to modify others` reviews');
        }
        $p = array(
            'parent' => 'User_Account',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        );
        $review = $this->updateManyToOne($request, $match, $p);
        return $review;
    }

}

