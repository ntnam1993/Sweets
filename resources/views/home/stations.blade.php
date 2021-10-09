<p class="title-top-u">
    <span>{{ $provName }}</span>{{ $stationName }}<small>の駅名から探す</small>
    <a href="javascript:void(0)" class="show-railLine">〈 路線選択に戻る</a>
</p>
<div class="div-top-ajax">
    <ul class="clearfix ul-list-railline">
    	@php
            $route = ($isShopSearch == 'shopsearch.region' || $isShopSearch == 'shopsearch.all' || $isShopSearch == 'shopsearch.station') ? 'shopsearch.station' : 'product.index.station';
        @endphp
        @foreach($stations as $key => $station)
            <li><a href="{{ route($route, ['station' => $station->station_id]) }}" class="not-redirect cursor-ponter {{ ($stationId == $station->station_id) ? 'be-active' : ''}}" data-search="station" data-station-id="{{$station->station_id}}">{{ $station->station_name }}</a></li>
        @endforeach
    </ul>
</div>
