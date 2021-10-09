<div id="header-f">
    <div class="fixheader">
        <div class="modal_change2">
            <div class="shop_contents active">お店を探す</div>
            <div class="cake_contents"><a href="{{ route('product.index.all', $params) }}">ケーキを探す</a></div>
        </div>
        <div class="shoplist-ctrl">
          <div class="crtl-title shop">
              ケーキ屋・スイーツ店 一覧
          </div>
          <ul>
            @if(!empty($regionId))
                @php
                $paramsSearch = ['parent_region_id' => $parentRegionId, 'region_id' => $regionId, 'sort' => request()->sort,'keyword'=> request()->keyword, 'genre_id' => request()->genre_id , 'cp_code' => request()->cp_code];
                @endphp
            @elseif(!empty($stationId))
                @php
                $paramsSearch = ['station_id' => $stationId, 'prefecture_id' => $stationProvCode, 'rail_line_id' => $stationRailLineId, 'sort' => request()->sort,'keyword'=>request()->keyword, 'genre_id' => request()->genre_id , 'cp_code' => request()->cp_code];
                @endphp
            @else
                @php
                $paramsSearch = ['sort' => request()->sort, 'keyword'=> request()->keyword, 'genre_id' => request()->genre_id , 'cp_code' => request()->cp_code];
                @endphp
            @endif
            @php
            if(request()->has('epark_payment_use_flag')){
                $paramsSearch = array_merge($paramsSearch, ['epark_payment_use_flag' => request()->epark_payment_use_flag]);
            }
            if(request()->has('pos')){
                $paramsSearch['pos'] = urldecode(request()->pos);
            }
            if (request()->has('map')) {
                $paramsSearch['map'] = 1;
            }
            if (request()->has('current_location')) {
                $paramsSearch['current_location'] = 1;
            }
            if (request()->has('reservation_flag')) {
                $paramsSearch['reservation_flag'] = 1;
            }
            $sortType = '並び替え';

            if ($sort == 0) {
                $sortType = '新着順';
            } elseif ($sort == 3) {
                $sortType = 'おすすめ順';
            } elseif ($sort == 2) {
                $sortType = '口コミ順';
            }
            $paramsSearch['tab_search'] = 'shop';
            @endphp
            <li><a href="{{ route('search.index', $paramsSearch)}}" class="icn-search" style="cursor: pointer;">条件絞込み</a></li>
            <li>
                <a href="javascript:void(0)" class="icn-sort get-type-menu">{{ $sortType }}</a>
                <ul class="ul-sp-sort-n">
                    <li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->fullUrlWithQuery($params) }}">新着順</a></li>
                    <li><a @if($sort == 3) class="active" @endif @php $params['sort'] = 3 @endphp href="{{ request()->fullUrlWithQuery($params) }}">おすすめ順</a></li>
                    <li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->fullUrlWithQuery($params) }}">口コミ順</a></li>
                </ul>
            </li>
            @php
                $params = request()->all();
                if(!request()->has('map')){
                    $params['map'] = 1;
                }else{
                    unset($params['map']);
                }
                $query = http_build_query($params);
            @endphp
            <li>
                @if (request()->has('map'))
                    @php
                        $queryParams = request()->except('map');
                    @endphp
                    <a href="{{ request()->url() . '?' . http_build_query($queryParams) }}" class="icn-list">リスト表示</a>
                @else
                    <a href="{{ request()->url().'?'.$query }}" class="icn-map">地図表示</a></li>
                @endif
          </ul>
        </div>
    </div>
    @if(empty(request()->map))
        <div class="checkbox01">
            <label>
                <input type="checkbox" {{ !empty(request()-> epark_payment_use_flag) ? 'checked' : '' }} name="epark_payment_use_flag" class="checkbox01-input">
                <span class="checkbox01-parts">ポイント・キャシュポ利用可能</span>
            </label>
            <label>
                <input {{ !empty(request()->reservation_flag) ? 'checked' : '' }} class="checkbox01-input" name="reservation_flag" type="checkbox" value="1">
                <span class="checkbox01-parts">ネット予約可能</span>
            </label>
        </div>
    @endif

</div>
<script>
    $(document).on('click', '.checkbox01-input', function(){
        var newUrl = window.location.href;
        var name   = $(this).attr('name');
        if ($(this).is(':checked')) {
          if(newUrl.indexOf('?') != -1){
              newUrl = newUrl + '&'+name+'=1';
          } else {
            newUrl = newUrl+'?'+name+'=1';
          }
        } else {
            if (newUrl.indexOf("?"+name+"=1") !== false && newUrl.indexOf("?"+name+"=1") >= 0) {
                if (newUrl.indexOf(name+"=1"+"&") !== false && newUrl.indexOf(name+"=1"+"&") >= 0) {
                    newUrl = newUrl.replace(name+"=1"+"&", "");
                }else{
                    newUrl = newUrl.replace("?"+name+"=1", "");
                }
            }else{
                newUrl = newUrl.replace("&"+name+"=1", "");
            }
        }

        //ok
        window.location = newUrl;
    });
</script>
