<?php

// config for Emsifa/RandomImage
return [
    /*
    |---------------------------------------------------------------------------------
    | Timeout option
    |---------------------------------------------------------------------------------
    | How long request should wait until throw an exception
    | Unit: seconds
    */
    'timeout' => 10,

    /*
    |---------------------------------------------------------------------------------
    | Retry options
    |---------------------------------------------------------------------------------
    | - limit: limit retry count
    | - sleep: how long process should sleep before retrying the request (miliseconds)
    */
    'retry' => [
        'limit' => 3,
        'sleep' => 500,
    ],

    /*
    |------------------------------------------------------------------------------
    | Headers option
    |------------------------------------------------------------------------------
    | Request headers that will be used to download the image
    */
    'headers' => [
        // 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:108.0) Gecko/20100101 Firefox/108.0'
    ],
];
