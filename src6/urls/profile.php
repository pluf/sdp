<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/profiles/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Profile'
        )
    ),
    // ************************************************** SDP Profile
    array( // Create / Update
        'regex' => '#^/accounts/(?P<userId>\d+)/profiles$#',
        'model' => 'SDP_Views_Profile',
        'method' => 'update',
        'http-method' => array(
            'PUT',
            'POST'
        ),
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    ),
    array( // Update
        'regex' => '#^/accounts/(?P<userId>\d+)/profiles/(?P<profileId>\d+)$#',
        'model' => 'SDP_Views_Profile',
        'method' => 'update',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    ),
    array( // Read (list)
        'regex' => '#^/accounts/(?P<parentId>\d+)/profiles$#',
        'model' => 'Pluf_Views',
        'method' => 'findManyToOne',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::loginRequired'
        ),
        'params' => array(
            'parent' => 'User_Account',
            'parentKey' => 'account_id',
            'model' => 'SDP_Profile'
        )
    ),
    array( // Read
        'regex' => '#^/accounts/(?P<parentId>\d+)/profiles/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getManyToOne',
        'http-method' => 'GET',
        'precond' => array(
            'User_Precondition::loginRequired'
        ),
        'params' => array(
            'parent' => 'User_Account',
            'parentKey' => 'account_id',
            'model' => 'SDP_Profile'
        )
    ),
    array( // Delete
        'regex' => '#^/accounts/(?P<userId>\d+)/profiles/(?P<profileId>\d+)$#',
        'model' => 'SDP_Views_Profile',
        'method' => 'delete',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    )
);



