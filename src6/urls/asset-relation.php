<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/asset-relations/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    ),
    // ************************************************************* AssetRelation
    array( // Create
        'regex' => '#^/asset-relations$#',
        'model' => 'SDP_Views_AssetRelation',
        'method' => 'create',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/asset-relations/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    ),
    array( // Read (list)
        'regex' => '#^/asset-relations$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    ),
    array( // Update
        'regex' => '#^/asset-relations/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/asset-relations/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'params' => array(
            'model' => 'SDP_AssetRelation',
            'permanently' => true
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    )
);