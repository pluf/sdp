<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/asset-screenshots/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetScreenshot'
        )
    ),
    // ************************************************************* Asset Screenshot
    array( // Create
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots$#',
        'model' => 'SDP_Views_AssetScreenshot',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots$#',
        'model' => 'Pluf_Views',
        'method' => 'findManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetScreenshot'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getManyToOne',
        'http-method' => 'GET',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetScreenshot'
        )
    ),
    array( // Update
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateManyToOne',
        'http-method' => array(
            'POST',
            'PUT'
        ),
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetScreenshot'
        ),
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteManyToOne',
        'http-method' => 'DELETE',
        'params' => array(
            'parent' => 'SDP_Asset',
            'parentKey' => 'asset_id',
            'model' => 'SDP_AssetScreenshot'
        ),
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
    // ************************************************************* Binary content of screenshot
    array( // Read
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots/(?P<modelId>\d+)/content$#',
        'model' => 'SDP_Views_AssetScreenshot',
        'method' => 'download',
        'http-method' => 'GET',
        // Cache apram
        'cacheable' => true,
        'revalidate' => true,
        'intermediate_cache' => true,
        'max_age' => 25000
    ),
    array( // Update
        'regex' => '#^/assets/(?P<parentId>\d+)/screenshots/(?P<modelId>\d+)/content$#',
        'model' => 'SDP_Views_AssetScreenshot',
        'method' => 'upload',
        'http-method' => 'POST',
        'precond' => array(
            'SDP_Precondition::providerRequired'
        )
    ),
);