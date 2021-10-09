<form action="{{ $urlFormProduct }}" method="GET" id="searchForm2">
    @if (request()->has('map') && request()->map == '1')
        <input type="hidden" name="map" value="1">
    @endif
    @if (request()->has('current_location') && request()->current_location == '1')
        <input type="hidden" name="current_location" value="1">
    @endif
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
                @if($regionName != $regionNameDefault)
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
            <input type="hidden" name="tab_search" value="product">
            <input type="hidden" name="remove_search_cookie" value="">
            @if($genreName != $genreNameDefault)
                <span class="span-x-2 jsDelGenre">×</span>
            @endif
        </div>

        <h3 class="pos-relat-search p-tt-s-3">こだわり条件検索</h3>
        <div class="select_area">
            <h4 class="p-tt-s p-tt-s-4 border_none money_title"><strong>予算から選ぶ</strong></h4>
            <div class="cont-d-ch pad-10-6">
                <div class="reservation-form-name">
                    <div class="radio_btn time w-auto mar-14 pad-left-0 flex-row-wrap" style="padding-left: 0 !important;">
                        <input type="radio" name="price" value="" id="price_null" {{ empty(request()->price) ? "checked" : "" }}>
                        <input type="radio" name="price" value="price500" id="morning" {{ Request::query('price') == 'price500' ? 'checked' : '' }}>
                        <input type="radio" name="price" value="price500_1000" id="tw_o_clock" {{ Request::query('price') == 'price500_1000' ? 'checked' : '' }}>
                        <input type="radio" name="price" value="price1000_2000" id="fo_o_clock" {{ Request::query('price') == 'price1000_2000' ? 'checked' : '' }}>
                        <input type="radio" name="price" value="price2000_3000" id="fi_o_clock"{{ Request::query('price') == 'price2000_3000' ? 'checked' : '' }}>
                        <input type="radio" name="price" value="price3000" id="anytime" {{ Request::query('price') == 'price3000' ? 'checked' : '' }}>
                        <label for="price_null" class="pull-left">指定なし</label>
                        <label for="morning" class="pull-left">1円〜500円</label>
                        <label for="tw_o_clock" class="pull-left">1円〜1,000円</label>
                        <label for="fo_o_clock" class="pull-left">1円〜2,000円</label>
                        <label for="fi_o_clock" class="pull-left">1円〜3,000円</label>
                        <label for="anytime" class="pull-left">3,000円〜</label>
                    </div>
                </div>
            </div>
            <h4 class="p-tt-s p-tt-s-4 border_none size_title"><strong>サイズから選ぶ</strong></h4>
            <div class="cont-d-ch pad-10-6">
                <div class="reservation-form-name">
                    <div class="time w-auto mar-14 pad-left-0 flex-row-wrap" style="padding-left: 0 !important;">
                        <input type="checkbox" name="size3" id="size3" {{ Request::query('size3') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size4" id="size4" {{ Request::query('size4') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size5" id="size5" {{ Request::query('size5') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size6" id="size6" {{ Request::query('size6') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size7" id="size7" {{ Request::query('size7') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size8" id="size8" {{ Request::query('size8') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size9" id="size9" {{ Request::query('size9') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size10" id="size10" {{ Request::query('size10') == 'on' ? 'checked' : '' }}>
                        <input type="checkbox" name="size11" id="size11" {{ Request::query('size11') == 'on' ? 'checked' : '' }}>
                        <label for="size3" class="w-44">3号（1～2名）</label>
                        <label for="size4" class="w-44">4号（2～4名）</label>
                        <label for="size5" class="w-44">5号（4～6名）</label>
                        <label for="size6" class="w-44">6号（6～8名）</label>
                        <label for="size7" class="w-44">7号（8～10名）</label>
                        <label for="size8" class="w-44">8号（10～12名）</label>
                        <label for="size9" class="w-44">9号（12～16名）</label>
                        <label for="size10" class="w-44">10号（16～20名）</label>
                        <label for="size11" class="w-44">11号〜（20名～）</label>
                    </div>
                </div>
            </div>
        </div>
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

    </div>
    {{ Form::hidden('sort', request()->sort) }}
    @if (request()->has('pos'))
        <input type="hidden" name="pos" value="{{ urlencode(request()->pos) }}">
    @endif

    <div class="area-footer showModal-sp">
        <button type="submit" class="btn btn-default btn-greend checkStartEndTime">絞り込み検索</button>
    </div>
    <div class="top_back">
        <a href="{{ url()->previous() }}">戻る</a>
    </div>
</form>
