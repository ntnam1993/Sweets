@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? '地図｜'.$shop->item->page_title : '地図';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.index_child_2')
@section('body.classes', 'shop-index')
@section('title', $title)
@section('description', $description)
@section('content')
@section("container.class", "css-new")
<div class="pc-content">
    <ul class="t-path">
        <li class="t-path-list"><span><a href="{{ route('index') }}" style="color:inherit">EPARKスイーツガイド</a></span></li>
        @if(!empty($region))
            <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a></span></li>
            @if(!empty($subRegion))
                <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a></span></li>
            @endif
        @endif
        <li class="t-path-list"><span><a href="{{ route('shop.index', ['id' => $shopId]) }}" style="color:inherit">{{ $shop->item->facility_name }}</a></span></li>
        <li><span>地図</span></li>
    </ul>
    @include ("shop.partials.shop-info", compact("shopId", "shop"))
    @include ("partials.shop.list-tab", compact("shopId"))
    <div class="tab-content">
        <h2 class="no-BrdT">{{ $shop->item->facility_name }}のアクセスマップ</h2>
        <div class="iframe-kb4 map-canvas"></div>
        <table class="table-kb4 table-kb4-ch">
            <tbody>
                <tr>
                    <td>店舗名</td>
                    <td>
                    <ul class="table-list">
                        <li><span class="">{{ $shop->item->facility_name }}</span></li>
                    </ul>
                    </td>
                </tr>
                <tr>
                    <td>住所</td>
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
                    <td>最寄り駅</td>
                    <td>
                    @include ('partials.components.nearest-station', compact('shop'))
                    </td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td>
                    @if(!empty($shop->item->tel_no))
                        <div>{{ $shop->item->tel_no }}</div>
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>公式サイト</td>
                    <td>
                     @if(!empty($shop->item->site_url_pc))
                        <a href="{{ $shop->item->site_url_pc }}">{{ $shop->item->site_url_pc }}</a>
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>関連リンク</td>
                    <td>
                        <a href="{{ $shop->item->related_links_url1 }}">{{$shop->item->related_links_title1}}</a>
                        <a href="{{ $shop->item->related_links_url2 }}">{{$shop->item->related_links_title2}}</a>
                        <a href="{{ $shop->item->related_links_url3 }}">{{$shop->item->related_links_title3}}</a>
                        <a href="{{ $shop->item->related_links_url4 }}">{{$shop->item->related_links_title4}}</a>
                    </td>
                </tr>
                <tr>
                    <td>サービス</td>
                    @php $str = implode(' / ', $shop->item->compatible_service); @endphp
                    <td>
                    @if(!empty($shop->item->compatible_service))
                        <div>{{ $str }}</div>
                    @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @include('shop.partials.working-time')
        <div class="text-left">
        @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
        @foreach($shop->time_off() as $timeoff)
        <p class="supplement mar-bot-20">【定休日】{{$timeoff}}</p>
        @endforeach
        @endif
        <p class="li-inline-bl mar-bot-10">{!! nl2br($shop->item->calendar_comment) !!}</p>
        </div>
        <p class="supplement"></p>

    </div>
</div>
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
