@extends('layouts.family')
@section('title', 'EPARKスイーツガイド|クーポン')
@section('description', '')
@section('body.classes','coupon-PC')
@section('content')
<div class="contents">
    <div class="kv_area kv_couponP">
    </div>
    <div class="coupon_area">
        <h2>クーポン詳細</h2>
        <div class="couponBox coupon_box">
            <div class="couponDetail"><a href="#">
                <img src="{{ httpsUrl($coupon->coupon_image, 675) }}">
                <div class="withImg coupon_detail">
                    <div class="coupon_get">
                      @if (!empty($coupon_obtained))
                          <p>このクーポンは取得済です</p>
                      @else
                          <p>クーポンを取得しました</p>
                      @endif
                    </div>
                    <h3>{{ $coupon->coupon_name }}</h3>
                    <dl class="cpn_publish">
                        <dt>取得可能期間</dt>
                        <dd>{{ $coupon->coupon_carrying_period_start }}～{{ $coupon->coupon_carrying_period_end }}</dd>
                    </dl>
                    <dl class="cpn_publish">
                        <dt>利用可能期間</dt>
                        <dd>{{ $coupon->coupon_validity_period_start }}～{{ $coupon->coupon_validity_period_end }}</dd>
                    </dl>
                    @if(isset($coupon->coupon_type) && $coupon->coupon_type != 2)
                    <dl class="cpn_publish">
                        <dt>受け取り期間</dt>
                        <dd>{{ $coupon->receiptable_period_start }}～{{ $coupon->receiptable_period_end }}</dd>
                    </dl>
                    @endif
                    <dl class="cpn_publish">
                        <dt>対象店舗</dt>
                        <dd>{{ objectCodes($coupon->object_code) }}</dd>
                    </dl>
                </div>
                </a>
            </div>
            <div class="couponBtn">
                <a href="{{ $redirectUrl }}">クーポンを利用する</a>
            </div>
            <div class="coupon_syosai accordionbox">
                <dl class="accordionlist">
                    <dt class="clearfix">
                        <div class="title">
                            <p>クーポン内容詳細</p>
                        </div>
                        <p class="accordion_icon after_ver"><span></span><span></span></p>
                    </dt>
                    <dd><hr>{!! nl2br($coupon->coupon_contents) !!}</dd>
                </dl>
            </div>
        </div>
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
@endsection
