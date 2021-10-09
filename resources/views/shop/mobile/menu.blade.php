@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? 'メニュー｜'.$shop->item->page_title : 'メニュー';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.mobile.shop')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@include('shop.mobile.partials.list-tab')
@include('shop.mobile.partials.shop-summary')
<!--  -->
<div class="div-menu-new clearfix">
    <p class="p-n p-n-fix pull-left" style="margin-bottom:-6px;border:none;width:37%;font-weight:700!important;">
    @if(!empty($products->num_found)) {{ $products->num_found }}件 @endif</p>
    <ul class="ul-tab-mn ul-tab-mn-2 clearfix" style="width:63%;">
        <li data-type="1"><p href="javascript:void(0)"><span></span></p></li>
        <li class="active" data-type="2"><p href="javascript:void(0)"><span></span></p></li>
    </ul>
</div>

<ul class="list-cake-gps clearfix hide" style="margin-top:20px;">
    @include ("shop.mobile.load-more-menu")
 </ul>
 <ul class="ul-ul-ul ul-lists-list clearfix">
    @include ("shop.mobile.load-more-menu-list", compact("products"))
</ul>

@include ("partials.components.mobile.pagination", array_merge(["list" => $products], compact("paging")))

@stop
