<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/links/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Link'
        )
    ),
    // ************************************************************* Link
    array( // Read (and check activation status of link)
        'regex' => '#^/links/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Link',
        'method' => 'get',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/links$#',
        'model' => 'SDP_Views_Link',
        'method' => 'find',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    ),
    // ************************************************************* download asset
    array( // Download urls
        'regex' => '#^/links/(?P<secure_link>.+)/content$#',
        'model' => 'SDP_Views_Link',
        'method' => 'download',
        'http-method' => 'GET'
    ),
    // TODO: Hadi, 1398-01-19: API to upload
    // array( // Download urls
    // 'regex' => '#^/links/(?P<secure_link>.+)/content$#',
    // 'model' => 'SDP_Views_Link',
    // 'method' => 'upload',
    // 'http-method' => 'POST'
    // ),

    // ************************************************************* Payments
    array( // pay to get secure link for an asset which has price
        'regex' => '#^/links/(?P<linkId>\d+)/payments$#',
        'model' => 'SDP_Views_Link',
        'method' => 'payment',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    )

    // array( // Activate secure link that has been activated
    // 'regex' => '#^/links/(?P<linkId>\d+)/activate$#',
    // 'model' => 'SDP_Views_Link',
    // 'method' => 'activate',
    // 'http-method' => 'GET',
    // 'precond' => array(
    // 'User_Precondition::loginRequired'
    // )
    // ),
);