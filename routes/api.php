<?php

Route::get('product-search', ['as' => 'product.search', 'uses' => 'ProductController@getSearch']);
Route::get('product-detail/{id}', ['as' => 'product.detail', 'uses' => 'ProductController@detail']);
Route::group(['prefix' => 'shop'], function(){
	Route::get('/', array('uses' => 'ShopController@detail'));
});
