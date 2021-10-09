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
@extends('layouts.index_child_2')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'flo-page')
@section('content')
  @include('masters.headerFloprestige')
  <div class="css-new menu-list">
    <div class="pc-container">
      <ul class="t-path">
          <li class="t-path-list"><span><a href="https://www.flojapon.co.jp/" class="link-t-path-border-2">FLO PRESTIGE PARIS（フロ プレステージュ）</a></span></li>
					<li class="t-path-list"><span><a class="link-t-path-border-2" href="https://flo.{{ env('DOMAIN_COOKIE') }}">店頭受取りWEB予約</a></span></li>
          <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a></span></li>
          <li><span>{{ $shopName }}地図</span></li>
      </ul>
      @include ("floprestige.partials.shop-info", compact("shopId", "shop", "stationName"))
      @include ("floprestige.partials.list-tab", compact("shopId"))
      <div class="tab-content">
          <div class="iframe-kb4 map-canvas"></div>
          <table class="table-kb4 table-kb4-ch map_table">
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
    </div>
  </div>
  @include('masters.footerFloprestige')
  <script type="text/javascript">
      var addr_latitude = {{ floatval($addr_latitude) }};
      var addr_longitude = {{ floatval($addr_longitude) }};
      function initMap() {
          var uluru = {lat: addr_latitude, lng: addr_longitude};
          var mapCanvases = document.getElementsByClassName('map-canvas');
          for (var i = 0; i <= mapCanvases.length - 1; i++) {
              var map = new google.maps.Map(mapCanvases[i], {
                  zoom: 17,
                  center: uluru,
                  mapTypeId: 'roadmap'
              });
              var marker = new google.maps.Marker({
                  position: uluru,
                  map: map
              });
          }
      }

      $(document).on('click', '.map-canvas a', function (event) {
          event.preventDefault();

          navigate(addr_latitude, addr_longitude);
      });
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('GOOGLE_API_KEY') }}&callback=initMap"></script>
@stop
