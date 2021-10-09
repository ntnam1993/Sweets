@php
$image = '';
$description = '';
@endphp
@for($i=1; $i<=10; $i++)
    @php
        $product_image = "product_image$i";
        $product_description = "product_description$i";
        if (!empty($item->item->$product_image) && empty($image)) {
            $image = $item->item->$product_image;
        }
        if (!empty($item->item->$product_description) && empty($description)) {
            $description = $item->item->$product_description;
        }
        if (!empty($image) && !empty($description)) break;
    @endphp
@endfor
@php
    $productName = isset($item->item->product_name) ? $item->item->product_name : '';
    $shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
    $title = $productName.' ('.$shopName.')'.'｜EPARKスイーツガイド';
@endphp
@extends('layouts.mobile.product-detail', ['seoTitle' => $item->item->product_name . ' | EPARKスイーツガイド', 'seoDescription' => $description, 'seoImage' => $image])
@section('title', $productName.' ('.$shopName.')'.'│FLO PRESTIGE PARIS（フロ プレステージュ パリ）')
@section('description', $productName.' ('.$shopName.')'.'の商品詳細ページです。FLO（フロ プレステージュ）では、店内キッチンから生まれる、出来立て・手作り商品のケーキ、タルト、焼き菓子、デリカ(惣菜)をフレンチ・テイストでご提供しています。ギフトやお誕生日、記念日等のアニバーサリーにもご利用ください。')
@section('body.classes', 'sp-product flo-page-sp drawer drawer--right drawer-close')
@section('container-class', 'sp-container clearfix css-new product-detail')
@section('content')
<h1 class="item-product-name">{{ $productName }}</h1>
@php $ogImage = !empty($item->item->product_image1) ? httpsUrl($item->item->product_image1, 675) : ""; @endphp
<ul class="product-slide" id="productMainSlide">
    @for($i = 0; $i < 10; $i++)
    @php
        $product_image = "product_image".($i + 1);
    @endphp
    @if ($item->item->$product_image != '')
    <li class="fix-image-slider"><img src="{{ httpsUrl($item->item->$product_image, 675) }}"></li>
    @endif
    @endfor
  </ul>
  <ul class="banner_slider" id="productSlideThumbs">
    @for($i = 0; $i < 10; $i++)
    @php
        $product_image = "product_image".($i + 1);
    @endphp
    @if ($item->item->$product_image != '')
    <li><img src="{{ httpsUrl($item->item->$product_image, 185) }}" style="display: none"></li>
    @endif
    @endfor
  </ul>
  <div class="product-comment shop-contents-unit">
    @php
        $catchCopy = $item->item->catch_copy;
        $productDescription1= $item->item->product_description1;
        $catchCopyAndProductDescription1 = $catchCopy.$productDescription1;
        $first150 = mb_substr($catchCopyAndProductDescription1, 0, 150);
        $remain = mb_substr($catchCopyAndProductDescription1, 150);
    @endphp
    @if (!empty($item->item->product_description1))
        <p>{!! $item->item->product_description1 !!}</p>
    @endif
    @if (!empty($item->item->product_description2))
        <p>{!! $item->item->product_description2 !!}</p>
    @endif
  </div>
  @if(!empty($parentAndChildProducts))
  <div class="div-price-by-size">
  @foreach($parentAndChildProducts as $productChildSize => $productChild)
    @php
        $shopDiscount = !empty($productChild['shop_discount']) ? ($productChild['shop_discount']) : 0;
        $portalDiscount = !empty($productChild['portal_discount']) ? ($productChild['portal_discount']) : 0;
        $productPrice = !empty($productChild['product_price']) ? ($productChild['product_price']) : 0;
        $check = $productPrice - $shopDiscount - $portalDiscount;
        if(($productPrice > 0) && ($check > 0 )){
          $sumPrice = "true";
          $netPrice = $check;
        }else {
          $sumPrice = "false";
          $netPrice = 0;
        }
    @endphp

      <div class="div-item-price-by-size clearfix class-product-id" data-product-id="{{ $productChild['product_id'] }}" data-product-price="{{ $productChild['product_price'] }}" data-sum-price="{{ $sumPrice }}">
        <div class="getDay">
            <strong class="" id="product-{{ $productChild['product_id'] }}"></strong>
            <strong class="slash-2-{{ $productChild['product_id'] }}"></strong>
            <strong class="slash-{{ $productChild['product_id'] }}"></strong>
        </div>
        <div class="size size_import">
            <p class="">
                <strong>{{ convertCakeSize($productChild['product_size']) }}サイズ</strong><strong>{{ productChildSizeText($productChild['product_size']) }}</strong>
            </p>
        </div>
        <div class="price-discount">
          <div class="pull-left">
              @if (!empty($productPrice))
                  <p class="price_align_txt">通常価格</p>
                  <p class="price ma-bot-10px price_align {{ ($shopDiscount + $portalDiscount != 0) ? 'price_discount' : 'left-align' }}">{{ numberFormat($productChild['product_price']) . "円(税込)" }}</p>
              @endif
          </div>
          <div class="pull-right receive">
              @if ($shopDiscount + $portalDiscount != 0 && !empty($productChild['product_price']))
                  <div class="net_price"><div>ネット予約価格</div>{{ numberFormat($netPrice) . "円(税込)" }}</div>
              @else
                  <div class="net_price none"></div>
              @endif
          </div>
        </div>
        <div class="gr-button">
          <div class="class-product-id-{{ $productChild['product_id'] }}"></div>
          <div class="class-product-cart-id-{{ $productChild['product_id'] }}"></div>
        </div>

      </div>
  @endforeach
  </div>
  @endif
  <div class="shop-info">
    @php
      $stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
      $train_line = isset($shop->item->train_line1) ? $shop->item->train_line1 : '';
      $exit_station = isset($shop->item->exit_station1) ? $shop->item->exit_station1 : '';
      $means = isset($shop->item->means1) ? $shop->item->means1 : '';
      $time_required = isset($shop->item->time_required1) ? $shop->item->time_required1 : '';
      $flo_tag = isset($shop->item->epark_payment_use_flag) ? $shop->item->epark_payment_use_flag : '';
    @endphp
    <p class="shop-facility-name">{{ $shop->item->facility_name }}</p>
    @if($flo_tag == 1)
    <p class="flo-tag">事前決済OK</p>
    @elseif($flo_tag == 2)
    <p class="flo-tag">カード決済のみ</p>
    @else
    @endif
  @php
      if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
          $addr_latitude = 35.709409;
          $addr_longitude = 139.724121;
      } else {
          $addr_latitude = $shop->item->addr_latitude;
          $addr_longitude = $shop->item->addr_longitude;
      }
  @endphp
  <p class="text-left">住所: {{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}<br>
    <span>
      <span>最寄駅: </span>
      <span>{{ $train_line.' '.$stationName.' '.$exit_station.' '.$means.' '.$time_required }}分</span>
    </span><br>
    @if(!empty($shop->worktime()))
    営業時間: <span>@foreach($shop->worktime() as $worktime)
    @if($loop->first)
    <span>{{ $worktime["time"] }}</span>
    @else
    <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
    @endif
    @endforeach</span>
    @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
    <span>定休日: </span>
    @foreach($shop->time_off() as $timeoff)
    <span>{{$timeoff}}</span>
    @endforeach
    @endif
    @endif
  </p>
  <p class="map-btn"> <a href="{{ route("floprestige.shop.map", $shopId) }}"><span class="map2">地図を見る</span></a> </p>
  </div>
  <div class="shop_notice">
  		<p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
      @if (!empty($item->item->product_description3))
      <p class="text-left">
          {!! $item->item->product_description3 !!}
      </p>
      @endif
  </div>
    @include('floprestige.mobile.partials.shop-sp',compact('shopName','get4ProductReservable'))
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $.ajax({
            url: '{{ route("product.other_item_of_shop") }}',
            type: 'GET',
            data: {shopId: '{{ $shopId }}', productId: '{{ $productId }}'},
          })
          .done(function(res) {
            $('.slide-item-other-of-shop').append(res);
            $('.item-scroll-det .item-thumb-txt').autoHeight();
          });
        });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        // check child product reserved or not
      var arrProductIds = $('.class-product-id');
        $.each(arrProductIds, function(index, val) {
            var product_id = $(val).attr('data-product-id');
            var product_price = $(val).attr('data-product-price');
            var product_sum_price = $(val).attr('data-sum-price');
            var site_code = '{{ env('SITE_CODE_FLO') }}';
            $.ajax({
                url: '{{ route("product.check_receiptdate") }}',
                type: 'GET',
                dataType: 'json',
                data: {product_id: product_id, product_count: 1},
            })
            .done(function(res) {
                if(res.reservable) {
                    var link = "/sp/sweetsstep/reserveinput/";
                    var linkCart = "/sp/sweetsstep/cart/";
                    if(product_price != "" && product_price != "0" && product_sum_price == "true"){
                        $('.class-product-id-'+product_id).append('<a class="reservation-btn" href="'+link+'init?product_id='+product_id+'&site_code='+site_code+'"><span>今すぐネットで予約</span></a>');
                        $('.class-product-cart-id-'+product_id).append('<a class="reservation-btn btn-cart" href="'+linkCart+'index?product_id='+product_id+'&site_code='+site_code+'"><span>カートに入れる</span></a>');
                    }
                    $('.slash-'+product_id).html("受け取り可");
                    $('.slash-2-'+product_id).html("〜");
                    $('#product-'+product_id).html(res.firstReceiptDate);
                }
            });

        });
        $(".net_price.none").parents('.price-discount').addClass('noneAfter');
    });

    $(function () {
      $('.more a').on('click', function (e) {
        var $more_contents = $(this).parent().prev();
        if ($more_contents.length && $more_contents.hasClass('more-contents')) {
          e.preventDefault()
          if ($more_contents.is(':hidden')) { // open
            $(this).text('閉じる').addClass('open');
            $more_contents.slideDown();
          } else { // close
            $(this).text('続きを読む').removeClass('open');
            $more_contents.slideUp();
          }
        }
      });

        $('#productMainSlide').slick({
            autoplay: true,
            asNavFor: '#productSlideThumbs',
            adaptiveHeight: true,
            mobileFirst: true
        });
        $('#productSlideThumbs').slick({
            dots: true, // スライダー下部に表示される、ドット状のページネーション
            infinite: true, // 無限ループ
            speed: 300, // 切り替わりのスピード
            autoplay: true, // オートプレイ
            autoplaySpeed: 4000, //オートプレイスピード4秒
            pauseOnFocus: false,
            asNavFor: '#productMainSlide',
        });
    });
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
            console.log(res);
            if(res.status == "0" && res.favorite == "1"){
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_02_off').addClass('okiniiri_btn_sp_02').attr('data-liked',"1").find('img').attr('src','/assets/mobile/images/heart.png');
                $('.span-text-favorite').html('お気に入り追加済');
            }else{
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_02').addClass('okiniiri_btn_sp_02_off').attr('data-liked',"0").find('img').attr('src','/assets/mobile/images/heart_02.png');
                $('.span-text-favorite').html('お気に入り追加');
            }
        });
    }
</script>
<script>
$(document).ready(function() {
$('.drawer').drawer();
});
</script>
<script>
  $(function() {
      var menu = $(".bottom_look");
      $(window).scroll(function () {
          if ($(this).scrollTop() > 10) {
              menu.fadeIn();
          } else {
              menu.fadeOut();
          }
      });
  });
</script>
@stop
