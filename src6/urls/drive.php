<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/drives/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Drive'
        )
    ),
    // ************************************************************* Drives
    array(
        'regex' => '#^/drives$#',
        'model' => 'Pluf_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Drive',
            'sql' => 'deleted=false'
        )
    ),
    array(
        'regex' => '#^/drives$#',
        'model' => 'SDP_Views_Drive',
        'method' => 'create',
        'http-method' => array(
            'POST'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array(
        'regex' => '#^/drives/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Drive'
        )
    ),
    array(
        'regex' => '#^/drives/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Drive',
        'method' => 'update',
        'http-method' => array(
            'POST'
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array(
        'regex' => '#^/drives/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'params' => array(
            'model' => 'SDP_Drive',
            'permanently' => false
        ),
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
);