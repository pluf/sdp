<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/categories/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Category'
        )
    ),
    // ************************************************************* Category
    array( // Create
        'regex' => '#^/categories$#',
        'model' => 'Pluf_Views',
        'method' => 'createObject',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_Category'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/categories/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Category'
        )
    ),
    array( // Read (list)
        'regex' => '#^/categories$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Category'
        )
    ),
    array( // Delete
        'regex' => '#^/categories/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'params' => array(
            'model' => 'SDP_Category',
            'permanently' => true
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Update
        'regex' => '#^/categories/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_Category'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // ************************************************************* Assets in Category
    array( // Create
        'regex' => '#^/categories/(?P<categoryId>\d+)/assets$#',
        'model' => 'SDP_Views_Category',
        'method' => 'addAsset',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Create
        'regex' => '#^/categories/(?P<categoryId>\d+)/assets/(?P<assetId>\d+)$#',
        'model' => 'SDP_Views_Category',
        'method' => 'addAsset',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/categories/(?P<categoryId>\d+)/assets$#',
        'model' => 'SDP_Views_Category',
        'method' => 'assets',
        'http-method' => 'GET'
    ),
    array( // Delete
        'regex' => '#^/categories/(?P<categoryId>\d+)/assets/(?P<assetId>\d+)$#',
        'model' => 'SDP_Views_Category',
        'method' => 'removeAsset',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    )
);