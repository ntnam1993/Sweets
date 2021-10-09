@extends('layouts.search')
@section('title', $titleDescriptionKeywordH1['title'])
@section('description', $titleDescriptionKeywordH1['description'])
@section('keywords', $titleDescriptionKeywordH1['keywords'])
@php
    $h1 = $titleDescriptionKeywordH1['h1'];
    $sort = $titleDescriptionKeywordH1['sort'];
@endphp
@section('content')
@section('body.classes', 'productsearch')
@include('partials.headers.mobile.breadcrumb')
@include('masters.sidebar')
<div class="block-right">
    <div class="list-hdr">
        <h1 class="search-h1 product">ケーキ・スイーツ一覧</h1>
        <ul class="nav-order product pull-right">
            <li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->fullUrlWithQuery($params) }}">おすすめ順</a></li>
            <li><a @if($sort == 1) class="active" @endif @php $params['sort'] = 1 @endphp href="{{ request()->fullUrlWithQuery($params) }}">価格の安い順</a></li>
            <li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->fullUrlWithQuery($params) }}">価格の高い順</a></li>
            @if($stationId)
                <li><a @if($sort == 5) class="active" @endif @php $params['sort'] = 5 @endphp href="{{ request()->fullUrlWithQuery($params) }}">駅からの距離順</a></li>
            @endif
        </ul>
    </div>
    <div class="list-current">
        @php
            $toPage = ((($paging['currentPage'] * $productLimit) + 1) > $paging['numFound']) ? $paging['numFound'] : ($paging['currentPage'] * $productLimit);
            $startPage = 0;
            if ((int)$paging['numFound'] > 0){
                $startPage = numberFormat(($paging['currentPage'] * $productLimit) - ($productLimit - 1));
            }
            $sortText = $sort == 0 ? 'おすすめ順' : ($sort == 1 ? '価格の安い順' : ($sort == 2 ? '価格の高い順' : ($sort == 5 ? '駅からの距離順' : '')))
        @endphp
        <p>{{ $headingStatement }}（{{ $sortText }}）<strong>{{ $startPage }}〜{{ numberFormat($toPage) }}件を表示</strong> | <strong>全{{ numberFormat($paging['numFound'] ) }}件</strong></p>
    </div>
    @php
        $ogImage = "";
        $shopIds = [];
        $productionIds = [];
    @endphp
    <ul class="ul-list-item-main">
        @if(!empty($products->items))
        @foreach($products->items as $key => $product)
        @php
            $shopIds[] = $product->shop_id;
            if(count($productionIds) < 3) $productionIds[] = $product->product_id;
        @endphp
        @if($key == 0)
            @php $ogImage = !empty($product->product_image1) ? httpsUrl($product->product_image1, 675) : ""; @endphp
        @endif
        <li class="clearfix">
            <div class="item-name">
                <p class="p-ch-tt-2 item-title" style="font-weight: bold;"><a href="{{ route('product.detail', $product->product_id) }}" style="font-weight: bold;">{{ $product->product_name }}</a></p>
                @include('layouts.icon-box', ['epark_payment_use_flag' => $product->epark_payment_use_flag])
            </div>
            <div class="pull-left">
                <a href="{{ route('product.detail', $product->product_id) }}" class="pos-rel-pc">
                    <span class="card-cover__wrapper" style="width: 180px; height: 180px">
                        <span class="card-cover__content" style="background-image: url({{ httpsUrl($product->product_image1, 185) }})"></span>
                        <img src="{{ httpsUrl($product->product_image1, 180) }}" alt="" class="thumb-ch">
                    </span>
                </a>
            </div>
            <div class="div-txt-shop clearfix">
                <p class="p-ch-cont-shop">
                    {!! subString(strip_tags($product->product_description1), 77) !!}
                    <span><a href="{{ route('product.detail', $product->product_id) }}">商品詳細を見る</a></span>
                </p>
                <ul class="ul-sizes">
                    @foreach($product->product_price_by_size as $k => $v)
                        @if(!empty($v))
                            <li>{{ convertCakeSize($k) }}</li>
                        @endif
                    @endforeach
                </ul>
                @php
                    $listProductPrice = (array)$product->product_price_by_size;
                    $listProductPrice['product_price'] = $product->product_price;
                    $isMultiSize = 0;
                    $listProductPrice = array_unique($listProductPrice);
                    if(!empty($listProductPrice)){
                        $isMultiSize = array_filter($listProductPrice, function($val){
                            return !empty($val) && $val != "";
                        });
                        $minPrice = count($isMultiSize) ? min((array)$isMultiSize) : '';
                        $isMultiSize = count($isMultiSize);
                    }
                @endphp
                @if (!empty($minPrice))
                    <p class="p-ch-tt-2 item-price" style="font-weight: bold;">{{ numberFormat($minPrice) }}円<span>（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
                @endif
            </div>
            <div class="shop_info">
                <p class="p-ch-tt"><span class="span-shopName">
                    <a href="{{ route('shop.index', $product->shop_id) }}" style="font-weight: normal;">{{ $product->facility_name }}</a></span><br>
                    <span class="span-station shop-{{ $product->shop_id }}"></span>
                </p>
                <p class="shop-access">{!! showNearestStationSimple($product) !!}</p>
                <div class="shop-menu">
                    <p>
                        <a href="javascript:void(0);" class="favorite-button jsClickBtnWantToAtePC data-shop-id-{{ $product->shop_id }}" data-product-id="{{ $product->product_id }}" data-liked="0" data-shop-id="{{ $product->shop_id }}">お気に入り追加</a>
                        @if(!empty($product->reservation_flg) && $product->reservation_flg == "1")
                            <a href="{{ route('product.detail', $product->product_id) }}" class="reserve-button">予約可</a>
                        @endif
                    </p>
                </div>
            </div>
        </li>
        @endforeach
        @else
        検索結果がありません
        @endif
        @php
            $shopIds = array_unique($shopIds);
        @endphp
        <input type="hidden" id="shop_ids" value="{{ json_encode($shopIds) }}">
    </ul>
    <div class="block-right">
        <div class="list-hdr">
            <h1 class="search-h1 product">ケーキ一覧</h1>
            <ul class="nav-order product pull-right">
                @php
                    $sort = !empty(request()->sort) ? request()->sort : '';
                @endphp
                <li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->fullUrlWithQuery($params) }}">おすすめ順</a></li>
                <li><a @if($sort == 1) class="active" @endif @php $params['sort'] = 1 @endphp href="{{ request()->fullUrlWithQuery($params) }}">価格の安い順</a></li>
                <li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->fullUrlWithQuery($params) }}">価格の高い順</a></li>
                @if($stationId)
                    <li><a @if($sort == 5) class="active" @endif @php $params['sort'] = 5 @endphp href="{{ request()->fullUrlWithQuery($params) }}">駅からの距離順</a></li>
                @endif
            </ul>
        </div>
    </div>
    @include ("partials.components.pagination", compact("paging"))
</div>
<script type="text/javascript">
    var _shopIds = '<?php echo empty($shopIds) ? '' : json_encode($shopIds) ?>';
    if ('{{ $isLogin }}' && _shopIds) {
        _shopIds = JSON.parse(_shopIds);
        $.each(_shopIds, function (key, shopId) {
            getInfoFavorite(shopId);
        });
    }

    $('.jsClickBtnWantToAtePC').on('click', function(event) {
        var _this_ = $(this);
        var _isLogin = "{{ $isLogin }}";
        var shopId = _this_.attr('data-shop-id');
        if(_isLogin){
            var isLiked = _this_.attr('data-liked');
            getInfoFavorite(shopId, isLiked);
        }else{
            window.location.href = "{!! $loginLink !!}";
        }
    });

    function getInfoFavorite(shop_id, is_liked)
    {
        var data = {
            catalog_id: shop_id,
        }
        if(is_liked != undefined){
            if(is_liked == "0"){
                data.update_code = "1";
            }else{
                data.update_code = "2";
            }
        }
        $.ajax({
            url: '/favorite/operation/index',
            type: 'GET',
            dataType: 'JSON',
            data: data,
            shop_id: shop_id
        })
        .done(function(res) {
            if(res.status == "0" && res.favorite == "1"){
                $('.data-shop-id-'+this.shop_id).addClass('completed').html('お気に入り追加済').attr('data-liked',"1");
            }else{
                $('.data-shop-id-'+this.shop_id).removeClass('completed').html('お気に入り追加').attr('data-liked',"0");
            }
        });
    };
</script>
@stop
