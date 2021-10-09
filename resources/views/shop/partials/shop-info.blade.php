<div style="min-height: 170px">
<div class="shop-name">
    @if($current_route_name == 'shop.index')
    <p class="okiniiri"><a class="okiniiri_btn_off data-shop-id-{{ $shopId }}" href="javascript:void(0)"><img style="margin-right:5px;margin-bottom:3px;" src="/assets/pc/images/heart_02_off.png"><span class="span-text-favorite">お気に入り追加</span></a></p>
    @endif
    <h1 class="name"><a href="{{ route("shop.index", $shopId) }}">{{ $shop->item->facility_name }}</a></h1>
    @include('layouts.icon-box', ['epark_payment_use_flag' => $shop->item->epark_payment_use_flag])
</div>
@php
    $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
@endphp
<ul class="reserveList {{ !empty($shop->item->contract_tp) && $shop->item->contract_tp == '1' ? 'request' : '' }}">
    @if (!empty($shop->item->contract_tp) && $shop->item->contract_tp == '1')
        <li class="request_btn {{  $userRequested ? '' : 'settled' }}">
            <a>掲載リクエスト<span class="count">{{ $requestCount < 1000 ? str_pad($requestCount, 3, '0', STR_PAD_LEFT) : $requestCount }}</span></a>
            <p>このお店の情報充実をご希望の場合は、掲載リクエストボタンをクリックしてください。掲載のご要望として承ります。</p>
        </li>
    @else
        @if (!empty($productReservable))
            <li class="reserve_net"><a href="{{ route("shop.menu", $shopId) }}"><span>24時間受付</span>ネット予約</a></li>
        @endif
        @if(!empty($shop->item->ppc_data))
            @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
                @if (!empty($shop->item->ppc_data->$currentSiteCode))
                    <li class="reserve_tel"><p><span>無料</span>{{ $shop->item->ppc_data->$currentSiteCode }}</p></li>
                    <li class="reserve_notice">
                    <a>電話受付(予約)時の注意
                        <span class="reserve_popup">
                            <p>電話受付(予約)時の注意</p>
                            <p>※無料通話となります。</p>
                            <p>※キャンセルの場合も必ずご連絡をお願いします。</p>
                            <p>※当社及びEPARK利用施設は、発信された電話番号を、EPARKスイーツガイド利用規約第3条（個人情報について）に定める目的で利用できるものとします。</p>
                            <p class="unmatched">※電話予約の場合は通常価格となります</p>
                        </span>
                    </a>
                    </li>
                @endif
            @endif
        @endif
    @endif
</ul>
<ul class="pList-icon" style="margin-bottom: 10px">
    @php
        if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
            $addr_latitude = 35.709409;
            $addr_longitude = 139.724121;
        } else {
            $addr_latitude = $shop->item->addr_latitude;
            $addr_longitude = $shop->item->addr_longitude;
        }
    @endphp
    <li>
        <span>住所:</span>
        <span>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</span>
        (<a href="{{ route("shop.map", $shopId) }}">地図</a>)
    </li>
</ul>
<ul class="pList-icon" style="width:680px;">
    <li>
        {!! showNearestStation($shop->item) !!}
    </li>
    @if(!empty($shop->worktime()))
    <li>
        <span>営業時間: </span>
        @foreach($shop->worktime() as $worktime)
        @if($loop->first)
        <span>{{ $worktime["time"] }}</span>
        @else
        <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
        @endif
        @endforeach
    </li>
    @endif
    @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
    <li class="li-inline-bl">
        <span>定休日: </span>
        @foreach($shop->time_off() as $timeoff)
        <span>{{$timeoff}}</span>
        @endforeach
    </li>
    @endif
    <li class="li-inline-bl">{!! nl2br($shop->item->calendar_comment) !!}</li>
</ul>
<div class="pList-icon">
    <!-- rate28 -->
    @if($shop->item->comment_evaluate_total != "")
    <div class="rate-group rate-top28">
        <div class="rateit" style="width: 140px; height: 22px;"
            data-rateit-readonly="true"
            data-rateit-resetable="false"
            data-rateit-starwidth="28"
            data-rateit-starheight="22"
            data-rateit-min="0"
            data-rateit-max="5"
            data-rateit-value="{{ $shop->item->comment_evaluate_total }}"
            data-rateit-step="0.1">
        </div>
        <a class="rate-np" href="{{ route("shop.comments", $shopId) }}">{{ numberFormat($shop->item->comment_evaluate_total, 1) }}（{{ $shop->item->comment_num }}件）</a>
    </div>
    @endif
    <!-- rate28 -->
</div>
</div>
<script type="text/javascript">
    $(function () {
        var requesting = $('.request_btn').hasClass('settled') ? false : true;
        $('.request_btn a').on('click', function() {
            if (!requesting) {
                requesting = true;
                $.ajax({
                    url: "{{ route('shop.requests', $shopId) }}",
                    method: "POST",
                }).done(function (res) {
                    $('.request_btn').toggleClass('settled', res.user_requested == false);
                    $('.request_btn .count').html(res.request_count_pad);
                    requesting = true;
                });
            }
        });

    });
    @if ($current_route_name == 'shop.index')
        if ('{{ $isLogin }}') {
            getInfoFavorite({{$shopId}});
        }

        function getInfoFavorite(shop_id, is_liked)
        {
            var data = {
                catalog_id: shop_id,
            }
            if(is_liked != undefined){
                if(is_liked == "0"){
                    data.update_code = "1";
                }else{
                    data.update_code = "2";
                }
            }
            $.ajax({
                url: '/favorite/operation/index',
                type: 'GET',
                dataType: 'JSON',
                data: data,
                shop_id: shop_id
            })
            .done(function(res) {
                if(res.status == "0" && res.favorite == "1"){
                    $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_off').addClass('okiniiri_btn').attr('data-liked',"1").find('img').attr('src','/assets/pc/images/heart_02_on.png');
                    $('.span-text-favorite').html('お気に入り追加済');
                }else{
                    $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn').addClass('okiniiri_btn_off').attr('data-liked',"0").find('img').attr('src','/assets/pc/images/heart_02_off.png');
                    $('.span-text-favorite').html('お気に入り追加');
                }
            });
        }
    @endif
</script>
