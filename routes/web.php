<?php

Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);
Route::get('login', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
Route::get('privacy', ['as' => 'privacy', 'uses' => 'PrivacyController@index']);
Route::get('terms', ['as' => 'terms', 'uses' => 'TermController@index']);
Route::get('company', ['as' => 'about_us', 'uses' => 'AboutUsController@index']);
Route::get('get-rail-lines', ['as' => 'get_rail_lines', 'uses' => 'HomeController@getRailLines']);
Route::get('get-stations', ['as' => 'get_stations', 'uses' => 'HomeController@getStations']);
Route::get('get-genres', ['as' => 'get_genres', 'uses' => 'HomeController@getGenres']);
Route::get('get-sub-regions', ['as' => 'get_sub_regions', 'uses' => 'HomeController@getSubRegions']);
Route::get('count-reference', ['as' => 'count_reference', 'uses' => 'HomeController@countReference']);
Route::any('leave-account', ['as' => 'leave_account', 'uses' => 'HomeController@postLeaveAccount']);
Route::get('redirect', ['as' => 'redirect', 'uses' => 'HomeController@redirect']);
Route::get('get-rail-lines-by-id', ['as' => 'get_rail_lines_by_id', 'uses' => 'SearchController@getRailLinesById']);
Route::post('get-sub-regions-by-id', ['as' => 'get_sub_regions_by_id', 'uses' => 'SearchController@getSubRegionsById']);
Route::get('error', ['as' => 'error', 'uses' => 'HomeController@error']);
// Prefix: /product/*
Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::any('/{id}', ['as' => 'detail', 'uses' => 'ProductController@detail'])->where('id', '[0-9]+');
    Route::get('/{id}/amp', ['as' => 'amp', 'uses' => 'ProductController@amp']);
    Route::any('/{id}/comments', ['as' => 'comments', 'uses' => 'ProductController@commentsProduct']);
    Route::any('/{id}/comments/{commentId}', ['as' => 'comment_detail', 'uses' => 'ProductController@commentDetail']);
    Route::post('/like-comment', ['as' => 'like_comment', 'uses' => 'ProductController@likeComment']);
    Route::post('/diff-receipt-days', ['as' => 'diff-receipt-days', 'uses' => 'ProductController@getDiffLatestReceiptDate']);
    Route::get('/other-item-of-shop', ['as' => 'other_item_of_shop', 'uses' => 'ProductController@getOtherItemOfShop']);
    Route::get('/get-product-item/{id}', ['as' => 'get_product_item', 'uses' => 'ProductController@getProductItem']);
    Route::get('/check-receiptdate', ['as' => 'check_receiptdate', 'uses' => 'ProductController@checkReceiptDate']);
});
// Prefix: /shopsearch/*
Route::group(['prefix' => 'shopsearch','middleware' => 'old.search', 'as' => 'shopsearch.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'SearchController@searchShopIndex']);
    Route::get('/all', ['as' => 'all', 'uses' => 'SearchController@searchShopAll']);
    Route::get('/station/{station}', ['as' => 'station', 'uses' => 'SearchController@searchShopByStation']);
    Route::get('/{region?}/{sub_region?}', ['as' => 'region', 'uses' => 'SearchController@searchShopByRegion']);
});
// Prefix: /shop/*
Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::any('/{id}', ['as' => 'index', 'uses' => 'ShopController@index'])->where('id', '[0-9]+');
    Route::get('/{id}/coupon', ['as' => 'coupon', 'uses' => 'ShopController@coupon']);
    Route::get('/{id}/amp', ['as' => 'amp', 'uses' => 'ShopController@amp']);
    Route::get('/{id}/menu', ['as' => 'menu', 'uses' => 'ShopController@menu']);
    Route::get('/{id}/map', ['as' => 'map', 'uses' => 'ShopController@map']);
    Route::get('/{id}/widget', ['as' => 'widget', 'middleware' => 'widget.cors', 'uses' => 'ShopController@widget']);
    Route::any('/{id}/comments', ['as' => 'comments', 'uses' => 'ShopController@comments']);
    Route::any('/{id}/comments/{commentId}', ['as' => 'comment_detail', 'uses' => 'ShopController@commentDetail']);
    Route::post('/like-comment', ['as' => 'like_comment', 'uses' => 'ShopController@likeComment']);
    Route::post('/get-latest-review-of-shop', ['as' => 'get_latest_review_of_shop', 'uses' => 'ShopController@getLatestReviewOfShop']);
    Route::any('/{shop}/requests', ['as' => 'requests', 'uses' => 'InformationRequestController@requests'])->where('shop', '[0-9]+');
});
//prefix: /floprestige
Route::group(['prefix' => 'floprestige', 'as' => 'floprestige.'], function () {
  Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::get('/other-item-of-shop', ['as' => 'other_item_of_shop', 'uses' => 'FloprestigeProductController@getOtherItemOfShop']);
    Route::group(['prefix' => '{shop_id}'], function () {
      Route::get('/map', ['as' => 'map', 'uses' => 'FloprestigeShopController@map']);
      Route::group(['prefix' => 'menu'], function () {
        Route::get('/', ['as' => 'menu', 'uses' => 'FloprestigeShopController@menu']);
        Route::group(['prefix' => 'product'], function () {
          Route::get('/{product_id}', ['as' => 'detail', 'uses' => 'FloprestigeProductController@detail']);
        });
      });
    });
  });
});
// Prefix: /search/*
Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'SearchController@index']);
    Route::get('/regions', ['as' => 'regions', 'uses' => 'SearchController@regions']);
    Route::get('/prefectures', ['as' => 'prefectures', 'uses' => 'SearchController@prefectures']);
    Route::get('/prefectures/{prefecture_id}', ['as' => 'rail_lines', 'uses' => 'SearchController@railLines']);
    Route::get('/prefectures/{prefecture_id}/rail-lines/{rail_line_id}', ['as' => 'stations', 'uses' => 'SearchController@stations']);
    Route::get('/current-location', ['as' => 'current_location', 'uses' => 'SearchController@currentLocation']);
    Route::get('/get-location', ['as' => 'get_location', 'uses' => 'SearchController@getLocation']);
});

// Prefix: /coupon/*
Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'CouponController@index']);
    Route::post('/thanks', ['as' => 'thanks', 'uses' => 'CouponController@save']);
});

// Product Search
Route::group(['middleware' => ['epark.search', 'old.search']], function () {
    Route::get('/all', ['as' => 'product.index.all', 'uses' => 'SearchController@searchAll']);
    Route::get('/station/{station}', ['as' => 'product.index.station', 'uses' => 'SearchController@searchByStation']);
    Route::get('/{region?}/{sub_region?}', ['as' => 'product.index', 'uses' => 'SearchController@searchByRegion']);
});
