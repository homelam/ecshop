<?php

$time = date("Ymd", time());

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'upload' => [
        'disks' => 'uploads',
        'brand' => 'brands',
        'products' => "products/images/{$time}",
        'thumbs' => "products/thumbs/{$time}"
    ],

    'size' => [
        [50, 50], // sm_img
        [130, 130], // mid_img
        [350, 350] // big_img
    ]

];
