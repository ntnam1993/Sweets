<?php

return [
    // define services that support redirect after login
    'external_services' => [
        'sweetsguide.jp',
        'test-sweetsguide.jp',
        'xaas.jp',
    ],
    'product_search_limit' => 20,
    'URL_DEV' => 'https://api-coupon-ref-stage.sgscloud.info',
    'URL_STAGING' => 'https://api-coupon-ref-stage.sgscloud.info',
    'URL_PRODUCT' => 'https://api-coupon-ref.epark.jp',
    'URL_SWEETS_EC_STAGING' => 'https://ec.test2-sweetsguide.jp/',
    'URL_SWEETS_EC_PRODUCT' => 'https://ec.sweetsguide.jp/',
    'link_domain' => env('DOMAIN_COOKIE','sweetsguide.jp'),
    'iframeLink' => 'https://parts.epark.jp/epark-common/sns_apri/index.html',
    'API_TIMEOUT' => 10,
    'API_TIME_WARNING' => 6,
    'RSS_TIMEOUT' => 5,
    'SHOP_FLO_OWNER' => env('SHOP_FLO_OWNER','x1332776'),
    'SITE_CODE_FLO' => env('SITE_CODE_FLO', ''),
    'TIME_WARNING_PRODUCTION' => 6,
    'TIME_CRITICAL_PRODUCTION' => 10,
    'TIME_WARNING_STAGING' => 15,
    'TIME_CRITICAL_STAGING' => 30,
];
