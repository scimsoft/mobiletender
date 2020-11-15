<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 29/10/2020
 * Time: 12:11
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'eatin' => env('EATIN',true),
    'takeaway' => env('TAKE_AWAY', false),
    'delivery' => env('DELIVERY',false),

    'eatin_prepay'=> env('EATIN_PREPAY',false),
    'takeaway_prepay'=> env('TAKEAWAY_PREPAY',true),
    'delivery_prepay'=> env('DELIVERY_PREPAY',true),

    'clean_table_after_order' => env('CLEAN_TABLE_AFTER_ORDER',false)

    ];
