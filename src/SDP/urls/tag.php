<?php
return array(
    // ************************************************************* Tag
    array( // Create
        'regex' => '#^/tags$#',
        'model' => 'Pluf_Views',
        'method' => 'createObject',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_Tag'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/tags$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Tag'
        )
    ),
    array( // Read
        'regex' => '#^/tags/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Tag'
        )
    ),
    array( // Read (by name)
        'regex' => '#^/tags/(?P<name>[^/]+)$#',
        'model' => 'SDP_Views_Tag',
        'method' => 'getByName',
        'http-method' => 'GET'
    ),
    array( // Update
        'regex' => '#^/tags/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'params' => array(
            'model' => 'SDP_Tag'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/tags/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'params' => array(
            'model' => 'SDP_Tag',
            'permanently' => true
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // ************************************************************* Assets with Tag
    array( // Create
        'regex' => '#^/tags/(?P<tagId>\d+)/assets$#',
        'model' => 'SDP_Views_Tag',
        'method' => 'addAsset',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::loginRequired',
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Create
        'regex' => '#^/tags/(?P<tagId>\d+)/assets/(?P<assetId>\d+)$#',
        'model' => 'SDP_Views_Tag',
        'method' => 'addAsset',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/tags/(?P<tagId>\d+)/assets$#',
        'model' => 'SDP_Views_Tag',
        'method' => 'assets',
        'http-method' => 'GET'
    ),
    array( // Delete
        'regex' => '#^/tags/(?P<tagId>\d+)/assets/(?P<assetId>\d+)$#',
        'model' => 'SDP_Views_Tag',
        'method' => 'removeAsset',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
);