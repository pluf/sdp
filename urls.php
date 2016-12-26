<?php
return array(
    // ************************************************************* Assets
    array( // Assets urls
        'regex' => '#^/asset/new$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'Pluf_Precondition::loginRequired',
            'SaaS_Precondition::tenantMember'
        )
    ),
    array(
        'regex' => '#^/asset/find$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'find',
        'http-method' => 'GET'
    ),
    array( // Asset urls
        'regex' => '#^/asset/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'get',
        'http-method' => 'GET'
    ),
    array(
        'regex' => '#^/asset/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'delete',
        'http-method' => 'DELETE'
    ),
    array( // Asset urls
        'regex' => '#^/asset/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'update',
        'http-method' => 'POST'
    ),
    array( // Asset urls
        'regex' => '#^/asset/(?P<id>\d+)/find$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'findchild',
        'http-method' => 'GET'
    ),
    // ************************************************************* Link
    array( // Link urls
        'regex' => '#^/asset/(?P<asset_id>\d+)/link$#',
        'model' => 'SDP_Views_Link',
        'method' => 'create',
        'http-method' => 'GET'
    ),
    array( // Link urls
        'regex' => '#^/link/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Link',
        'method' => 'get',
        'http-method' => 'GET',
        'precond' => array(
            'Pluf_Precondition::loginRequired',
            'SaaS_Precondition::tenantMember'
        )
    ),
    array( // Link urls
        'regex' => '#^/link/find$#',
        'model' => 'SDP_Views_Link',
        'method' => 'findlink',
        'http-method' => 'GET',
        'precond' => array(
            'Pluf_Precondition::loginRequired',
            'SaaS_Precondition::tenantMember'
        )
    ),
    // ************************************************************* download asset
    array( // Download urls
        'regex' => '#^/download/(?P<secure_link>.+)$#',
        'model' => 'SDP_Views_Link',
        'method' => 'download',
        'http-method' => 'GET'
    ),
	// ************************************************************* Payments
		array ( // pay to get secure link for an asset which has price
				'regex' => '#^/link/(?P<linkId>\d+)/pay$#',
				'model' => 'SDP_Views_Link',
				'method' => 'payment',
				'http-method' => 'POST',
				'precond' => array (
						'Pluf_Precondition::loginRequired',
						'SaaS_Precondition::tenantMember'
				)
		),
		array ( // Activate secure link that has been activated
				'regex' => '#^/link/(?P<linkId>\d+)/activate$#',
				'model' => 'SaaSDM_Views_Link',
				'method' => 'activate',
				'http-method' => 'GET',
				'precond' => array (
						'Pluf_Precondition::loginRequired',
						'SaaS_Precondition::tenantMember'
				)
		),
    // ************************************************************* AssetRelation
    array(
        'regex' => '#^/assetrelation/find$#',
        'model' => 'SaaS_Views',
        'method' => 'findObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetRelation',
            'listFilters' => array(
                'id',
                'type',
                'start',
                'end'
            ),
            'listDisplay' => array(
                'type' => 'type',
                'description' => 'description'
            ),
            '$searchFields' => array(
                'type',
                'start',
                'end',
                'description'
            ),
            'sortFields' => array(
                'id',
                'type',
                'start',
                'end',
                'creation_date',
                'modif_dtime'
            )
        )
    ),
    array(
        'regex' => '#^/assetrelation/new$#',
        'model' => 'SaaS_Views',
        'method' => 'createObject',
        'http-method' => 'POST',
        'precond' => array(
            'SaaS_Precondition::tenantOwner'
        ),
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    ),
    array(
        'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
        'model' => 'SaaS_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    ),
    array(
        'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
        'model' => 'SaaS_Views',
        'method' => 'deleteObject',
        'http-method' => 'DELETE',
        'precond' => array(
            'SaaS_Precondition::tenantOwner'
        ),
        'params' => array(
            'model' => 'SDP_AssetRelation',
            'permanently' => true
        )
    ),
    array(
        'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
        'model' => 'SaaS_Views',
        'method' => 'updateObject',
        'http-method' => 'POST',
        'precond' => array(
            'SaaS_Precondition::tenantOwner'
        ),
        'params' => array(
            'model' => 'SDP_AssetRelation'
        )
    )
);
