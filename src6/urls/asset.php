<?php
return array(
    // ************************************************************* Schema
    array(
        'regex' => '#^/assets/schema$#',
        'model' => 'Pluf_Views',
        'method' => 'getSchema',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Asset'
        )
    ),
    // ************************************************************* Assets
    array( // Create
        'regex' => '#^/assets$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<modelId>\d+)$#',
        'model' => 'Pluf_Views',
        'method' => 'getObject',
        'http-method' => 'GET',
        'params' => array(
            'model' => 'SDP_Asset'
        )
    ),
    array( // Read (list)
        'regex' => '#^/assets$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'find',
        'http-method' => 'GET'
    ),
    array( // Update
        'regex' => '#^/assets/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'update',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<id>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'delete',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // --------------------------------------------------------------------
    // Binary content of asset
    // --------------------------------------------------------------------
    array( // Read
        'regex' => '#^/assets/(?P<modelId>\d+)/content$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'download',
        'http-method' => 'GET',
        'precond' => array(
            // Note: Other users should use indirect links to download contents of an asset
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Update
        'regex' => '#^/assets/(?P<modelId>\d+)/content$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'updateFile',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // ************************************************************* Children of Assets (if asset is folder)
    // TODO: Hadi 1397-09-20: By using categories and define Category in the SDP, I think it could be removed.
    array( // Read children (if asset is folder)
        'regex' => '#^/assets/(?P<id>\d+)/children$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'findchild',
        'http-method' => 'GET'
    ),
    // ************************************************************* Tags on Assets
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/tags$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addTag',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/tags/(?P<tagId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addTag',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<assetId>\d+)/tags$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'tags',
        'http-method' => 'GET'
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<assetId>\d+)/tags/(?P<tagId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'removeTag',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // ************************************************************* Categories of Assets
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/categories$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addCategory',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/categories/(?P<categoryId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addCategory',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<assetId>\d+)/categories$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'categories',
        'http-method' => 'GET'
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<assetId>\d+)/categories/(?P<categoryId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'removeCategory',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    // ************************************************************* Relations of Asset
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/relations$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addRelation',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Create
        'regex' => '#^/assets/(?P<assetId>\d+)/relations/(?P<endId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'addRelation',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),
    array( // Read
        'regex' => '#^/assets/(?P<assetId>\d+)/relations$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'relations',
        'http-method' => 'GET'
    ),
    array( // Delete
        'regex' => '#^/assets/(?P<assetId>\d+)/relations/(?P<endId>\d+)$#',
        'model' => 'SDP_Views_Asset',
        'method' => 'removeRelation',
        'http-method' => 'DELETE',
        'precond' => array(
            'User_Precondition::ownerRequired'
        )
    ),

    // ************************************************************* Link for Asset
    array( // Create
        'regex' => '#^/assets/(?P<asset_id>\d+)/links$#',
        'model' => 'SDP_Views_Link',
        'method' => 'create',
        'http-method' => 'POST',
        'precond' => array(
            'User_Precondition::loginRequired'
        )
    )
    // TODO: Hadi 1397-09-20: Add API to list links created for an asset
    // TODO: Hadi 1397-09-20: Add API to delete links (only links which have not payment)

    // TODO: Hadi 1397-09-20: Add API to list payments for an asset
);