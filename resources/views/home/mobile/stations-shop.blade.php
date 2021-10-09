@foreach($stations as $station)
    <li class="name-area fix-color"><a href="{{ route('shopsearch.station', ['station' => $station->station_id, 'sort' => $sortShopSearch]) }}" data-stationLineId="{{ $station->station_id }}" class="jsGetStationId no-bg-bl {{ ($stationId == $station->station_id) ? 'be-active' : ''  }}">{{ $station->station_name }}</a></li>
@endforeach
