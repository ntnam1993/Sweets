@php
  $stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
  $train_line = isset($shop->item->train_line1) ? $shop->item->train_line1 : '';
  $exit_station = isset($shop->item->exit_station1) ? $shop->item->exit_station1 : '';
  $means = isset($shop->item->means1) ? $shop->item->means1 : '';
  $time_required = isset($shop->item->time_required1) ? $shop->item->time_required1 : '';
  $flo_tag = isset($shop->item->epark_payment_use_flag) ? $shop->item->epark_payment_use_flag : '';
@endphp
<div class="flo-shop-sp">
  <h1 class="shop-name">{{ $shop->item->facility_name }}</h1>
  @if($flo_tag == 1)
  <p class="flo-tag">事前決済OK</p>
  @elseif($flo_tag == 2)
  <p class="flo-tag">カード決済のみ</p>
  @else
  @endif
<dl class="shop-detail">
    @php
        if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
            $addr_latitude = 35.709409;
            $addr_longitude = 139.724121;
        } else {
            $addr_latitude = $shop->item->addr_latitude;
            $addr_longitude = $shop->item->addr_longitude;
        }
    @endphp
    <dt>住所</dt>
    <dd>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}(<a href="{{ route("floprestige.shop.map", $shopId) }}" class="link-red">地図</a>)</dd>
</dl>
<dl class="shop-detail">
  <dt>最寄駅</dt>
  <dd>{{ $train_line.' '.$stationName.' '.$exit_station.' '.$means.' '.$time_required }}分</dd>
</dl>
@if(!empty($shop->worktime()))
<dl class="shop-detail">
  <dt>営業時間</dt>
  <dd>
    @foreach($shop->worktime() as $worktime)
    @if($loop->first)
    <span>{{ $worktime["time"] }}</span>
    @else
    <span>&nbsp;{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
    @endif
    @endforeach
  </dd>
  @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
  <dt>&nbsp;定休日 </dt>
  @foreach($shop->time_off() as $timeoff)
  <dd>{{$timeoff}}</dd>
  @endforeach
  @endif
</dl>
@endif
</div>
