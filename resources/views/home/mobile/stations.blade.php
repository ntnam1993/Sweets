@foreach($stations as $station)
    <li class="name-area fix-color"><a data-stationLineId="{{ $station->station_id }}" class="jsGetStationId no-bg-bl {{ ($stationId == $station->station_id) ? 'be-active' : ''  }}">{{ $station->station_name }}</a></li>
@endforeach
