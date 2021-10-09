@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? '地図｜'.$shop->item->page_title : '地図';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.mobile.shop')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@include('shop.mobile.partials.list-tab')
@include('shop.mobile.partials.shop-summary')
@php
if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
    $addr_latitude = 35.709409;
    $addr_longitude = 139.724121;
    $main_image = '';
} else {
    $addr_latitude = $shop->item->addr_latitude;
    $addr_longitude = $shop->item->addr_longitude;
    $main_image = $shop->item->main_image;
}
@endphp
<h3 class="clearfix fix-remove-back-h3 pad-right-125" style="margin-top:25px;padding-top:0;">

    <!--<a href="https://sweetsguide.jp/shop/43529" class="fix-remove-back">SWEETS PARADISE (スイーツパラダイス) 横浜ビブレ店</a>--><p style="width:120px;top:-30px;"><a class="toMap" onclick="navigate({{$addr_latitude}},{{$addr_longitude }})">地図アプリで見る</a></p>
</h3>

<p class="kb4-tt">{{ $shop->item->facility_name }}</p>
<p class="kb-tt-4">{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</p>
<div class="block-map-n">
    <p class="error-map-sp"></p>
    <div id="map" style="width:100%;height:500px"></div>
    <div class="div-wwp-s" style="bottom: 18px;">
        <img src="/assets/mobile/images/nc.png" alt="" class="img-nav-map" style="margin-right:10px;" onclick="get_gps()">
    </div>
</div>
<script type="text/javascript">
    var map = null;
    var addr_latitude = {{ $addr_latitude }};
    var addr_longitude = {{ $addr_longitude }};
    function initAutocomplete() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: addr_latitude, lng: addr_longitude },
        zoom: 17,
        mapTypeId: 'roadmap'
    });

    var markers = [];
    function addMarker(feature) {
        var marker = new google.maps.Marker({
            position: feature.position,
            map: map,
            optimized:false
        });
    }

    var features = [
        {
            position: new google.maps.LatLng(addr_latitude, addr_longitude),
            type: 'image1'
          }
    ];

    for (var i = 0, feature; feature = features[i]; i++) {
        addMarker(feature);
    }
}
</script>
<script>
    function get_gps(obj) {
    target = obj;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        //get location
        $('.error-map-sp').html('');
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
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var LatLng = new google.maps.LatLng(latitude, longitude);
    addr_latitude = latitude;
    addr_longitude = longitude;
    map.setCenter(LatLng);
    map.setZoom(17);

    marker = new google.maps.Marker({
           position: new google.maps.LatLng(latitude, longitude),
           map: map,
           optimized: false
           });
    google.maps.event.addListener(map, 'bounds_changed', function() {
        var bounds =  map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();
    });
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

    $(document).on('click', '#map a', function (event) {
        event.preventDefault();

        navigate(addr_latitude, addr_longitude);
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY', 'AIzaSyBY4tBJQ1ZdZpJhYGiDRAjxLSiGUjDR1Jo') }}&libraries=places&callback=initAutocomplete" async defer></script>
@stop
