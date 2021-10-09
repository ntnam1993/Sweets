@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = $shopName.'│FLO PRESTIGE PARIS（フロ プレステージュ パリ）';
$description = $shopName.'のMAPページです。FLO（フロ プレステージュ）では、店内キッチンから生まれる、出来立て・手作り商品のケーキ、タルト、焼き菓子、デリカ(惣菜)をフレンチ・テイストでご提供しています。ギフトやお誕生日、記念日等のアニバーサリーにもご利用ください。';
$train_line = isset($shop->item->train_line1) ? $shop->item->train_line1 : '';
$exit_station = isset($shop->item->exit_station1) ? $shop->item->exit_station1 : '';
$means = isset($shop->item->means1) ? $shop->item->means1 : '';
$time_required = isset($shop->item->time_required1) ? $shop->item->time_required1 : '';
@endphp
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
@extends('layouts.mobile.shop')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'flo-page-sp flo-map-sp drawer drawer--right drawer-close')
@section('content')
	@include('masters.mobile.headerFloprestige')
  <div class="sp-container clearfix ">
  	@include ("floprestige.mobile.partials.shop-info", compact("shopId", "shop", "stationName"))
  	@include ("floprestige.mobile.partials.list-tab", compact("shopId"))
    <h3 class="clearfix fix-remove-back-h3 pad-right-125 map_app">
      <p><a class="toMap" onclick="navigate({{$addr_latitude}},{{$addr_longitude }})">地図アプリで見る</a></p>
    </h3>
    <div class="block-map-n">
        <p class="error-map-sp"></p>
        <div id="map" style="width:100%;height:500px"></div>
        <div class="div-wwp-s" style="bottom: 18px;">
            <img src="/assets/mobile/images/nc.png" alt="" class="img-nav-map" style="margin-right:10px;" onclick="get_gps()">
        </div>
    </div>
    <table class="info_table">
        <tbody>
            <tr>
                <th>店舗名</th>
                <td>
                <ul class="table-list">
                    <li><span class="">{{ $shop->item->facility_name }}</span></li>
                </ul>
                </td>
            </tr>
            <tr>
                <th>住所</th>
                @php
                    if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
                        $addr_latitude = 35.709409;
                        $addr_longitude = 139.724121;
                    } else {
                        $addr_latitude = $shop->item->addr_latitude;
                        $addr_longitude = $shop->item->addr_longitude;
                    }
                    $main_image = !empty($shop->item->main_image) ? $shop->item->main_image : '/assets/pc/images/thum-def.png';
                @endphp
                <td>
                <ul class="table-list">
                    <li><span>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</span></li>
                    <li><a href="#" onclick="navigate({{$addr_latitude}},{{$addr_longitude }})"><span class="light-green">アクセスマップ</span></a></li>
                </ul>
                </td>
            </tr>
            <tr>
                <th>最寄り駅</th>
                <td>
                {{ $train_line.' '.$stationName.' '.$exit_station.' '.$means.' '.$time_required }}分
                </td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>
                @if(!empty($shop->item->tel_no))
                    <div>{{ $shop->item->tel_no }}</div>
                @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-left flo-note">
      @if(!empty($shop->item->calendar_comment))
      <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
      @endif
    </div>
	</div>
@include('masters.mobile.footerFloprestige')
	<script>
$(document).ready(function() {
$('.drawer').drawer();
});
</script>
<script>
  $(function() {
      var menu = $(".bottom_look");
      $(window).scroll(function () {
          if ($(this).scrollTop() > 10) {
              menu.fadeIn();
          } else {
              menu.fadeOut();
          }
      });
  });
</script>
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
            position: new google.maps.LatLng({{ $addr_latitude }},{{ $addr_longitude }}),
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
