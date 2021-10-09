<p class="title-top-u">
    <span>{{ $rootStationName }}</span><strong class="span-provName" style="font-weight:normal;">{{ $provName }}</strong> <small>の路線から探す</small>
    <a href="javascript:void(0)" class="show-root">〈 都道府県選択に戻る</a>
</p>
<div class="div-top-ajax">
    <ul class="clearfix ul-list-railline">
        @foreach($railLines as $key => $railLine)
            <li><a href="javascript:void(0)" class="ajax-stations" data-prefectureId="{{ $railLine->prov_code }}" data-railLineId="{{ $railLine->rail_line_id }}">{{ $railLine->rail_line_name }}</a></li>
        @endforeach
    </ul>
</div>
