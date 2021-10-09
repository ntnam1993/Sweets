@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$page = (request()->has('page') && (int) request()->page > 0) ? '（おすすめ順・' . request()->page . 'ページ目）' : '';
$pageForDescription = (request()->has('page') && (int) request()->page > 0) ? '('.request()->page.'ページ目)' : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? $shop->item->page_title : '';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.mobile.shop')
@section('title', '口コミ｜'.$title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@include('shop.mobile.partials.list-tab')
@include('shop.mobile.partials.shop-summary')
<div class="review-list" style="margin-top:10px; border-bottom: none; padding: 0;">
	<div class="p-n p-n-fix">
		口コミ一覧（{{ $numFound }}）
	</div>
</div>
<div class="list-shop">
	<ul id="listShopReviews">
		@include ("shop.mobile.partials.comments", compact('shopComment'))
	</ul>
    <a href="{!! $postReviewUrl !!}" class="a-link-cmt a-link-cmt-fixed a-link-cmt-fixed-2"><span>口コミ・写真投稿</span></a>
</div>

@include ("partials.components.mobile.pagination", ["list" => $shopComments, "paging" => $paging])

@stop
