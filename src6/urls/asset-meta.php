<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/asset-metas/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetMeta'
        )
    ),
    // ************************************************************* Asset Meta
    array( // Create (error if item is existed)
        'regex' => '#^/assets/(?P<parentId>\d+)/metas$#',
        'model' => 'Pluf_Views',
        'method' => 'createManyToOne',
        'http-method' => 'PUT',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        ),
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Create/Update (update if item is existed)
        'regex' => '#^/assets/(?P<parentId>\d+)/metas$#',
        'model' => 'SDP_Views_AssetMeta',
        'method' => 'createOrUpdate',
        'http-method' => 'POST',
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/assets/(?P<parentId>\d+)/metas$#',
        'model' => 'Pluf_Views',
        'method' => 'findManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<parentId>\d+)/metas/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        )
    ),
    array( // Read (by key)
        'regex' => '#^/assets/(?P<parentId>\d+)/metas/(?P<modelKey>[^/]+)$#',
        'model' => 'SDP_Views_AssetMeta',
        'method' => 'getByKey',
        'http-method' => 'GET'
    ),
    array( // Update
        'regex' => '#^/assets/(?P<parentId>\d+)/metas/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateManyToOne',
        'http-method' => array(
            'POST',
            'PUT'
        ),
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        ),
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Update (by key)
        'regex' => '#^/assets/(?P<parentId>\d+)/metas/(?P<modelKey>[^/]+)$#',
        'model' => 'SDP_Views_AssetMeta',
        'method' => 'updateByKey',
        'http-method' => 'POST',
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<parentId>\d+)/metas/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteManyToOne',
        'http-method' => 'DELETE',
        'precond' => array(
            'SDP_Precondition::providerRequired'
        ),
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetMeta'
        ),
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
);