<?php
return array(
    'SDP_Link' => array(
        'relate_to' => array(
            'SDP_Asset',
            'Pluf_User',
            'Bank_Receipt'
        )
    ),
    'SDP_Asset' => array(
    // XXX: note: hadi, 1396-03: commented to avoid casecade deleting *****
//         'relate_to' => array(
//             'SDP_Asset',
//             'CMS_Content'
//         )
    // ******
//         ,
//         'relate_to_many' => array(
//             'SDP_Tag',
//             'SDP_Category'
//         )
    ),
    'SDP_Category' => array(
    // XXX: note: hadi, 1396-03: commented to avoid casecade deleting *****
//         'relate_to' => array(
//             'CMS_Content',
//             'SDP_Category'
//         ),
    // *****
        'relate_to_many' => array(
            'SDP_Asset'
        )
    ),
    'SDP_Tag' => array(
        'relate_to_many' => array(
            'SDP_Asset'
        )
    ),
    'SDP_Profile' => array(
        'relate_to' => array(
            'Pluf_User'
        )
    )
    
);
