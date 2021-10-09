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
@section('title', $title)
@section('description', 'EPARKスイーツガイドの'.$productName.' ('.$shopName.')の商品詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,009件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！')
@section('container-class', 'css-new product-detail')
@section('content')
@include('shop.mobile.partials.list-tab')
<h1 class="item-product-name">{{subString($item->item->product_name, 38)}}</h1>
@include('layouts.icon-box', ['epark_payment_use_flag' => $item->item->epark_payment_use_flag])
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
    <p style="text-align: left;">{{ $item->item->catch_copy }}</p>
    @if (!empty($item->item->product_description1))
        <p class="description1">{!! $item->item->product_description1 !!}</p>
    @endif
    @if (!empty($item->item->product_description2))
        <p class="description2">{!! $item->item->product_description2 !!}</p>
    @endif
  </div>
  @if ($isLogin && ($cashpo > 0))
  <div class="cashpo_own">
    <div class="cashpo_point_box">
        <p class="cashpo_hoyu">保有キャシュポ</p>
        <p class="place_en">{{ number_format($cashpo) }}円</p>
    </div>
    <p class="bottom_text">
         {{$cashpoExpireDate}}するキャシュポがあります。
    </p>
  </div>
  @endif
    @if(!empty($parentAndChildProducts))
    <div class="div-price-by-size">
    @foreach($parentAndChildProducts as $productChildSize => $productChild)
      <div class="div-item-price-by-size clearfix class-product-id" data-product-id="{{ $productChild['product_id'] }}" data-product-price="{{ $productChild['product_price'] ? $productChild['product_price'] : 0 }}" data-json-cashpo-coupon="{{ $dataJsonCouponCashpo }}" data-cashpo="{{ $cashpo }}">
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
              @if (!empty($productChild['product_price']))
                  <p class="price_align_txt">通常価格</p>
                  <p class="price ma-bot-10px price_align price_discount">{{ numberFormat($productChild['product_price'])."円" }}<span>(税込)</span></p>
              @endif
          </div>
        </div>
        <div id="add-element-price-have-discount-{{$productChild['product_id']}}"></div>
        <div class="gr-button">
            <div class="class-product-id-{{ $productChild['product_id'] }}"></div>
            <div class="class-product-cart-id-{{ $productChild['product_id'] }}"></div>
        </div>
    </div>
    @endforeach
    </div>
    @endif
    @php
    $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
    @endphp
    @if(!empty($shop->item->ppc_data))
        @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
            @if(!empty($shop->item->ppc_data->$currentSiteCode))
                <div class="menuList">
                    <p>お電話からのご予約はこちら<br><strong class="unmatched">※電話でのご予約は通常価格となります</strong></p>
                    <p class="menu_tel"><a href="javascript:void(#dialog)"><span>無料</span>電話予約</a></p>
                </div>
            @endif
        @endif
    @endif
    @if (!empty($item->item->product_description3))
        <div class="shop-reservation">
            <p class="text-left">
                {!! $item->item->product_description3 !!}
            </p>
        </div>
    @endif
    @include('product.mobile.social')
    <div class="shop-info">
        <a class="info-wrap" href="{{ route('shop.index', $shopId) }}">
          <p class="shop-facility-name">{{ $shop->item->facility_name }}</p>
          <p class="text-left">
            住所：{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}<br>

            {!! showNearestStation($shop->item) !!}
            <br>
            営業時間：
            @foreach($shop->worktime() as $worktime)
            @if($loop->first)
            <span>{{ $worktime["time"] }}</span>
            @endif
            <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
            @endforeach
          </p>
          @if($shop->item->comment_evaluate_total != "")
          <div class="rate-group rate-top24 rate-top-r">
              <div class="rateit"
                    data-rateit-readonly="true"
                    data-rateit-resetable="false"
                    data-rateit-starwidth="24"
                    data-rateit-starheight="18"
                    data-rateit-min="0"
                    data-rateit-max="5"
                    data-rateit-value="{{ $shop->item->comment_evaluate_total }}"
                    data-rateit-step="0.1">
                </div>
              <span class="rate-np">{{ numberFormat($shop->item->comment_evaluate_total, 1) }} @if(!empty($shop->item->comment_num))({{ $shop->item->comment_num }}件)@endif</span>
          </div>
          @endif
        </a>
        <p class="okiniiri_sp_02"><a class="okiniiri_btn_sp_02_off data-shop-id-{{ $shopId }}" href="javascript:void(0)" data-liked="0"><img style="margin-right:5px;margin-bottom:3px;" src="/assets/mobile/images/heart_02.png"><span class="span-text-favorite">お気に入り追加</span></a></p>
        <p class="map-btn">
          <a href="{{ route('shop.map', $shopId) }}"><span class="map2">地図を見る</span></a>
        </p>
      </div>
    @include('shop.mobile.shop-sp',compact('shopName','get4ProductReservable'))
      <div class="shop-contents-unit">
        <h2>{{ $shop->item->facility_name }}{{ !empty($shop->item->facility_name_kana) ? '（'.$shop->item->facility_name_kana.'）' : '' }}の口コミ</h2>
        @if(!empty($comments->item_exist()))
        <a href="{!! $postReviewUrl !!}" class="post-button" rel="nofollow"><span>口コミ投稿</span></a>
        @endif
        <div class="list-shop product-review">
        @if(!empty($comments->item_exist()))
          <ul class="ul-new-fix-sp">
          @foreach($comments->items as $comment)
            <li>
              <a href="{{ route('shop.comment_detail', [$comment->target_id, $comment->comment_id]) }}">
                @if(!empty($comment->image))
                    <img class="pro" src="{{ httpsUrl($comment->image) }}">
                @else
                    <img class="pro" src="/assets/pc/images/thum-def.png" alt="">
                @endif
                <div class="list-shop-info">
                  <p class="list-shop-desc list-shop-desc-2">{{ subString($comment->content_title, 25) }}</p>
                  <p class="list-shop-date">{{ dateFormat($comment->comment_date, 'yeah') }}/{{ dateFormat($comment->comment_date, 'mounth') }}/{{ dateFormat($comment->comment_date, 'day') }}</p>
                  @if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                  @php
                      $bestPoints = (array) $comment->best_point_list;
                      $goodPoints = (array) $comment->good_point_list;

                      if (!empty($bestPoints)) {
                          $goodPoints = array_diff_key($goodPoints, $bestPoints);
                      }
                  @endphp
                      <ul class="listTab listTab-2 list-point">
                          <p class="p-yl" style="margin-top: 0;">良かった点</p>
                          @if (!empty($bestPoints))
                              @foreach($bestPoints as $point)
                                  <li class="best-point"><span>{{ $point->evaluation_name_short }}</span></li>
                              @endforeach
                          @endif
                          @if (!empty($goodPoints))
                              @foreach($goodPoints as $point)
                                  <li><span>{{ $point->evaluation_name_short }}</span></li>
                              @endforeach
                          @endif
                      </ul>
                  @endif
                  <p class="list-shop-comment">{{ subString($comment->content, 25) }}</p>
                  <div>
                    <p>{{ $comment->nickname }}</p>
                  </div>
                </div>
              </a>
            </li>
            @endforeach
          </ul>
        @else
        <div class="div-wp-cmt">
            <p class="p1-cmt">口コミ・写真はまだ投稿されていません。</p>
            <p class="p2-cmt">このお店に訪れたことがある方は、<br> 最初の口コミ・投稿をしてみませんか？</p>
            <a href="{!! $postReviewUrl !!}" class="a-link-cmt" rel="nofollow"><span>口コミ・写真投稿</span></a>
        </div>
        @endif
        </div>
        <p class="text-right"><a href="{{ route('shop.comments', $shopId) }}" class="review-more red-sp-nnn review-more-fix">{{ $shop->item->facility_name }}{{ !empty($shop->item->facility_name_kana) ? '（'.$shop->item->facility_name_kana.'）' : '' }}の口コミを見る</a></p>
      </div>

    <!-- end showdetail -->
    <div class="div-share">
        <img src="/assets/mobile/images/cl.png" alt="" class="im-cl">
        <span class="sp-shar">シェア</span>
        <ul class="ul-share clearfix">
            <li><a href="https://twitter.com/intent/tweet?text={{$title}} {{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/tw.png" alt=""></a></li>
            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/fa.png" alt=""></a></li>
            <li><a href="http://line.me/R/msg/text/?{{ $item->item->product_name . ' | EPARKスイーツガイド' }}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/li.png" alt=""></a></li>
            <li><a href="https://plus.google.com/share?url={{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/g+.png" alt=""></a></li>
            <li><a href="mailto:?subject={{ $item->item->product_name }}&body={{ $item->item->product_name . ' | EPARKスイーツガイド ' . Request::fullUrl() }}"><img src="/assets/mobile/images/me.png" alt=""></a></li>
        </ul>
    </div>
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
<script>
$(function(){
    $('.menu_tel').on('click',function(){
        $('body').append('<div id="dialog"><div class="tel_out"><a class="close">×</a><div class="tel_ppc"><div class="tel_reserve"><a href="tel:{{ !empty($shop->item->ppc_data->$currentSiteCode) ? $shop->item->ppc_data->$currentSiteCode : "" }}">予約</a></div><p>ケーキ・スイーツのご予約</p></div><div class="tel_info"><div class="tel_inquiry"><a href="tel:{{ $shop->item->tel_no }}">お問い合わせ</a></div><p>キャンセル、場所確認など</p></div><div class="tel_attention"><p>※予約のみ無料通話となります。お問い合わせは、通話料がかかります。</p><p>※キャンセルの場合も必ずご連絡をお願いします。</p><p>※当社及びEPARK利用施設は、発信された電話番号を、EPARKスイーツガイド利用規約第3条（個人情報について）に定める目的で利用できるものとします。</p><p class="unmatched">※電話でのご予約は予約割引対象外となります。</p></div></div></div>');
        $('body').append('<div id="mask"></div>');
        $('.close').on('click',function(){
            $('#dialog,#mask').remove();
        });
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 50) {
                $('footer').addClass('footer-2');
                $('.block-list-pink-3').addClass('block-list-pink-3-1');
            } else {
                $('footer').removeClass('footer-2');
                $('.block-list-pink-3').removeClass('block-list-pink-3-1');
            }
        });
    });

    var mg_t = ($('.div-share').height()) / 2;
    $('.div-share').css('margin-top', '-' + mg_t + 'px');
    $(window).resize(function(event) {
        var mg_t = ($('.div-share').height()) / 2;
        $('.div-share').css('margin-top', '-' + mg_t + 'px');
    });
    if ($('.owl-carousel-1').length) {
        $('.owl-carousel-1').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: {
                    items: 2.5
                },
                600: {
                    items: 2.5
                },
                1000: {
                    items: 2.5
                }
            }
        })
    }
    $('.jsShare').on('click', function() {
        $('.over').fadeIn(400);
        $('.div-share').fadeIn(400);
        var _w_ = $('.ul-share li').width();
        $('.ul-share li').css('height', _w_);
        $('.ul-share li a').css('line-height', _w_ + 'px');
    });
    $('.over').on('click', function() {
        $('.over').fadeOut(400);
        $('.div-share').fadeOut(400);
    });
    $('.im-cl').on('click', function() {
        $('.over').fadeOut(400);
        $('.div-share').fadeOut(400);
    });
    $(window).resize(function() {
        var _w_ = $('.ul-share li').width();
        $('.ul-share li').css('height', _w_);
        $('.ul-share li a').css('line-height', _w_ + 'px');
    });
    $('.data-shop-id-'+{{$shopId}}).click(function() {
            var _this = $(this);
            var _isLogin = "{!! $isLogin !!}";
            var shopId = {{ $shopId }};
            if(_isLogin){
                var isLiked = _this.attr('data-liked');
                getInfoFavorite(shopId, isLiked);
            }else{
                window.location.href = "{!! $loginLink !!}";
            }
      });


    // check if localStorage/sessionStorage is supported
    isLocalStorageNameSupported = function() {
        return false;
        var testKey = 'test', storage = window.sessionStorage;
        try {
            storage.setItem(testKey, '1');
            storage.removeItem(testKey);
            return true;
        } catch (error) {
            return false;
        }
    }

    if (isLocalStorageNameSupported()) {
        // Code for localStorage/sessionStorage.
        window.sessionStorage.setItem('will-be-back-link', window.location.href);
    }

    // remove image
    localStorage.removeItem('base64data');
</script>
<script type="text/javascript">
    $(document).ready(function(){
        // check child product reserved or not
      var arrProductIds = $('.class-product-id');
        $.each(arrProductIds, function(index, val) {
            var product_id = $(val).attr('data-product-id');
            var product_price = $(val).attr('data-product-price');
            var data_json_cashpo_coupon = JSON.parse($(val).attr('data-json-cashpo-coupon'));
            var cashpo = $(val).attr('data-cashpo');
            $.ajax({
                url: '{{ route("product.check_receiptdate") }}',
                type: 'GET',
                dataType: 'json',
                data: {product_id: product_id, product_count: 1},
            })
            .done(function(res) {
                if(res.reservable) {
                    var listDateReserve = res.listDateReserve;
                    var link = "/sp/sweetsstep/reserveinput/";
                    var linkCart = "/sp/sweetsstep/cart/";
                    var numberDiscount = secondChooseCoupon(data_json_cashpo_coupon[product_id], listDateReserve);
                    processAddElementWhenHaveCoupon(numberDiscount, product_price, cashpo, product_id);
                    if(product_price != "" && product_price != "0"){
                        $('.class-product-id-'+product_id).append('<a class="reservation-btn" href="'+link+'init?product_id='+product_id+'"><span>今すぐネットで予約</span></a>');
                        $('.class-product-cart-id-'+product_id).append('<a class="reservation-btn btn-cart" href="'+linkCart+'index?product_id='+product_id+'"><span>カートに入れる</span></a>');
                    }
                    $('.slash-'+product_id).html("受け取り可");
                    $('.slash-2-'+product_id).html("〜");
                    $('#product-'+product_id).html(res.firstReceiptDate);
                }
            });

        });
    })

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

      var now_offset;
      var menu_offset = $('.ul-menu-ch-mypage').offset().top;
      $(window).on('scroll', function () {
        now_offset = window.pageYOffset;
        $('body').toggleClass('menu_fixed sp-product', now_offset > menu_offset);
      })

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
            if(res.status == "0" && res.favorite == "1"){
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_02_off').addClass('okiniiri_btn_sp_02').attr('data-liked',"1").find('img').attr('src','/assets/mobile/images/heart.png');
                $('.span-text-favorite').html('お気に入り追加済');
            }else{
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_02').addClass('okiniiri_btn_sp_02_off').attr('data-liked',"0").find('img').attr('src','/assets/mobile/images/heart_02.png');
                $('.span-text-favorite').html('お気に入り追加');
            }
        });
    }

    function secondChooseCoupon(data_json_cashpo_coupon, listDateReserves)
    {
        if (!$.isEmptyObject(data_json_cashpo_coupon)) {
            var direct_coupons = data_json_cashpo_coupon['direct_coupons'];
            var cashpo_coupons = data_json_cashpo_coupon['cashpo_coupons'];
            if (!$.isEmptyObject(direct_coupons)) {
                return [
                    'direct_coupons',
                    checkDateReserveInCouponCashpo(direct_coupons, listDateReserves)
                ];
            } else if (!$.isEmptyObject(cashpo_coupons)){
                return [
                    'cashpo_coupons',
                    checkDateReserveInCouponCashpo(cashpo_coupons, listDateReserves)
                ];
            }
        }
        return '';
    }
    function checkDateReserveInCouponCashpo(coupons, listDateReserves)
    {
        var key_check = 0;
        var numberDiscount = 0;
        $.each(coupons, function (keyDirectCoupon, coupon) {
            $.each(listDateReserves, function (keyDateReserve, listDateReserve) {
                let from = new Date(coupon.receiptable_from);
                let to = new Date(coupon.receiptable_to);
                let reserve = new Date(listDateReserve);
                reserve.setHours(0,0,0,0);
                if (reserve >= from  && reserve <= to) {
                    key_check++;
                    if (numberDiscount != 0) {
                        if (numberDiscount < coupon.price) {
                            numberDiscount = coupon.price;
                        }
                    }else{
                        numberDiscount = coupon.price;
                    }
                    return false;
                }
            });
        });
        return numberDiscount;
    }
    function processAddElementWhenHaveCoupon(numberDiscount, product_price, cashpo, product_id)
    {
        var divAddDetailWhenHaveCoupon = $('#add-element-price-have-discount-'+product_id);
        if (numberDiscount.length) {
            var type = numberDiscount[0];
            var numberDiscount = numberDiscount[1];
            if (type == 'direct_coupons') {
                if ((product_price - numberDiscount[1]) <= 0) {
                    divAddDetailWhenHaveCoupon.html(buildCaseOnlyDirectCoupon(product_price, numberDiscount));
                } else{
                    if (cashpo <= 0) {
                        divAddDetailWhenHaveCoupon.html(buildCaseOnlyDirectCoupon(product_price, numberDiscount));
                    }else{
                        divAddDetailWhenHaveCoupon.html(buildCaseCashpoAndDirectCoupon(product_price, numberDiscount, cashpo));
                    }
                }
            }else{
                if (cashpo <= 0) {
                    divAddDetailWhenHaveCoupon.html(buildCaseOnlyCouponCashpo(numberDiscount));
                }else{
                    divAddDetailWhenHaveCoupon.html(buildCaseCashpoAndCouponCashpo(product_price, numberDiscount, cashpo));
                }
            }
        }else if (cashpo > 0) {
            divAddDetailWhenHaveCoupon.html(buildCaseOnlyCashpo(product_price, cashpo));
        }else{
            divAddDetailWhenHaveCoupon.html(noCouponNoCashpo());
        }
    }
    function buildCaseOnlyCashpo (product_price, cashpo)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-cashpo));
        var showCashpo = (parseInt(cashpo) > parseInt(product_price )) ? parseInt(product_price) : parseInt(cashpo);
        return '<div class="coupon_syosai accordionbox">\n' +
            '<dl class="accordionlist">\n' +
            '<dt class="clearfix">\n' +
            '<div class="title">\n' +
            '<p>保有キャシュポご利用で<br>\n' +
            '<span>'+priceAfterDiscount+'円<span>(税込)</span></span>で予約できます。</p>\n' +
            '</div>\n' +
            '<p class="accordion_icon">詳細<span></span><span></span></p>\n' +
            '</dt>\n' +
            '<dd>\n' +
            '<div class="normal_price">\n' +
            '<p>通常価格</p>\n' +
            '<p>'+formatNumber(product_price)+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '<div class="cashpo_own_use">\n' +
            '<p>保有キャシュポご利用で<br><span>※残額はクレジットカードでのお支払いとなります。</span></p>\n' +
            '<p class="point_strong">-'+formatNumber(showCashpo)+'円</p>\n' +
            '</div>\n' +
            '<hr>\n' +
            '<div class="price_use">\n' +
            '<p>ご利用後の価格</p>\n' +
            '<p class="point_strong">'+priceAfterDiscount+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>';
    }
    function buildCaseOnlyCouponCashpo (numberDiscount)
    {
        if (numberDiscount > 0) {
            return '<div class="coupon_use_if">\n' +
                '<p class="left_box">\n' +
                '</p><p>保有クーポンご利用で</p>\n' +
                '<p class="fz_big"><span>'+formatNumber(numberDiscount)+'円分</span>キャシュポ還元</p>\n' +
                '<p class="Kome">※予約確認画面でクーポン選択により適用されます。</p>\n' +
                '<p></p>\n' +
                '<div class="point_strong">\n' +
                '<div class="reserve_notice">\n' +
                '<img src="/assets/mobile/images/r_notice.png" alt="" class="icon_q">\n' +
                '<a>保有クーポンのご利用について<span>※事前にお読みください</span>\n' +
                '</a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';
        }
        return '';
    }
    function buildCaseOnlyDirectCoupon (product_price, numberDiscount)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-numberDiscount));
        var showHTMLHaveDiscount = '';
        if(numberDiscount > 0) {
            showHTMLHaveDiscount = '<div class="coupon_own_use">\n' +
                '<p>保有クーポンご利用で<br><span>※予約確認画面でクーポン選択により適用されます。</span></p>\n' +
                '<p class="point_strong">-'+formatNumber(numberDiscount)+'円</p>\n' +
                '</div>\n';
        }
        return '<div class="coupon_syosai accordionbox">\n' +
            '<dl class="accordionlist">\n' +
            '<dt class="clearfix">\n' +
            '<div class="title">\n' +
            '<p>保有クーポンご利用で<br>\n' +
            '<span>'+priceAfterDiscount+'円<span>(税込)</span></span>で予約できます。</p>\n' +
            '</div>\n' +
            '<p class="accordion_icon">詳細<span></span><span></span></p>\n' +
            '</dt>\n' +
            '<dd style="display: none;">\n' +
            '<div class="normal_price">\n' +
            '<p>通常価格</p>\n' +
            '<p>'+formatNumber(product_price)+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            showHTMLHaveDiscount +
            '<hr>\n' +
            '<div class="price_use">\n' +
            '<p>ご利用後の価格</p>\n' +
            '<p class="point_strong">'+priceAfterDiscount+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            '<ul class="reserveList">\n' +
            '<li class="reserve_notice">\n' +
            '<a>保有クーポンのご利用について<span>※事前にお読みください</span>\n' +
            '</a>\n' +
            '</li>\n' +
            '</ul>';
    }
    function buildCaseCashpoAndDirectCoupon (product_price, numberDiscount, cashpo)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-numberDiscount-cashpo));
        var showCashpo =  ( parseInt(cashpo) > ( parseInt(product_price) - parseInt(numberDiscount) ) ) ? (parseInt(product_price) - parseInt(numberDiscount)) : parseInt(cashpo);
        var addHtml = '';
        var showHTMLHaveDiscount = '';
        if ( parseInt(product_price) > parseInt(numberDiscount) ) {
            addHtml = '<div class="cashpo_own_use">\n' +
                '<p>保有キャシュポご利用で<br><span>※残額はクレジットカードでのお支払いとなります。</span></p>\n' +
                '<p class="point_strong">-'+formatNumber(showCashpo)+'円</p>\n' +
                '</div>\n';
        }
        if(numberDiscount > 0) {
            showHTMLHaveDiscount = '<div class="coupon_own_use">\n' +
                '<p>保有クーポンご利用で<br><span>※予約確認画面でクーポン選択により適用されます。</span></p>\n' +
                '<p class="point_strong">-'+formatNumber(numberDiscount)+'円</p>\n' +
                '</div>\n';
        }
        return '<div class="coupon_syosai accordionbox">\n' +
            '<dl class="accordionlist">\n' +
            '<dt class="clearfix">\n' +
            '<div class="title">\n' +
            '<p>保有クーポン・保有キャシュポご利用で<br>\n' +
            '<span>'+priceAfterDiscount+'円<span>(税込)</span></span>で予約できます。</p>\n' +
            '</div>\n' +
            '<p class="accordion_icon">詳細<span></span><span></span></p>\n' +
            '</dt>\n' +
            '<dd>\n' +
            '<div class="normal_price">\n' +
            '<p>通常価格</p>\n' +
            '<p>'+formatNumber(product_price)+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            showHTMLHaveDiscount +
            addHtml+
            '<hr>\n'+
            '<div class="price_use">\n' +
            '<p>ご利用後の価格</p>\n' +
            '<p class="point_strong">'+priceAfterDiscount+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            '<ul class="reserveList">\n' +
            '<li class="reserve_notice">\n' +
            '<a>保有クーポンのご利用について<span>※事前にお読みください</span>\n' +
            '</a>\n' +
            '</li>\n' +
            '</ul>';
    }
    function buildCaseCashpoAndCouponCashpo (product_price, numberDiscount, cashpo)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-cashpo));
        var showCashpo = (parseInt(cashpo) > parseInt(product_price)) ? parseInt(product_price) : formatNumber(cashpo);
        var htmlHaveNumberDiscount = '';
        if (numberDiscount > 0) {
            htmlHaveNumberDiscount = '<div class="coupon_use_if">\n' +
                '<p class="left_box">\n' +
                '</p><p>保有クーポンご利用で</p>\n' +
                '<p class="fz_big"><span>'+formatNumber(numberDiscount)+'円分</span>キャシュポ還元</p>\n' +
                '<p class="Kome">※予約確認画面でクーポン選択により適用されます。</p>\n' +
                '<p></p>\n' +
                '<div class="point_strong">\n' +
                '<div class="reserve_notice">\n' +
                '<img src="/assets/mobile/images/r_notice.png" alt="" class="icon_q">\n' +
                '<a>保有クーポンのご利用について<span>※事前にお読みください</span>\n' +
                '</a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';
        }
        return '<div class="coupon_syosai accordionbox">\n' +
            '<dl class="accordionlist">\n' +
            '<dt class="clearfix">\n' +
            '<div class="title">\n' +
            '<p>保有キャシュポご利用で<br>\n' +
            '<span>'+priceAfterDiscount+'円<span>(税込)</span></span>で予約できます。</p>\n' +
            '</div>\n' +
            '<p class="accordion_icon">詳細<span></span><span></span></p>\n' +
            '</dt>\n' +
            '<dd style="display: none;">\n' +
            '<div class="normal_price">\n' +
            '<p>通常価格</p>\n' +
            '<p>'+formatNumber(product_price)+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '<div class="cashpo_own_use">\n' +
            '<p>保有キャシュポご利用で<br><span>※残額はクレジットカードでのお支払いとなります。</span></p>\n' +
            '<p class="point_strong">-'+formatNumber(showCashpo)+'円</p>\n' +
            '</div>\n' +
            '<hr>\n' +
            '<div class="price_use">\n' +
            '<p>ご利用後の価格</p>\n' +
            '<p class="point_strong">'+priceAfterDiscount+'円<span>(税込)</span></p>\n' +
            '</div>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            htmlHaveNumberDiscount;
    }
    function noCouponNoCashpo() {
        return '';
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function checkValueMoreThanZero(value) {
        return value > 0 ? value : 0;
    }
    $( document ).ajaxStop(function() {
        $(function(){
            $(".accordionbox dt").on("click", function() {
                $(this).next().slideToggle();
                // activeが存在する場合
                if ($(this).children(".accordion_icon").hasClass('active')) {
                  // activeを削除
                    $(this).children(".accordion_icon").removeClass('active');
                }else {
                    // activeを追加
                    $(this).children(".accordion_icon").addClass('active');
                }
            });
        });
        $(function(){
            $('.point_strong .reserve_notice').on('click',function(){
                $('body .product-detail').append('<div id="coupon-dialog"><p class="model_title">保有クーポンのご利用について</p><hr><div class="coupon-out"><div class="coupon-product"><p>・クーポンが利用できるのはネット予約のみとなります。<br>・ご予約時のお値引ではございません。後日キャシュポにて還元いたします。<br>※キャシュポとは？<a target="_blank" href="https://cb.epark.jp/about">https://cb.epark.jp/about</a><br>・キャシュポは商品受取日の翌月末までに還元いたします。（申請不要）<br>・クーポンは1回のご予約で1種類のみご利用いただけます。<br>・EPARKクーポンコードとは併用いただけません。<br>・クーポンごとに設定された受取可能期間外に受取日を指定した場合、該当のクーポンは予約確認画面で表示されず選択できません。<br>・キャシュポ還元に条件がある場合がございます。（口コミ投稿など）<br>・クーポンによっては最低利用金額が設定されている場合がございます。</p></div></div><p class="coupon-close">閉じる</p></div>');
                $('body .product-detail').append('<div id="mask"></div>');
                $('body').addClass('overflow_look');
                $('.coupon-close').on('click',function(){
                    $('#coupon-dialog,#mask').remove();
                    $('body').removeClass('overflow_look');
                });
            });
        });
        $(function(){
            $('.reserveList .reserve_notice').on('click',function(){
                $('body .product-detail').append('<div id="coupon-dialog"><p class="model_title">保有クーポンのご利用について</p><hr><div class="coupon-out"><div class="coupon-product"><p>・クーポンは1回のご予約で1種類のみご利用いただけます。<br>・EPARKクーポンコードとは併用いただけません。<br>・クーポンごとに設定された受取可能期間外に受取日を指定した場合、該当のクーポンは予約確認画面で表示されず選択できません。<br>・クーポンによっては最低利用金額が設定されている場合がございます。</p></div></div><p class="coupon-close">閉じる</p></div>');
                $('body .product-detail').append('<div id="mask"></div>');
                $('body').addClass('overflow_look');
                $('.coupon-close').on('click',function(){
                    $('#coupon-dialog,#mask').remove();
                    $('body').removeClass('overflow_look');
                });
            });
        });
    });
</script>
@stop
