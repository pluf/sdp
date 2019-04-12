<?php
return array(
    /*
     * ********************************************
     * Engines
     * ********************************************
     */
    array(
        'regex' => '#^/drivers$#',
        'model' => 'SDP_Views_Driver',
        'method' => 'find',
        'http-method' => 'GET'
    ),
    array(
        'regex' => '#^/drivers/(?P<type>[^/]+)$#',
        'model' => 'SDP_Views_Driver',
        'method' => 'get',
        'http-method' => 'GET'
    )
);