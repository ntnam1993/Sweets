@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? 'クーポン｜'.$shop->item->page_title : 'クーポン';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.index_child_2')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@section("container.class", "css-new shop-coupon")
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
        <li><span>クーポン</span></li>
    </ul>
    @include ("shop.partials.shop-info", compact("shopId", "shop"))
    @include ("partials.shop.list-tab", compact("shopId"))
    <div class="tab-content">
        @if (empty($coupons))
            <p style="text-align: left; margin-bottom: 15px">利用可能なクーポンがありません</p>
        @else
        <div class="coupon_content">
            @foreach ($coupons as $coupon)
            <div class="couponBox">
                <div class="couponDetail">
                    <a href="{{ route('coupon.index', ['cp_code' => $coupon->cp_code]) }}">
                    <img src="{{ httpsUrl($coupon->coupon_image, 180) }}" alt="">
                        <div class="withImg">
                            <h3>{{ ($coupon->coupon_name) }}</h3>
                            <dl class="cpn_publish">
                                <dt>取得可能期間</dt>
                                <dd>{{ $coupon->coupon_carrying_period_start }}～{{ $coupon->coupon_carrying_period_end }}</dd>
                            </dl>
                            <dl class="cpn_publish">
                                <dt>利用可能期間</dt>
                                <dd>{{ $coupon->coupon_validity_period_start }}～{{ $coupon->coupon_validity_period_end }}</dd>
                            </dl>
                            <dl class="cpn_publish">
                                <dt>受け取り期間</dt>
                                <dd>{{ $coupon->receiptable_period_start }}～{{ $coupon->receiptable_period_end }}</dd>
                            </dl>
                            <dl class="cpn_publish">
                                <dt>対象店舗</dt>
                                <dd>{{ objectCodes($coupon->object_code) }}</dd>
                            </dl>
                            @if ($coupon->discount_type == '2' || $coupon->discount_type == '3')
                                <p class="kome_text">※EPARK決済でのお支払い時のみご利用いただけます。</p>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="couponBtn">
                    <a href="{{ route('coupon.index', ['cp_code' => $coupon->cp_code]) }}">クーポンを取得する</a>
                </div>
                <div class="coupon_syosai accordionbox">
                    <dl class="accordionlist">
                        <dt class="clearfix">
                            <div class="title">
                                <p>クーポン内容詳細</p>
                            </div>
                            <p class="accordion_icon"><span></span><span></span></p>
                        </dt>
                        <dd><hr>{!! nl2br($coupon->coupon_contents) !!}</dd>
                    </dl>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<script>
    $(function(){
        var imgs = $('img[src="/assets/pc/images/thum-def.png"]');
        $.each(imgs, function(index, val) {
            $(val).attr('src', '');
            $(val).css('opacity', '0');
        });
    });

    $(function(){
        $(".accordionbox dt").on("click", function() {
            $(this).next().slideToggle();
            // activeが存在する場合
            if ($(this).children(".accordion_icon").hasClass('active')) {
                // activeを削除
                $(this).children(".accordion_icon").removeClass('active');
            }
            else {
                // activeを追加
                $(this).children(".accordion_icon").addClass('active');
            }
        });
    });
</script>
@stop
