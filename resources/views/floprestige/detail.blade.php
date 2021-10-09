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
@endphp
@extends('layouts.product-detail', ['seoTitle' => $item->item->product_name . ' | EPARKスイーツガイド', 'seoDescription' => $description, 'seoImage' => $image])
@section('title', $productName.' ('.$shopName.')'.'│FLO PRESTIGE PARIS（フロ プレステージュ パリ）')
@section('description', $productName.' ('.$shopName.')'.'の商品詳細ページです。FLO（フロ プレステージュ）では、店内キッチンから生まれる、出来立て・手作り商品のケーキ、タルト、焼き菓子、デリカ(惣菜)をフレンチ・テイストでご提供しています。ギフトやお誕生日、記念日等のアニバーサリーにもご利用ください。')
@section('body.classes', 'flo-page')
@section('content')
@section("container.class", "css-new product-detail")
<div class="pc-container">
    @php
      if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
          $addr_latitude = 35.709409;
          $addr_longitude = 139.724121;
          $main_image = '';
      } else {
          $addr_latitude = $shop->item->addr_latitude;
          $addr_longitude = $shop->item->addr_longitude;
          $main_image = $shop->item->main_image;
      }
    @endphp
    <ul class="t-path">
        <li class="t-path-list"><span><a href="https://www.flojapon.co.jp/" class="link-t-path-border-2">FLO PRESTIGE PARIS（フロ プレステージュ）</a></span></li>
        <li class="t-path-list"><span><a class="link-t-path-border-2" href="https://flo.{{ env('DOMAIN_COOKIE') }}​">店頭受取りWEB予約</a></span></li>
        <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a></span></li>
        <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ route('floprestige.shop.menu',$shopId) }}">{{ $shopName }}メニュー</a></span></li>
        <li><span>{{ $productName }}</span></li>
    </ul>
    @include ("floprestige.partials.shop-info", compact("shopId", "shop", "stationName"))
    @include ("floprestige.partials.list-tab", compact("shopId"))
    <div class="product-hdr">
        <h1 class="item-product-name">{{ $productName }}</h1>
    </div>
    <ul class="shop-slide" id="shopMainSlide" style="margin-bottom: 20px; clear: both;">
        @foreach (range(1, 10) as $number)
            @if (!empty($item->item->{"product_image$number"}))
                <li class="fix-image-slider"><img src="{{ httpsUrl($item->item->{"product_image$number"}, 675) }}"></li>
            @endif
        @endforeach
    </ul>
    <ul class="banner_slider shop-slide-thumbs" id="shopSlideThumbs" style="bottom: 15px;">
        @foreach (range(1, 10) as $number)
            @if (!empty($item->item->{"product_image$number"}))
                <li><img src="{{ httpsUrl($item->item->{"product_image$number"}, 185) }}" style="display: none;"></li>
            @endif
        @endforeach
    </ul>

    <div class="product-comment">
        @if (!empty($item->item->product_description1))
            <p>{!! $item->item->product_description1 !!}</p>
        @endif
        @if (!empty($item->item->product_description2))
            <p>{!! $item->item->product_description2 !!}</p>
        @endif
    </div>

    @if (!empty($parentAndChildProducts))
    @foreach ($parentAndChildProducts as $productChildSize => $productChild)
        @php
        $shopDiscount = !empty($productChild['shop_discount']) ? +($productChild['shop_discount']) : 0;
        $portalDiscount = !empty($productChild['portal_discount']) ? +($productChild['portal_discount']) : 0;
        $productPrice = !empty($productChild['product_price']) ? +($productChild['product_price']) : 0;
        $check = $productPrice - $shopDiscount - $portalDiscount;
        if(($productPrice > 0) && ($check > 0 )){
          $sumPrice = "true";
          $netPrice = $check;
        }else {
          $sumPrice = "false";
          $netPrice = 0;
        }        @endphp
        <div class="div-price-by-size text-left class-product-id" data-product-id="{{ $productChild["product_id"] }}" data-product-price="{{ $productChild['product_price'] }}" data-sum-price="{{ $sumPrice }}">
            <div class="div-item-price-by-size">
                <div class="size-left-side">
                  <div class="diff-date-text">
                      <p class="item-p-money item-p-money-2 item-p-money-3">
                          <span id="product-{{ $productChild['product_id'] }}"></span><span class="slash-2-{{ $productChild['product_id'] }}"></span><strong class="slash-{{ $productChild['product_id'] }}"></strong>
                      </p>
                  </div>
                  <div class="product-cont-fl">
                    @if (!empty($productChild["product_size"]))
                        <div class="child-size">{{ convertCakeSize($productChild['product_size']) }}{{ productChildSizeText($productChild['product_size']) }}</div>
                        @else
                        <div class="child-size"></div>
                    @endif
                    <div class="child-price-normal">
                        @if (!empty($productChild['product_price']))
                            <div class="child-price-normal"><div>通常価格</div><span class="child-price-discount">{{ numberFormat($productChild['product_price']) . "円" }}<small>（税込）</small></span></div>
                        @endif
                    </div>
                    @if ($shopDiscount + $portalDiscount != 0 && !empty($productChild['product_price']))
                        <div class="child-price-net"><div>ネット予約価格</div>{{ numberFormat($netPrice) . "円" }}<small>（税込）</small></div>
                    @else
                        <div class="child-price-net none"></div>
                    @endif
                  </div>
                </div>
                <div class="size-right-side">
                  <div class="text-right dis-inline-bl-m-4">
                      <div class="div-btn-reserve class-product-id-{{ $productChild['product_id'] }}"></div>
                      <div class="div-btn-reserve btn-cart class-product-cart-id-{{ $productChild['product_id'] }}"></div>
                  </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
    <div class="shop_info">
        @php
            $stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
            $train_line = isset($shop->item->train_line1) ? $shop->item->train_line1 : '';
            $exit_station = isset($shop->item->exit_station1) ? $shop->item->exit_station1 : '';
            $means = isset($shop->item->means1) ? $shop->item->means1 : '';
            $time_required = isset($shop->item->time_required1) ? $shop->item->time_required1 : '';
            $flo_tag = isset($shop->item->epark_payment_use_flag) ? $shop->item->epark_payment_use_flag : '';
        @endphp
        <p class="shop_name">{{ $shop->item->facility_name }}</p>
        <dl class="shop-detail">
            @php
                if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
                    $addr_latitude = 35.709409;
                    $addr_longitude = 139.724121;
                } else {
                    $addr_latitude = $shop->item->addr_latitude;
                    $addr_longitude = $shop->item->addr_longitude;
                }
            @endphp
            <dt>住所:</dt>
            <dd>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}(<a href="{{ route("floprestige.shop.map", $shopId) }}" class="link-red">地図</a>)</dd>
        </dl>
        <dl class="shop-detail">
            <dt>最寄駅:</dt>
            <dd>{{ $train_line.' '.$stationName.' '.$exit_station.' '.$means.' '.$time_required }}分</dd>
        </dl>
        @if(!empty($shop->worktime()))
            <dl class="shop-detail">
                <dt>営業時間:</dt>
                <dd>
                    @foreach($shop->worktime() as $worktime)
                        @if($loop->first)
                            <span>{{ $worktime["time"] }}</span>
                        @else
                            <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
                        @endif
                    @endforeach
                </dd>
                <dd>
                    @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
                        <dt>定休日: </dt>
                        @foreach($shop->time_off() as $timeoff)
                            <dd>{{$timeoff}}</dd>
                        @endforeach
                    @endif
                </dd>
            </dl>
        @endif
    </div>
    <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
    <div class="reservations-notes">
        <p>{!! nl2br($item->item->product_description3) !!}</p>
    </div>
    <div class="cake-list-h3">
        <h3>その他のおすすめケーキ</h3>
    </div>
    <ul id="listCakes" class="ul-list-kb1 ul-list-kb1-fix clearfix cake-list other-item-of-shop ul-height-det"></ul>
    <a href="{{ route('floprestige.shop.menu',$shopId) }}" class="to_cakelist">ケーキ一覧を見る</a>
</div>

<style>
input[type="submit"]:hover {
  opacity: 0.8;
}
#pac-input{
  top: 442px!important;
}
.mr-inp{
  margin-right: 165px;
}
.disable-select {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>
<script type="text/javascript">
    function adjustCakeNameHeight(callback) {
        var maxHeight = 0;
        $("#listCakes .cake-name").each(function (index) {
            var self = $(this);
            maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
        });
        $("#listCakes .cake-name").css("height", maxHeight + "px");
        if (callback) callback();
    }
    function adjustCakeItemHeight(callback) {
        var maxHeight = 0;
        $("#listCakes > li .sizes-price-wrapper").each(function (index) {
            var self = $(this);
            maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
        });
        $("#listCakes > li .sizes-price-wrapper").css("height", maxHeight + "px");
        if (callback) callback();
    }
    function doAdjustment() {
        adjustCakeNameHeight(adjustCakeItemHeight);
    }

    $(document).ready(function(){
        $.ajax({
            url: '{{ route("floprestige.shop.other_item_of_shop") }}',
            type: 'GET',
            data: {shopId: '{{ $shopId }}', productId: '{{ $productId }}'},
        })
        .done(function(res) {
            $('.other-item-of-shop').append(res);
            // $('ul.ul-height-det li div.div-autoheight').autoHeight({column:5});
            if($('.ul-height-det li').length > 0){
                var link = "{{ route('shop.menu', $shopId) }}";
                $('.link-to-menu-shop').append('<a href="'+link+'" class="a-more mar-bot-50">{{ $shopName }}のメニューをもっと見る</a>');
            }
            doAdjustment();
        });
    });
</script>
<script type="text/javascript">
    $('document').ready(function() {
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
  });
</script>
<script type="text/javascript">
    function initMap() {
        var uluru = {lat: {{ floatval($addr_latitude) }}, lng: {{ floatval($addr_longitude) }}};
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
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('GOOGLE_API_KEY') }}&callback=initMap"></script>

<style>
  img[src="{{ httpsUrl($shop->item->main_image) }}"]::after {
    position:absolute!important;
    bottom:-40px!important;
    display:block!important;
    right:0!important;
    width:50px!important;
    height: 50px!important;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $('.img-nav').on('click', function(){
      var _this_ = $(this);
      var data_class = _this_.attr('data-class');
      $('.view').find('.active-img-prod').fadeOut(300);
      $('.view').find('.active-img-prod').removeClass('active-img-prod');
      $('#'+data_class).fadeIn(300);
      $('#'+data_class).addClass('active-img-prod');
    });

    $(".child-price-net.none").parent('.product-cont-fl').addClass('noneAfter');

  });

  // remove image
  localStorage.removeItem('base64data');

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
                var link = "/sweetsstep/reserveinput/";
                var linkCart = "/sweetsstep/cart/";
                if(product_price != "" && product_price != "0" && product_sum_price == "true"){
                    $('.class-product-id-'+product_id).html('<p class="p-button p-button-green new-p-button p-resv-red lh-30"><a class="reservation-btn cursor-ponter" href="'+link+'init?product_id='+product_id+'&site_code='+site_code+'"><span class="pa-l-20 pa-l-20-new">今すぐネットで予約</span></a></p>');
                    $('.class-product-cart-id-'+product_id).html('<p class="p-button p-button-green new-p-button p-resv-red lh-30"><a class="reservation-btn cursor-ponter" href="'+linkCart+'index?product_id='+product_id+'&site_code='+site_code+'"><span class="pa-l-20 pa-l-20-new">カートに入れる</span></a></p>');
                }
                $('.slash-'+product_id).html("受け取り可");
                $('.slash-2-'+product_id).html("〜");
                $('#product-'+product_id).html(res.firstReceiptDate);
            }
        });

    });
    $(function () {
        $('#shopMainSlide').slick({
            autoplay: true,
            asNavFor: '#shopSlideThumbs',
            adaptiveHeight: true,
        });
        $('#shopSlideThumbs').slick({
            dots: true, // スライダー下部に表示される、ドット状のページネーション
            infinite: true, // 無限ループ
            speed: 300, // 切り替わりのスピード
            autoplay: true, // オートプレイ
            autoplaySpeed: 4000, //オートプレイスピード4秒
            pauseOnFocus: false,
            asNavFor: '#shopMainSlide',
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
            if(res.status == "0" && res.favorite == "1"){
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_off').addClass('okiniiri_btn_sp').attr('data-liked',"1").find('img').attr('src','/assets/pc/images/heart_02_on.png');
                $('.span-text-favorite').html('お気に入り追加済');
            }else{
                $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp').addClass('okiniiri_btn_sp_off').attr('data-liked',"0").find('img').attr('src','/assets/pc/images/heart_02_off.png');
                $('.span-text-favorite').html('お気に入り追加');
            }
        });
    }
</script>
@stop
