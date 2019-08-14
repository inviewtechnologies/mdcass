<?php

return array(

    'IOSUser'     => array(
        'environment' =>env('IOS_USER_ENV', 'development'),
        'certificate' => app_path().'/apns/user/AppUMUserDev.pem',
        'passPhrase'  => env('IOS_PUSH_PASS', 'Appoets123$'),
        'service'     =>'apns'
    ),
    'IOSProvider' => array(
        'environment' => env('IOS_PROVIDER_ENV', 'development'),
        'certificate' => app_path().'/apns/provider/AppUMDeliveryDev.pem',
        'passPhrase'  => env('IOS_PROVIDER_PUSH_PASS', 'Appoets123$'),
        'service'     => 'apns'
    ),
    'IOSShop' => array(
        'environment' => env('IOS_SHOP_ENV', 'development'),
        'certificate' => app_path().'/apns/shop/AppUmRestaurantDev.pem',
        'passPhrase'  => env('IOS_SHOP_PUSH_PASS', 'Appoets123$'),
        'service'     => 'apns'
    ),
    'AndroidUser' => array(
        'environment' =>env('ANDROID_ENV', 'development'),
        'apiKey'      =>'AIzaSyDDmyOZoYqRcAqFeQBP_NOaabPX3HIeXx0',
        'service'     =>'gcm'
    )

);
