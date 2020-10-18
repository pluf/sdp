<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/asset-reviews/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetReview'
        )
    ),
    // ************************************************************* Asset Review
    array( // Create
        'regex' => '#^/assets/(?P<parentId>\d+)/reviews$#',
        'model' => 'Pluf_Views',
        'method' => 'createManyToOne',
        'http-method' => 'POST',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        ),
        'precond' => array(
            'SDP_Precondition::loginRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/assets/(?P<parentId>\d+)/reviews$#',
        'model' => 'Pluf_Views',
        'method' => 'findManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<parentId>\d+)/reviews/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        )
    ),
    array( // Update
        'regex' => '#^/assets/(?P<parentId>\d+)/reviews/(?P<modelId>\d+)$#',
        'model' => 'SDP_Views_AssetReview',
        'method' => 'update',
        'http-method' => array(
            'POST',
            'PUT'
        ),
        'precond' => array(
            'SDP_Precondition::loginRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<parentId>\d+)/reviews/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteManyToOne',
        'http-method' => 'DELETE',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetReview'
        ),
        'precond' => array(
            'SDP_Precondition::ownerRequired'
        )
    ),
);