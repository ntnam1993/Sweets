@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? 'メニュー｜'.$shop->item->page_title : 'メニュー';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.index_child_2')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@section("container.class", "css-new")
<div class="pc-content">
    <ul class="t-path">
        <li class="t-path-list"><span><a href="{{ route('index') }}" style="color:inherit">EPARKスイーツガイド</a></span></li>
        @if(!empty($region))
            <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a></span></li>
            @if(!empty($subRegion))
                <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a></span></li>
            @endif
        @endif
        <li class="t-path-list"><span><a href="{{ route('shop.index', ['id' => $shopId]) }}" style="color:inherit">{{ $shop->item->facility_name }}</a></span></li>
        <li><span>メニュー</span></li>
    </ul>
    @include ("shop.partials.shop-info", compact("shopId", "shop"))
    @include ("partials.shop.list-tab", compact("shopId"))
    <div class="tab-content" style="position: relative">
        <div id="menu-overlay" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; background-color: rgba(255, 255, 255, 0.8); display: none;">
            <img src="/assets/pc/images/loading.gif" style="width: 50px; padding-top: 400px;">
        </div>
        <h2  class="no-BrdT">{{ $shop->item->facility_name }}のメニュー</h2>
        @if (!empty($products->item))
            <ul id="listCakes" class="list-cake3 list-menu ul-img-cover cake-list cake-list-clear-both jsAutoHeight">
                @include ("shop.load-more-menu", compact("products"))
            </ul>
        @endif
        @if(empty($products->num_found) || $products->num_found == 0)
            <p class="align-left">表示するメニューがありません</p>
        @else
            @if ($products->num_found > $products->rows)
                <input type="hidden" id="hiddenStart" value="{{ 20 }}">
            @endif
        @endif

        {{-- BEGIN .paging --}}
        @include ("partials.components.pagination", compact("paging"))
        {{-- END .paging --}}

    </div>
</div>
<script>
    function adjustCakeNameHeight(callback) {
        var maxHeight = 0;
        $("#listCakes .cake-name").each(function (index) {
            var self = $(this);
            maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
        });
        $("#listCakes .cake-name").css("height", maxHeight + "px");
        if (callback) callback();
    }
    function adjustCakeItemHeight(callback) {
        var maxHeight = 0;
        $("#listCakes > li .sizes-price-wrapper").each(function (index) {
            var self = $(this);
            maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
        });
        $("#listCakes > li .sizes-price-wrapper").css("height", maxHeight + "px");
        if (callback) callback();
    }
    function doAdjustment() {
        adjustCakeNameHeight(adjustCakeItemHeight);
    }
    $(document).ready(doAdjustment);
</script>
@stop
