@php
    $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
@endphp
@php
    $productName = isset($item->item->product_name) ? $item->item->product_name : '';
    $shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
    $title = $productName.$shopName.'｜EPARKスイーツガイド';
    $phoneNumber = '';
    if( isset($shop->item->tel_no) && !empty($shop->item->tel_no)) {
      $phoneNumber = $shop->item->tel_no;
    }
@endphp
@if ($shop->item->contract_tp != '1')
<div class="fix_fmenu" style="display: none;">
    <ul class="fmenuList">
      @if(!empty($shop->item->ppc_data) || !empty($productReservable))
          @if(!empty($shop->item->ppc_data))
              @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
                  @if (!empty($shop->item->ppc_data->$currentSiteCode))
                      <li class="fmenu_tel @if(empty($productReservable))  @endif"><a href="javascript:void(#dialog);" name="modal"><span>無料</span><span class="tel_bg">電話予約</span></a></li>
                  @endif
              @endif
          @endif
          @if ($current_route_name == 'shop.index')
          <li class="fmenu_share"><a href="javascript:void(0)" class="moreDetail" data-toggle="modal" data-target="#shopDetail"><span>友だちへ送る</span><span class="share_bg">シェア</span></a></li>
          @endif
          @if(!empty($productReservable))
              <li class="fmenu_net @if(empty($shop->item->ppc_data) && !array_key_exists($currentSiteCode, $shop->item->ppc_data) && empty($shop->item->ppc_data->$currentSiteCode))  @endif"><a href="{{ route("shop.menu", $shopId) }}"><span>24時間受付</span><span class="net_bg">ネットで予約</span></a></li>
          @endif
      @endif
    </ul>
</div>
<!-- Modal -->
<div class="modal fade" id="shopDetail" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-social" data-dismiss="modal"></button>
        <h3 class="modal-title text-center">店舗情報</h3>
      </div>
      <div class="div-share product-social modal-body">
        <div class="text-left">
          <p>
            {{ $shop->item->facility_name }}
          </p>
          <p>
            {{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}
          </p>
          <p class="current-url">
            {{ Request::fullUrl() }}
          </p>
          @if(!empty($shop->item->tel_no))
          <div>{{ $shop->item->tel_no }}</div>
          @else

          @endif
        </div>
        <ul class="ul-share clearfix">
          <li><a href="http://line.me/R/msg/text/?{{ $shop->item->facility_name . ' | EPARKスイーツガイド' }}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-line.png" alt=""></a></li>
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-facebook.png" alt=""></a></li>
          <li><a href="https://twitter.com/intent/tweet?text={{$title}}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-twitter.png" alt=""></a></li>
          <li><a href="mailto:?subject={{ $shop->item->facility_name }}&body={{ $shop->item->facility_name . ' | EPARKスイーツガイド ' . Request::fullUrl() }}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}"><img src="/assets/mobile/images/icon-mail.png" alt=""></a></li>
        </ul>
      </div>
    </div>

  </div>
</div>
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.10";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<script>
$(function(){
    $('.fmenu_tel').on('click',function(){
        $('body').append('<div id="dialog"><div class="tel_out"><a class="close">×</a><div class="tel_ppc"><div class="tel_reserve"><a href="tel:{{ !empty($shop->item->ppc_data->$currentSiteCode) ? $shop->item->ppc_data->$currentSiteCode : '' }}">予約</a></div><p>ケーキ・スイーツのご予約</p></div><div class="tel_info"><div class="tel_inquiry"><a href="tel:{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}">お問い合わせ</a></div><p>キャンセル、場所確認など</p></div><div class="tel_attention"><p>※予約のみ無料通話となります。お問い合わせは、通話料がかかります。</p><p>※キャンセルの場合も必ずご連絡をお願いします。</p><p>※当社及びEPARK利用施設は、発信された電話番号を、EPARKスイーツガイド利用規約第3条（個人情報について）に定める目的で利用できるものとします。</p><p class="unmatched">※電話予約の場合は通常価格となります</p></div></div></div>');
        $('body').append('<div id="mask"></div>');
        $('.close').on('click',function(){
            $('#dialog,#mask').remove();
        });
    });
});
</script>
<script>
  $(document).ready(function(){
    var countLi = $('.fix_fmenu > ul > li').size();

    if (countLi == 1) {
      $('.fix_fmenu > ul > li').addClass('oneSize');
    }
    else if (countLi == 2) {
      $('.fix_fmenu > ul > li').addClass('twoLi');
    }
  });
</script>
<script>
// ページの読み込みが完了してから実行
$(function() {
    // スクロール途中から表示したいメニューバーを指定
    var navBox = $(".fix_fmenu");

    // メニューバーは初期状態では消しておく
    navBox.hide();

    // 表示を開始するスクロール量を設定(px)
    var TargetPos = 80;

    // スクロールされた際に実行
    $(window).scroll( function() {
    // 現在のスクロール位置を取得
    var ScrollPos = $(window).scrollTop();
        // 現在のスクロール位置と、目的のスクロール位置を比較
        if( ScrollPos > TargetPos ) {
            // 表示(フェイドイン)
            navBox.fadeIn();
        }
        else {
            // 非表示(フェイドアウト)
            navBox.fadeOut();
        }
    });
});
</script>
@endif
