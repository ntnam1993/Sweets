<form action="{{ $urlFormShop }}" method="GET" id="searchForm1">
    @if (request()->has('map') && request()->map == '1')
        <input type="hidden" name="map" value="1">
    @endif
    @if (request()->has('current_location') && request()->current_location == '1')
        <input type="hidden" name="current_location" value="1">
    @endif
    <input type="hidden" name="tab_search" value="shop">
    <input type="hidden" name="remove_search_cookie" value="">
    <div class="modal-body area-body">
        <h3 class="pos-relat-search p-tt-s-1">エリア・駅から探す</h3>
        <a class="region-modal" style="cursor: pointer;" onclick="showModalAreaStation(this)" data-toggle="modal" data-target="#areaModal-area-station">
            <div class="area-gps area-gps-add-x">
                @php
                    if(request()->has('pos')) {
                        $regionName = '現在地';
                    } else if (isset($searchResult['region'])) {
                        $regionName = $searchResult['region'];
                    } else if (isset($searchResult['station'])) {
                        $regionName = $searchResult['station'];
                    } else {
                        $regionName = $regionNameDefault;
                    }
                @endphp
                <span class="span-area-name region-text" data-parent-region-id="" data-region-id="" data-tab="" data-prefectureid="" data-raillineid="" data-stationlineid="">{{ $regionName }}</span>
                @if($regionName !== $regionNameDefault)
                    <span class="span-x-2 jsDelregion">×</span>
                @endif
            </div>
        </a>
        <h3 class="pos-relat-search p-tt-s-2">ケーキ・スイーツの種類から探す</h3>
        <div class="area-gps area-name area-gps-add-y" style="cursor: pointer;" onclick="showModalCategory(this)" data-toggle="modal" data-target="#areaModal-category">
            @php
                if (Request::query('genre_id') == '') {
                    $genreName = $genreNameDefault;
                } else {
                    $genreName = getGenreNameById(Request::query('genre_id'))->category_name;
                }
            @endphp
            <span class="val-span-genre">{{ $genreName }}</span>
            <input type="hidden" value="{{Request::query('genre_id')}}" name="genre_id">
            @if($genreName != $genreNameDefault)
                <span class="span-x-2 jsDelGenre">×</span>
            @endif
        </div>
        <h3 class="pos-relat-search p-tt-s-3">こだわり条件検索</h3>
        <div class="reservation_box">
            <h4 class="p-tt-s p-tt-s-4 border_none joken"><strong>条件・サービス</strong></h4>
            <label>
                <input {{ !empty(request()->reservation_flag) ? 'checked' : '' }} class="checkbox01-input" name="reservation_flag" type="checkbox" value="1">
                <span class="checkbox01-parts">ネット予約可能</span>
            </label>
            <label>
                <input {{ !empty(request()->epark_payment_use_flag) ? 'checked' : '' }} class="checkbox01-input" name="epark_payment_use_flag" type="checkbox" value="1">
                <span class="checkbox01-parts">ポイント・キャシュポ利用可能</span>
            </label>
        </div>
        @if (!empty($coupon))
            <div class="div-coupon-info">
                <div class="area-gps area-coupon area-gps-add-y cpn_longName" data-toggle="modal" data-target="" style="cursor: pointer;">
                    <span class="">{{ $coupon->coupon_name }}</span>
                    <input type="hidden" name="cp_code" value="{{ request()->cp_code }}">
                    <span class="del-x del-x-2">×</span>
                </div>
            </div>
        @endif
        <div class="freeword_area">
            <h4 class="p-tt-s p-tt-s-4 border_none free_word"><strong>フリーワード検索</strong></h4>
            <input type="text" placeholder="店舗名・商品名・スイーツ種類" class="h-input h-input-freeword" name="keyword" value="{{ $keywordShop }}">
        </div>
        <div class="area-footer showModal-sp">
            <button type="submit" class="btn btn-default btn-greend checkStartEndTime">絞り込み検索</button>
        </div>
        <div class="top_back">
            <a href="{{ url()->previous() }}">戻る</a>
        </div>
    </div>
    {{ Form::hidden('sort', request()->sort) }}
    @if (request()->has('cp_code'))
        <input type="hidden" name="cp_code" value="{{ request()->cp_code }}">
    @endif
    @if (request()->has('pos'))
        <input type="hidden" name="pos" value="{{ urlencode(request()->pos) }}">
    @endif
</form>
<script>
    var removeParams = function removeURLParameter(url, parameter) {
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {
            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);
            for (var i = pars.length; i-- > 0;) {
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                    pars[i]= "no_cp_coupon=1";
                }
            }
            return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
        }
        return url;
    };
    $(document).on('click', '.del-x-2', function(){
        var newUrl = removeParams(window.location.href, "cp_code");
        window.location = newUrl;
    });
</script>
