@extends('layouts.mobile.index')
@section('title', $titleDescriptionKeywordH1['title'])
@section('description', $titleDescriptionKeywordH1['description'])
@section('keywords', $titleDescriptionKeywordH1['keywords'])
@php
    $h1 = $titleDescriptionKeywordH1['h1'];
    $sort = $titleDescriptionKeywordH1['sort'];
    $sortType = '並び替え';

    if ($sort == 0) {
        $sortType = 'おすすめ順';
    } elseif ($sort == 1) {
        $sortType = '価格の安い順';
    } elseif ($sort == 2) {
        $sortType = '価格の高い順';
    } elseif ($sort == 5) {
        $sortType = '駅からの距離順';
    } elseif ($sort == 6) {
        $sortType = '現在地から近い順';
    }
@endphp
@section('content')
@section('body.classes', 'productsearch')
<div id="fixed-control">
    <div id="fixed-control">
        <!-- h3 sub page -->
        <div class="modal_change2">
            <div class="shop_contents"><a href="{{ route('shopsearch.all', $params) }}">お店を探す</a></div>
            <div class="cake_contents active">ケーキを探す</div>
        </div>
        <div class="shoplist-ctrl">
            <div class="crtl-title product">ケーキ・スイーツ一覧</div>
            <ul>
                @if(!empty($regionId))
                    <li><a href="{{ route('search.index', array_merge(['parent_region_id' => $parentRegionId, 'region_id' => $regionId, 'tab_search' => 'product'], request()->all())) }}" class="icn-search" style="cursor: pointer;">条件絞込み</a></li>
                @elseif(!empty($stationId))
                    <li><a href="{{ route('search.index', array_merge(['station_id' => $stationId, 'prefecture_id' => $stationProvCode, 'rail_line_id' => $stationRailLineId, 'tab_search' => 'product'], request()->all())) }}" class="icn-search" style="cursor: pointer;">条件絞込み</a></li>
                @else
                    <li><a href="{{ route('search.index', array_merge(['tab_search' => 'product'], request()->all())) }}" class="icn-search" style="cursor: pointer;">条件絞込み</a></li>
                @endif
                <li> <a href="javascript:void(0)" class="icn-sort">おすすめ順</a>
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="icn-sort">{{ $sortType }}</a>
                            <ul class="ul-sp-sort-n">
                                @php
                                    unset($params['pos']);
                                @endphp
                                <li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->url().'?'.build_query_string($params) }}">おすすめ順</a></li>
                                <li><a @if($sort == 1) class="active" @endif @php $params['sort'] = 1 @endphp href="{{ request()->url().'?'.build_query_string($params) }}">価格の安い順</a></li>
                                <li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->url().'?'.build_query_string($params) }}">価格の高い順</a></li>
                                @if($stationId)
                                    <li><a @if($sort == 5) class="active" @endif @php $params['sort'] = 5 @endphp href="{{ request()->url().'?'.build_query_string($params) }}">駅からの距離順</a></li>
                                @endif
                                <li><a @if($sort == 6) class="active" @endif @php $params['sort'] = 6 @endphp href="{{ request()->url().'?'.build_query_string($params) }}">現在地から近い順</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="checkbox01">
            <label>
                <input type="checkbox" {{ !empty(request()-> epark_payment_use_flag) ? 'checked' : '' }} name="epark_payment_use_flag" class="checkbox01-input">
                <span class="checkbox01-parts">ポイント・キャシュポ利用可能</span>
            </label>
            <label>
                <input {{ !empty(request()->reservation_flag) ? 'checked' : '' }} class="checkbox01-input" name="reservation_flag" type="checkbox" value="1">
                <span class="checkbox01-parts">ネット予約可能</span>
            </label>
        </div>
    </div>
</div>
<div class="list-heading">
    <h1>{{ $headingStatement }} {{ numberFormat($products->num_found) }}件</h1>
</div>
@php $ogImage = ""; @endphp
<ul class="ul-ul-ul list-cake-gps clearfix hide">
    <!--  -->
    @if(isset($products->num_found))
    @if(isset($products->items) && !empty($products->items))
        @foreach($products->items as $key => $product)
        @if($key == 0)
            @php $ogImage = !empty($product->product_image1) ? httpsUrl($product->product_image1, 180) : ""; @endphp
        @endif
        <li data-id = "{{ $product->product_id }}" data-serial="" class="list-item-detail">
            <a class="dis-in-bl" href="{{ route('product.detail', [$product->product_id]) }}"><img src="{{ httpsUrl($product->product_image1, 180) }}"></a>
            @php
                $product_price = isset($product->min_product_price) ? numberFormat($product->min_product_price) . '円（税込）〜' : "";
            @endphp
            <p>{{ subString($product->product_name,10) }}<span>{{ $product_price }}</span></p>
        </li>
        @endforeach
    @else
    <p class="text-left" style="padding-left:15px;margin-top:20px;">検索結果がありません</p>
    @endif
    @else
    <p class="text-left" style="padding-left:15px;margin-top:20px;">表示に失敗しました。</p>
    @endif
    <!--  -->
</ul>
@php
    $shopIds = [];
    $productionIds = [];
@endphp
<ul class="ul-ul-ul ul-lists-list pad-0 clearfix">
    @if(isset($products->num_found))
    @if(isset($products->items) && !empty($products->items))
        @foreach($products->items as $product)
            @php
                $shopIds[] = $product->shop_id;
                if(count($productionIds) < 3) $productionIds[] = $product->product_id;
            @endphp
            <li data-id="{{ $product->product_id }}" data-serial="" class="list-item-detail clearfix pos-rel-li">
                <p class="p-f1">
                    <a class="clearfix" href="{{ route('product.detail', [$product->product_id]) }}">{{ $product->product_name }}</a>
                </p>
                @include('layouts.icon-box', ['epark_payment_use_flag' => $product->epark_payment_use_flag])
                <div class="clearfix mar-bot-15px">
                    <div class="div-w-img">
                        <a href="{{ route('product.detail', [$product->product_id]) }}">
                        <img src="{{ httpsUrl($product->product_image1, 675) }}" alt="" class="thumb-l"></a>
                    </div>
                    <div class="item-detail">
                        <p class="item-note">{!! subString(strip_tags($product->product_description1), 35) !!}<a href="{{ route('product.detail', $product->product_id) }}">もっと見る</a></p>
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
                            $listProductPrice = array_unique($listProductPrice);
                            $isMultiSize = 0;
                            if(!empty($listProductPrice)){
                                $isMultiSize = array_filter($listProductPrice, function($val){
                                    return !empty($val) && $val != "";
                                });
                                $minPrice = count($isMultiSize) ? min((array)$isMultiSize) : '';
                                $isMultiSize = count($isMultiSize);
                            }
                        @endphp
                        @if (!empty($minPrice))
                            <p class="p-pr pos-rel-sps class-product-id class-product-id-{{ $product->product_id }}" data-product-id="{{ $product->product_id }}">{{ numberFormat($minPrice) }}円<span class="span-fix-bug">(税込){{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
                        @endif
                    </div>
                    <div class="div-content">
                        <p class="c88"><a href="{{ route('shop.index', $product->shop_id) }}">{{ $product->facility_name }}</a></p>
                        <p class="shop-access">{!! showNearestStationSimple($product) !!}</p>
                    </div>
                </div>
                <div class="itemBtn">
                    <div class="favoriteBtn">
                        <a href="javascript:void(0);" class="jsClickBtnWantToAtePC data-shop-id-{{ $product->shop_id }}" data-product-id="{{ $product->product_id }}" data-liked="0" data-shop-id="{{ $product->shop_id }}">お気に入り追加</a>
                    </div>
                    @if(!empty($product->reservation_flg) && $product->reservation_flg == "1")
                        <div class="reserveBtn"><a href="{{ route('product.detail', $product->product_id) }}">予約可</a></div>
                    @endif
                </div>
            </li>
        @endforeach
        <li class="jsLoadmoreProdList" style="height:0;"></li>
    @else
    <p class="text-left" style="margin-top: 20px">検索結果がありません</p>
    @endif
    @else
    <p class="text-left" style="margin-top: 20px">表示に失敗しました。</p>
    @endif
     @php
        $shopIds = array_unique($shopIds);
    @endphp
    <input type="hidden" id="shop_ids" value="{{ json_encode($shopIds) }}">
</ul>
@include ("partials.components.mobile.pagination", ["list" => $products, "paging" => $paging])
<div class="display-map hide" style="margin: 15px 0;clear:both;">
    <div class="block-map-n">
        <p class="error-map-sp"></p>
      <div id="map" style="width:100%;height:500px"></div>
      <div class="div-wwp-s" style="bottom: 10px;">
        <img src="/assets/mobile/images/store_search_ic.png" alt="" class="img-nav-map" style="width:40px" id="displayInf">
        <img src="/assets/mobile/images/nc.png" alt="" class="img-nav-map" style="margin-right:0px;"  id="initMap">

        @if(!empty($regionId))
        <a href="{{ route('search.index', array_merge(['region_id' => $regionId], request()->all())) }}"><img src="/assets/mobile/images/s.png" alt="" style="margin-right:10px;"></a>
        @elseif(!empty($stationId))
        <a href="{{ route('search.index', array_merge(['station_id' => $stationId], request()->all())) }}"><img src="/assets/mobile/images/s.png" alt="" style="margin-right:10px;"></a>
        @else
        <a href="{{ route('search.index', request()->all()) }}"><img src="/assets/mobile/images/s.png" alt="" style="margin-right:10px;"></a>
        @endif
        <span><input id="pac-input" class="controls name-area hide" type="text" placeholder="Search" data-toggle="modal" data-target="#areaModal"></span>
      </div>
    </div>
</div>
@php $dataHasVal = (!empty($products->items)) ? 'data-has-val' : '' @endphp
<div id="carousel-example-generic" class="carousel slide silider-cus hide slide-bottom display-prod" data-ride="carousel" style="left:15px;" data-interval="false" data-has-val="{{ $dataHasVal }}">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" id="carousel-inner-append">

  </div>

  <!-- Controls -->
  <a class="left carousel-control prev-ch" href="#carousel-example-generic" role="button" data-slide="prev">
    <img src="/assets/mobile/images/nex.png" alt="">
  </a>
  <a class="right carousel-control nex-ch" href="#carousel-example-generic" role="button" data-slide="next">
    <img src="/assets/mobile/images/nex.png" alt="">
  </a>
</div>
<input type="hidden" name="full_url_except_keyword" value="{{ $isProdList }}" data-url="{{ $fullUrlExceptKeyword }}">
<style>
input[type="submit"]:hover {
  opacity: 0.8;
}
#pac-input{
  top: 442px!important;
}
.mr-inp{
  margin-right: 165px;
}
</style>

<script type="text/javascript">
    $('.jsClickBtnWantToAtePC').on('click', function(event) {
        var _this_ = $(this);
        var _isLogin = "{{ $isLogin }}";
        var shopId = _this_.attr('data-shop-id');
        if(_isLogin){
            var isLiked = _this_.attr('data-liked');
            getInfoFavorite(shopId, isLiked);
        }else{
            // $(this).toggleClass('ch-opacity');
            window.location.href = "{!! $loginLink !!}";
        }
    });
    $(document).ready(function(){
        // radio check
        $('.icon-nocheck').on({
            'click':function(){
                if($(this).hasClass('active-check')) {
                    $(this).find("input").removeAttr('checked');
                    $(this).removeClass('active-check');
                }else{
                    $(this).find("input").attr('checked', true);
                    $(this).addClass("active-check");
                }

            }
        });
        // select area
        $('.name-area').click(function(){
            var name_area = $(this).find('.name-area').length;
            if(name_area == 0){
                var data_slug = $(this).find('a').attr('data-slug');
                var data_sub_slug = $(this).find('a').attr('data-sub-slug');
                var data_area = $(this).find('a').html();
                var data_area_val = $(this).find('a').attr('data-id');
                if(data_area == '全て'){
                  data_area = $(this).parent().parent().children('a').text();
                }
                $('#areaModal-area').modal('hide');
                $('.span-area-name').html(data_area);
                $('input[name="region"]').val(data_area_val);
                $('input[name="station"]').val('');
                var _url_ = "{{ route('product.index') }}";
                if(data_sub_slug == undefined){
                    var url_form = _url_+'/'+data_slug;
                }else{
                    var url_form = _url_+'/'+data_slug+'/'+data_sub_slug;
                }
                $('#searchForm').attr('action', url_form);
            }
        });

        $('.name-area-2 a').click(function(){
          var name_area = $(this).parent().find('.name-area-2').length;
          if(name_area == 0){
            var data_id = $(this).attr('data-id');
            $('input[name="genre_id"]').val(data_id);
            var data_area = $(this).html();
            if(data_area == '全て'){
              data_area = $(this).parent().parent().parent().children('a').text();
            }
            $('#areaModal-category').modal('hide');
            $('.val-span-genre').html(data_area);
          }


        });

        $('.ajax-rail-lines').on('click', function(){
            var _this_ = $(this);
            var prefectureId = $(this).attr('data-prefectureId');
            $.ajax({
                url: "{{ route('get_rail_lines') }}",
                type: 'GET',
                data: {prefectureId: prefectureId},
            })
            .done(function(data) {
                $('.ajax-rail-lines').parent().children('ul').html('');
                _this_.parent().children('ul').append(data);
            });

        });

        $(document).on('click', '.ajax-stations', function(){
            var _this_ = $(this);
            var railLineId = $(this).attr('data-railLineId');
            var prefectureId = $(this).attr('data-prefectureId');
            $.ajax({
                url: "{{ route('get_stations') }}",
                type: 'GET',
                data: {railLineId: railLineId, prefectureId: prefectureId},
            })
            .done(function(data) {
                $('.ajax-stations').parent().children('ul').html('');
                _this_.parent().children('ul').append(data);
            });

        });

        $(document).on('click','.jsGetStationId', function(){
            var _this_ = $(this);
            var stationLineId = _this_.attr('data-stationLineId');
            var data_area = _this_.html();
            var data_area_val = _this_.attr('data-stationLineId');
            $('#modalStation').hide();
            $('#areaModal-area-station').hide();
            $('.span-area-name').html(data_area);
            $('input[name="station"]').val(data_area_val);
            $('input[name="region"]').val('');
            var _url_ = "{{ route('product.index') }}";
            var url_form = _url_+'/station/'+stationLineId;
            $('#searchForm').attr('action', url_form);
        });
    });

    function getQueryStrings() {
      var assoc  = {};
      var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
      var queryString = location.search.substring(1);
      var keyValues = queryString.split('&');

      for(var i in keyValues) {
        var key = keyValues[i].split('=');
        if (key.length > 1) {
          assoc[decode(key[0])] = decode(key[1]);
        }
      }

      return assoc;
    }

    var qs = getQueryStrings();
    var f1 = true;
    var f2 = true;
    var num_found = parseInt('{{isset($products->num_found) ? $products->num_found : 0}}');

    // current location
    var next = '{{ request()->next }}';
    if (next == 'current-location') {
        // active map
        $('.ul-lists-list').hide();
        $('.list-cake-gps').hide();
        $('.display-map').removeClass('hide').fadeIn();
        $('.show-price-gps').hide();
        $('.jsLoadmoreProd').remove();
        $('.jsLoadmoreProdList').remove();
        $('.remove-form select').prop("disabled", true);
        $('.remove-form select').css('opacity', '0.4');
    }
</script>
@php
    $hasPos = 0;
    $lat = 37.5632615;
    $lng = 136.9690448;
@endphp
@if(request()->has('pos'))
@php
    $latLng = json_decode(request()->pos);
    $lat = $latLng->lat;
    $lng = $latLng->lng;
    $hasPos = 1;
@endphp
@endif
<script>
    var map = null;
    var hasPos = "{{ $hasPos }}";
    function initAutocomplete() {
        var zoom = 5;
        var lat = 37.5632615;
        var lng = 136.9690448;
        if(hasPos == "1"){
            zoom = 15;
            lat = parseFloat("{{ $lat }}");
            lng = parseFloat("{{ $lng }}");
        }
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng },
            zoom: zoom,
            mapTypeId: 'roadmap'
        });
        var sort = "{{ request()->sort }}";
        if (next == 'current-location' || sort == "6") {
            // get current location
            var pos;
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }

                    // load data at current position
                    var existPos = "{{ request()->has('pos') }}";
                    if(sort == "6"){
                        if(!existPos){
                            var redirectUrl = "{{ request()->fullUrlWithQuery($params) }}" + "&pos=" + encodeURI(JSON.stringify(pos));
                            redirectUrl = redirectUrl.replace(/&amp;/g, '&');
                            window.location = redirectUrl;
                        }else{
                            return false;
                        }

                    }else{
                        window.location = "{{ route('product.index.all') }}" + "?pos=" + encodeURI(JSON.stringify(pos)) + "&sort=3";
                    }
                }, function() {
                    // handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                // handleLocationError(false, infoWindow, map.getCenter());
            }
        }
    }

    function displayMap() {
        var bounds =  map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();
        $.ajax({
            url: '{{ request()->url() }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                min_max_lat_long: [
                    [
                        ne.lat(),
                        ne.lng()
                    ],
                    [
                        sw.lat(),
                        sw.lng()
                    ]
                ],
                region: qs['region'],
                genre_id: qs['genre_id'],
                price: qs['price'],
                sunday: qs['sunday'],
                start_time: qs['start_time'],
                end_time: qs['end_time'],
                reserve: qs['reserve'],
                credit_card: qs['credit_card'],
                parking: qs['parking'],
                gift_wrapping: qs['gift_wrapping'],
                character_cake: qs['character_cake'],
                presence_coupon: qs['presence_coupon'],
                receipt_date: qs['receipt_date'],
                cafe: qs['cafe'],
                takeout: qs['takeout'],
                souvenir: qs['souvenir'],
                usage: qs['usage'],
                size3: qs['size3'],
                size4: qs['size4'],
                size5: qs['size5'],
                size6: qs['size6'],
                size7: qs['size7'],
                size8: qs['size8'],
                size9: qs['size9'],
                size10: qs['size10'],
                size11: qs['size11'],
                typeAjax: 'maps',
                sort: qs['sort'],
                pos: qs['pos'],
                keyword: qs['keyword'],

            },

        })
        .done(function(data) {
            var images = [];
            var features = [];
            $.each(data[1], function(index, val) {
                var img = val.image;
                img = img.replace(/^http:\/\//i, 'https://');
                images.push({url:img, scaledSize : new google.maps.Size(35, 35)});
                features.push({position: new google.maps.LatLng(val.lat,val.lng)});
            });
            var gmarkers = [];
            function addMarker(feature) {
                var marker = new google.maps.Marker({
                position: feature.position,
                map: map
                });

                gmarkers.push(marker);
            }
            for (var i = 0, feature; feature = features[i]; i++) {
            addMarker(feature);
            }
            map.addListener('zoom_changed', function() {
                for(i=0; i < gmarkers.length; i++) {
                    gmarkers[i].setMap(null);
                }
                $('.slide-bottom').hide();
                $('.div-wwp-s').removeClass('trans-top');
                $('.bor-footer-list-pro').removeClass('bor-footer-list-pro-lar');
            });
            $('#carousel-inner-append').html('');
            $('#carousel-inner-append').append(data[0]);
            if(data[1] != ""){
                var hasData = $('.slide-bottom').attr('data-has-val');
                if(hasData == 'data-has-val'){
                    $('.slide-bottom').removeClass('hide').fadeIn();
                }
                $('.div-wwp-s').addClass('trans-top');

                $('.bor-footer-list-pro').addClass('bor-footer-list-pro-lar');
            }

        });

    }

</script>
<script>
function get_gps(obj) {
    target = obj;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        $('.error-map-sp').html('');
        //get location
        navigator.geolocation.getCurrentPosition(successCallback,errorCallback);
    } else {
        // Browser doesn't support Geolocation
        $('.error-map-sp').html('位置情報が取得できません');
    }
}
var marker;
function successCallback(position) {
    if (typeof(marker) !== 'undefined') {
        marker.setMap(null);
    };
    // 緯度：position.coords.latitude
    // 経度：position.coords.longitude
    // 高度：position.coords.altitude
    // 緯度・経度の誤差：position.coords.accuracy
    // 高度の誤差：position.coords.altitudeAccuracy
    // 方角：position.coords.heading
    // 速度：position.coords.speed
    var LatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    map.setCenter(LatLng);
    map.setZoom(17);
    marker = new google.maps.Marker({
       position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
       map: map,
       optimized: false
   });

    var bounds =  map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    $.ajax({
        url: '{{ request()->url() }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                current_coordinates: [
                    [
                        position.coords.latitude,
                        position.coords.longitude
                    ],
                    [
                        ne.lat(),
                        ne.lng()
                    ],
                    [
                        sw.lat(),
                        sw.lng()
                    ]
                ],
                region: qs['region'],
                genre_id: qs['genre_id'],
                price: qs['price'],
                sunday: qs['sunday'],
                start_time: qs['start_time'],
                end_time: qs['end_time'],
                reserve: qs['reserve'],
                credit_card: qs['credit_card'],
                parking: qs['parking'],
                gift_wrapping: qs['gift_wrapping'],
                character_cake: qs['character_cake'],
                presence_coupon: qs['presence_coupon'],
                receipt_date: qs['receipt_date'],
                cafe: qs['cafe'],
                takeout: qs['takeout'],
                souvenir: qs['souvenir'],
                usage: qs['usage'],
                size3: qs['size3'],
                size4: qs['size4'],
                size5: qs['size5'],
                size6: qs['size6'],
                size7: qs['size7'],
                size8: qs['size8'],
                size9: qs['size9'],
                size10: qs['size10'],
                size11: qs['size11'],
                typeAjax: 'maps',
                sort: qs['sort'],
                pos: qs['pos'],
            },
    })
    .done(function(data) {
        var images = [];
        var features = [];
        $.each(data, function(index, val) {
            images.push({url:val.image, scaledSize : new google.maps.Size(35, 35)});
            features.push({position: new google.maps.LatLng(val.lat,val.lng)});
        });
        var gmarkers = [];
        function addMarker(feature) {
            var marker = new google.maps.Marker({
            position: feature.position,
            map: map
            });

            gmarkers.push(marker);
        }
        for (var i = 0, feature; feature = features[i]; i++) {
            addMarker(feature);
        }
        map.addListener('zoom_changed', function() {
            for(i=0; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
            }
            $('.slide-bottom').hide();
            $('.div-wwp-s').removeClass('trans-top');
            $('.bor-footer-list-pro').removeClass('bor-footer-list-pro-lar');
        });
    });
    $('#displayInf').addClass('location');
}

function errorCallback(error) {
    // handleLocationError(true, infoWindow, map.getCenter());
    var err_msg = "";
    switch(error.code){
        case 1:
          err_msg = "位置情報の取得が許可されていません";
          break;
        case 2:
        case 3:
          err_msg = "位置情報が取得できませんでした";
          break;
    }
    $('.error-map-sp').html(err_msg);
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
<script type="text/javascript">
    $(document).on('click', '.jsDelregion', function(e){
        $('.span-area-name').html('エリア・駅を選択する');
        // $('input[name="region"]').val('');
        // $('input[name="station"]').val('');
        $(this).remove();
        var _url_ = "{{ route('product.index.all') }}";
        $('#searchForm').attr('action', _url_);
        return false;
    });
    $(document).on('click', '.jsDelGenre', function(e){
        $('.val-span-genre').html('ジャンルを選択する');
        $('input[name="genre_id"]').val('');
        $(this).remove();
        return false;
    });

    $(window).load(function(){
        $('#loading').hide();
        $('.over').hide();
    });

    // check if localStorage/sessionStorage is supported
    isLocalStorageNameSupported = function() {
        return false;
        var testKey = 'test', storage = window.sessionStorage;
        try {
            storage.setItem(testKey, '1');
            storage.removeItem(testKey);
            return true;
        } catch (error) {
            return false;
        }
    }

    // Check browser support
    if (isLocalStorageNameSupported()) {
        if (!JSON.parse(localStorage.getItem("objKeywords"))) {
            var arrKeywords = [];
            var keyword = "{{ Request::query('keyword') }}";
            if (keyword != "") {
                arrKeywords.push(keyword);
            }
            // Store
            localStorage.setItem("objKeywords", JSON.stringify(arrKeywords));
        } else {
            var arrCurrentKeyWords = JSON.parse(localStorage.getItem("objKeywords"));
            var keyword = "{{ Request::query('keyword') }}";
            if (keyword != "") {
                if (arrCurrentKeyWords.length > 9) {
                    if (arrCurrentKeyWords.indexOf(keyword) <= -1) {
                        arrCurrentKeyWords.shift();
                        arrCurrentKeyWords.push(keyword);
                    }else{
                        arrCurrentKeyWords.push(arrCurrentKeyWords.splice(arrCurrentKeyWords.indexOf(keyword), 1)[0]);
                    }
                } else {
                    if (arrCurrentKeyWords.indexOf(keyword) <= -1) {
                        arrCurrentKeyWords.push(keyword);
                    }else{
                        arrCurrentKeyWords.push(arrCurrentKeyWords.splice(arrCurrentKeyWords.indexOf(keyword), 1)[0]);
                    }
                }
                localStorage.setItem("flg_key_word", "1");
            }else{
                localStorage.setItem("flg_key_word", "0");
            }
            localStorage.setItem("objKeywords", JSON.stringify(arrCurrentKeyWords));
        }
    } else {
        $('#result').val("Sorry, your browser does not support Web Storage...");
    }
    $(".input-group-addon-2").on("change", function() {
        this.setAttribute("data-date", moment(this.value, "YYYY-MM-DD").format(this.getAttribute("data-date-format")));
    });

    if (isLocalStorageNameSupported()) {
        // Code for localStorage/sessionStorage.
        window.sessionStorage.setItem('will-be-back-link', window.location.href);
    }
</script>
<script type="text/javascript">
    if(qs['size3'] == "on" && qs['size4'] && qs['size5'] && qs['size6'] && qs['size7'] && qs['size8'] && qs['size9'] && qs['size10'] && qs['size11']){
        $('.label-all').addClass('active-checkbox-all');
        $('#check_all').prop('checked', true);
    }else{
        $('.label-all').removeClass('active-checkbox-all');
        $('#check_all').prop('checked', false);
    }

    $(document).on('click', '.pos-fixed', function(){
        $('#searchForm').submit();
    });

    $(document).on('click', '#initMap', function() {
        $('.slide-bottom').hide();
        get_gps();
    });

    $(document).on('click', '#displayInf', function() {
        displayMap();
    });
   $(function () {
    // display header when scroll on moblie
        if ($('#fixed-control').length) {
            var now_offset;
            var menu_offset = $('#fixed-control').offset().top;
            $(window).on('scroll', function () {
                now_offset = window.pageYOffset;
                $('body').toggleClass('control-fixed', now_offset > menu_offset);
            });
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
                $('.data-shop-id-'+this.shop_id).html('お気に入り追加済').attr('data-liked',"1").parent().addClass('completed');
            }else{
                $('.data-shop-id-'+this.shop_id).html('お気に入り追加').attr('data-liked',"0").parent().removeClass('completed');
            }
        });
   }

    var _shopIds = '<?php echo empty($shopIds) ? '' : json_encode($shopIds) ?>';
    if ('{{ $isLogin }}' && _shopIds) {
        _shopIds = JSON.parse(_shopIds);
        $.each(_shopIds, function (key, shopId) {
            getInfoFavorite(shopId);
        });
    }
</script>
<input type="hidden" name="num_found" value="{{ isset($products->num_found) ? $products->num_found : 0 }}">
<script>
    $(document).on('click', '.checkbox01-input', function(){
        var newUrl = window.location.href;
        var name   = $(this).attr('name');
        if ($(this).is(':checked')) {
            if(newUrl.indexOf('?') != -1){
                newUrl = newUrl + '&'+name+'=1';
            } else {
                newUrl = newUrl+'?'+name+'=1';
            }
        } else {
            if (newUrl.indexOf("?"+name+"=1") !== false && newUrl.indexOf("?"+name+"=1") >= 0) {
                if (newUrl.indexOf(name+"=1"+"&") !== false && newUrl.indexOf(name+"=1"+"&") >= 0) {
                    newUrl = newUrl.replace(name+"=1"+"&", "");
                }else{
                    newUrl = newUrl.replace("?"+name+"=1", "");
                }
            }else{
                newUrl = newUrl.replace("&"+name+"=1", "");
            }
        }
        //ok
        window.location = newUrl;
    });
</script>
@stop
