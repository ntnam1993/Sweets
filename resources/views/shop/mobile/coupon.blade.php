@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? 'クーポン｜'.$shop->item->page_title : 'クーポン';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.mobile.shop')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-coupon shop-index')
@section('content')
@include('shop.mobile.partials.list-tab')
@include('shop.mobile.partials.shop-summary')
<div class="coupon_content">
    @if (empty($coupons))
        <p style="margin-top:20px;">利用可能なクーポンがありません</p>
    @else
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
                            <p class="caution">※EPARK決済でのお支払い時のみご利用いただけます。</p>
                        @endif
                    </div>
                </a>
            </div>
            <div class="coupon_syosai accordionbox">
                <dl class="accordionlist">
                    <dt class="clearfix">
                        <div class="title">
                            <p>クーポン内容詳細</p>
                        </div>
                        <p class="accordion_icon"><span></span><span></span></p>
                    </dt>
                    <dd><hr>
                      {!! nl2br($coupon->coupon_contents) !!}
                    </dd>
                </dl>
            </div>
            <div class="couponBtn" style=" width:100%;">
                <a href="{{ route('coupon.index', ['cp_code' => $coupon->cp_code]) }}">クーポンを取得する</a>
            </div>
        </div>
        @endforeach
    @endif
</div>
<script>
$(function(){
    var imgs = $('img[src=""]');
    $.each(imgs, function(index, val) {
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
