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
        <form id="submitForm" class="couponBox " action="{{ route('coupon.thanks') }}" method="POST">
          <div class="couponDetail {{ !$isLogin ? 'logout_Detail' : '' }}"><a href="#">
              <img src="{{ httpsUrl($coupon->coupon_image, 200) }}">
              <div class="withImg">
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
              </a></div>
              @if ($isLogin)
                  <input type="hidden" name="cp_code" value="{{ request()->cp_code }}">
                  <input type="hidden" name="get_count" value="{{ $usageFrequency }}">
                  <div class="couponBtn">
                      <a id="submitButton" href="javascript:void(0);">クーポンを取得する</a>
                  </div>
              @else
                  <div class="couponBtn logout_btn">
                      <a href="{!! $loginLink !!}">EPARK会員でログイン・会員登録(無料)</a>
                      <span>EPARK会員の方のみご利用いただけるクーポンです。</span>
                  </div>
              @endif
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
        </form>
    </div>
</div>
<script type="text/javascript">
$(function () {
    var imgs = $('img[src="/assets/pc/images/thum-def.png"]');
    $.each(imgs, function(index, val) {
        $(val).attr('src', '');
        $(val).css('opacity', '0');
    });
    $('#submitForm').one('submit', function () {
        $('#submitButton').prop('disabled', true);
    });
    $('#submitButton').click(function () {
        $('#submitForm').submit();
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
