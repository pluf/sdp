<?php

class SDP_Views_AssetReview extends Pluf_Views
{

    public function update($request, $match)
    {
        $can = SDP_Precondition::canUpdateReview($request->user, $match['modelId']);
        if(!$can){
            throw new Pluf_Exception_PermissionDenied('Your not allowed to modify others` reviews');
        }
        $p = array(
            'parent' => 'SDP_Account',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        );
        $review = $this->updateManyToOne($request, $match, $p);
        return $review;
    }

}

