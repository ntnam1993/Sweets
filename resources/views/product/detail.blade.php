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
@section('title', $productName.' ('.$shopName.')'.'｜EPARKスイーツガイド')
@section('description', 'EPARKスイーツガイドの'.$productName.' ('.$shopName.')の商品詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,009件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！')
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
    <ul class="t-path border">
        <li class="t-path-list"><span><a href="/" class="link-t-path-border-2">EPARKスイーツガイド</a></span></li>
        @if(!empty($region))
            <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a></span></li>
            @if(!empty($subRegion))
                <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a></span></li>
            @endif
        @endif
        <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ route('shop.index', $shopId) }}">{{ $shop->item->facility_name }}</a></span></li>
        <li><span>{{ $item->item->product_name }}</span></li>
    </ul>
    <div class="mar-bot-10">
        @include ("partials.shop.list-tab", compact("shopId", "shop"))
    </div>
    <div class="product-hdr">
        <h1 class="item-product-name">{{ $item->item->product_name }}</h1>
        @include('layouts.icon-box', ['epark_payment_use_flag' => $item->item->epark_payment_use_flag])
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
        <p style="text-align: left;">{{ $item->item->catch_copy }}</p>
        @if (!empty($item->item->product_description1))
            <p class="description1">{!! $item->item->product_description1 !!}</p>
        @endif
        @if (!empty($item->item->product_description2))
            <p class="description2">{!! $item->item->product_description2 !!}</p>
        @endif
        @if ($isLogin && ($cashpo > 0))
            <div class="own_cashpo">
                <div>
                    <p class="title">保有キャシュポ</p>
                    <p class="points">{{ number_format($cashpo) }}円</p>
                </div>
                <p class="notice">{{$cashpoExpireDate}}するキャシュポがあります。</p>
            </div>
        @endif
    </div>
    @if (!empty($parentAndChildProducts))
        @foreach ($parentAndChildProducts as $productChildSize => $productChild)
            <div class="products_price text-left class-product-id" data-product-id="{{ $productChild["product_id"] }}" data-product-price="{{ $productChild['product_price'] ? $productChild['product_price'] : 0 }}" data-json-cashpo-coupon="{{ $dataJsonCouponCashpo }}" data-cashpo="{{ $cashpo }}">
                <div class="size-left-side">
                    <p class="date_limit">
                        <span id="product-{{ $productChild['product_id'] }}"></span>
                        <span class="slash-2-{{ $productChild['product_id'] }}"></span>
                        <strong class="slash-{{ $productChild['product_id'] }}"></strong>
                    </p>
                    <div class="price_container" style="position: relative;">
                        @if (!empty($productChild["product_size"]))
                            <p class="size">{{ convertCakeSize($productChild['product_size']) }}{{ productChildSizeText($productChild['product_size']) }}</p>
                        @else
                            <p class="size"></p>
                        @endif
                        @if(!empty($productChild['product_price']))
                            <p class="normal_price">通常価格
                                <span class="child-price-discount">{{ numberFormat($productChild['product_price']) . "円" }}</span>（税込）
                            </p>
                        @endif
                        <div id="add-element-price-have-discount-{{$productChild['product_id']}}"></div>
                    </div>
                </div>
                <div class="size-right-side size-right-side-{{ $productChild['product_id'] }}">
                    <div class="text-right dis-inline-bl-m-4">
                        <div class="div-btn-reserve class-product-id-{{ $productChild['product_id'] }}"></div>
                        <div class="div-btn-reserve btn-cart class-product-cart-id-{{ $productChild['product_id'] }}"></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @php
    $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
    @endphp
    @if(!empty($shop->item->ppc_data))
        @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
            @if(!empty($shop->item->ppc_data->$currentSiteCode))
            <div class="reserveBox">
                <ul class="reserveList">
                    <li class="reserve_here">
                        <p>お電話からのご予約はこちら
                            <span class="unmatched">※電話でのご予約は通常価格となります</span>
                        </p>
                    </li>
                    <li class="reserve_notice">
                        <a>電話受付(予約)時の注意
                            <span class="reserve_popup">
                                <p>電話受付(予約)時の注意</p>
                                <p>※無料通話となります。</p>
                                <p>※キャンセルの場合も必ずご連絡をお願いします。</p>
                                <p>※当社及びEPARK利用施設は、発信された電話番号を、EPARKスイーツガイド利用規約第3条（個人情報について）に定める目的で利用できるものとします。</p>
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="reserve_tel reserve_tel-fix"><p><span>無料</span>{{ $shop->item->ppc_data->$currentSiteCode }}</p></div>
            </div>
            @endif
        @endif
    @endif
    <div class="shop-facility-name">{{ $shop->item->facility_name }}</div>
    <p class="text-left">
        <span>住所:</span>
        <span>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</span>
        <span>(<a class="map" href="{{ route('shop.map', $shopId) }}">地図</a>)</span>

        <div class="text-left">
            {!! showNearestStation($shop->item) !!}
        </div>
        <div class="text-left">
            <span>営業時間: </span>
            @foreach($shop->worktime() as $worktime)
                @if($loop->first)
                    <span>{{ $worktime["time"] }}</span>
                @else
                    <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
                @endif
            @endforeach
        </div>
    </p>
    <div class="shop-rate">
        <div class="rate-group rate-top24">
            <div class="rateit"
            data-rateit-readonly="true"
            data-rateit-resetable="false"
            data-rateit-starwidth="24"
            data-rateit-starheight="18"
            data-rateit-min="0"
            data-rateit-max="5"
            data-rateit-value="{{ $shop->item->comment_evaluate_total }}"
            data-rateit-step="0.1"></div>
            <a href="{{ route("shop.comments", $shopId) }}" class="rate-np">{{ numberFormat($shop->item->comment_evaluate_total, 1) }} {{ !empty($shop->item->comment_num) ? '('.$shop->item->comment_num.'件)' : '' }}</a>
        </div>
    </div>

    <p class="okiniiri"><a class="okiniiri_btn_sp_off data-shop-id-{{ $shopId }}" href="javascript:void(0)" data-liked="0"><img style="margin-right:5px;margin-bottom:3px;" src="/assets/pc/images/heart_02_off.png"><span class="span-text-favorite">お気に入り追加</span></a></p>
    <div class="reservations-notes">
        <p>{!! nl2br($item->item->product_description3) !!}</p>
    </div>

    @include ("shop.partials.working-time", compact("shop"))

    <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>

    <div class="cake-list-h3">
        <h3>{{ $shopName }}のメニュー</h3>
    </div>
    <ul id="listCakes" class="ul-list-kb1 ul-list-kb1-fix clearfix cake-list other-item-of-shop ul-height-det">
    </ul>

    <div class="item-detil new-detil pList-icon">
        <h3>{{ $shopName }}の口コミ</h3>
        <a href="{!! $postReviewUrl !!}" class="post-button"  rel="nofollow"><span>口コミ投稿</span></a>
    </div>
    @if ($comments->item_exist())
        <div class="tab1">
            @foreach($comments->items as $comment)
                <div class="clearfix bor-bot-div-rev">
                    <div class="card-cover__wrapper">
                        <div class="card-cover__content" style="width: 180px; height: 180px; background-image: url({{ !empty($comment->image) ? httpsUrl($comment->image) : '/assets/pc/images/thum-def.png' }})"></div>
                        <img class="thumb-reviews" src="{{ !empty($comment->image) ? httpsUrl($comment->image) : '/assets/pc/images/thum-def.png' }}" alt="">
                    </div>
                    <div class="ovef-hidden">
                        <p class="p-title-52 p-title-52-top-0"><a href="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}">{{ $comment->content_title }}</a></p>
                        <p class="p-date">{{ dateFormat($comment->comment_date, "full") }}</p>
                        @if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                        @php
                            $bestPoints = (array) $comment->best_point_list;
                            $goodPoints = (array) $comment->good_point_list;

                            if (!empty($bestPoints)) {
                                $goodPoints = array_diff_key($goodPoints, $bestPoints);
                            }
                        @endphp
                        <ul class="listTab listTab-2 list-point list-point-product">
                            <li>良かった点：</li>
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
                        <p class="p-desc-52">{{ $comment->content }}</p>
                        <div class="block-as block-as-no-bor">
                            <div class="block-img-as">
                                {{ $comment->nickname }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('shop.comments', $shopId) }}" class="a-more mar-bot-50">{{ $shop->item->facility_name }}の口コミを見る</a>
    @else
        <div class="no-comment">
            <span class="bold">口コミ・写真はまだ投稿されていません。</span>
            <p>このお店に訪れたことがある方は、<br/>最初の口コミ・投稿をしてみませんか？</p>
            <a href="{!! $postReviewUrl !!}" class="fff-link" rel="nofollow"><span>口コミ・写真投稿</span></a>
        </div>
    @endif
    <div class="shop-detil" style="clear:both;">
        <h3>{{ $shop->item->facility_name }}の情報</h3>
        <a href="{{ route("shop.index", $shopId) }}" class="shop-button"><span>店舗情報を見る</span></a>
    </div>

    <table class="table-kb4 table-kb4-ch">
        <tbody>
            <tr>
                <th>店舗名</th>
                <td>
                    <ul class="table-list">
                        <li><span class="">{{ $shop->item->facility_name }}</span></li>
                    </ul>
                    @if(empty($shop->item->prov_name.$shop->item->facility_name))
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>住所</th>
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
                    </ul>
                    @if(empty($shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name))
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>最寄り駅</th>
                <td>
                    @include ('partials.components.nearest-station', compact('shop'))
                    @if(empty($shop->item->station1.$shop->item->station2.$shop->item->station3.$shop->item->station4.$shop->item->station5))
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>
                    @if(!empty($shop->item->tel_no))
                    <div>{{ $shop->item->tel_no }}</div>
                    @else
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>公式サイト</th>
                <td>
                    @if(!empty($shop->item->site_url_pc))
                    <a target="_blank" href="{{ $shop->item->site_url_pc }}">{{ $shop->item->site_url_pc }}</a>
                    @else
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>関連リンク</th>
                <td>
                    <a target="_blank" href="{{ $shop->item->related_links_url1 }}">{{$shop->item->related_links_title1}}</a>
                    <a target="_blank" href="{{ $shop->item->related_links_url2 }}">{{$shop->item->related_links_title2}}</a>
                    <a target="_blank" href="{{ $shop->item->related_links_url3 }}">{{$shop->item->related_links_title3}}</a>
                    <a target="_blank" href="{{ $shop->item->related_links_url4 }}">{{$shop->item->related_links_title4}}</a>
                    @if(empty($shop->item->related_links_url1.$shop->item->related_links_url2.$shop->item->related_links_url3.$shop->item->related_links_url4))
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>サービス</th>
                @php $str = implode(' / ', $shop->item->compatible_service); @endphp
                <td>
                    @if(!empty($shop->item->compatible_service))
                    <div>{{ $str }}</div>
                    @else
                    ー
                    @endif
                </td>
            </tr>
            <tr>
                <th>定休日</th>
                <td>
                    @if ($shop->time_off()[0] != "-")
                        @foreach($shop->time_off() as $timeoff)
                        <span>{{$timeoff}}</span>
                        @endforeach
                    @else
                        不定休
                    @endif
                </td>
            </tr>
        </tbody>
    </table>


    <div class="block-map-n">
        <div id="map" style="width:100%;height:290px" class="map-canvas"></div>
    </div>

    <div class="search-wrap">
        <div class="search-wrap-inner">
            <div class="item-search">
                <h3>市町村から探す</h3>
            </div>
            @if (!empty($citySiblings) && count($citySiblings) > 0)
                <ul class="search-cities">
                    @foreach($citySiblings as $i=>$v)
                    <li><a href="{{ route('product.index', ['region' => $region->slug, 'sub_region' => $v->slug]) }}">{{ $v->category_name }}</a></li>
                    @endforeach
                </ul>
            @endif

            <div class="item-search">
                <h3>都道府県から探す</h3>
            </div>
            @include ('partials.components.parent-regions')
        </div>
    </div>

    <div class="about-sweetsguide">
        <div class="h3">
            <h3>EPARKスイーツガイドとは？</h3>
        </div>
        <p class="what-sweets">「EPARKスイーツガイド」では、日本最大級の6,000点以上の商品情報から誕生日ケーキを予約できます。地域や路線、現在地情報をもとにお店を絞り込んだり、有名なパティスリーから地元密着型のケーキ屋さん、デパートや駅構内などのショッピングモールに入っているケーキ屋さんなど、自分にあった誕生日ケーキを探すことが可能です。様々な記念日やシーンにご利用を頂けるように、定番の生デコレーションケーキを始め、女子会や子供に人気なプリントケーキ、キャラクターケーキ、パーティーなどの結婚式二次会・イベント・サークルの打ち上げでおすすめな大型ケーキまで、幅広く品揃えをご用意しております。会員登録料や利用料、年会費、すべて無料！24時間予約可能な誕生日ケーキ情報が探せるので、お子様がいる主婦の方から、お仕事で忙しいお勤めの方まで幅広くご利用頂いております。</p>
    </div>

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
            url: '{{ route("product.other_item_of_shop") }}',
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
                var link = "/sweetsstep/reserveinput/";
                var linkCart = "/sweetsstep/cart/";
                var numberDiscount = secondChooseCoupon(data_json_cashpo_coupon[product_id], listDateReserve);
                processAddElementWhenHaveCoupon(numberDiscount, product_price, cashpo, product_id);
                if(product_price != "" && product_price != "0"){
                    $('.class-product-id-'+product_id).html('<p class="p-button p-button-green new-p-button p-resv-red lh-30"><a class="reservation-btn cursor-ponter" href="'+link+'init?product_id='+product_id+'"><span class="pa-l-20 pa-l-20-new">今すぐネットで予約</span></a></p>');
                    $('.class-product-cart-id-'+product_id).html('<p class="p-button p-button-green new-p-button p-resv-red lh-30"><a class="reservation-btn cursor-ponter" href="'+linkCart+'index?product_id='+product_id+'"><span class="pa-l-20 pa-l-20-new">カートに入れる</span></a></p>');
                }
                $('.slash-'+product_id).html("受け取り可");
                $('.slash-2-'+product_id).html("〜");
                $('#product-'+product_id).html(res.firstReceiptDate);
            }
          else {
            $('.size-right-side-'+product_id).hide();
            $('.size-left-side-'+product_id).css('width','100%');
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
                    return;
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
        return '<div class="price_box">\n' +
            '<div class="able_price">\n' +
            '<p>保有キャシュポご利用で\n' +
            '<span class="c_red">\n' +
            '<span class="fz_big">'+priceAfterDiscount+'円</span>(税込)\n' +
            '</span>で予約できます。\n' +
            '</p>\n' +
            '<p class="btn_detail">詳細</p>\n' +
            '</div>\n' +
            '<div class="price_detail">\n' +
            '<dl>\n' +
            '<dt>通常価格</dt>\n' +
            '<dd>'+formatNumber(product_price)+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '<dl class="use_cashpo">\n' +
            '<dt>保有キャシュポご利用で\n' +
            '<span>※残額はクレジットカードでのお支払いとなります。</span>\n' +
            '</dt>\n' +
            '<dd>－'+formatNumber(showCashpo)+'円</dd>\n' +
            '</dl>\n' +
            '<dl class="total_price">\n' +
            '<dt>ご利用後の価格</dt>\n' +
            '<dd>'+priceAfterDiscount+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            '</div>';
    }
    function buildCaseOnlyCouponCashpo (numberDiscount)
    {
        if(numberDiscount > 0 ) {
            return '<div class="coupon coupon_cashpo">\n' +
                '<p class="coupon_detail">保有クーポンご利用で\n' +
                '<br>\n' +
                '<span class="c_red">'+formatNumber(numberDiscount)+'円分</span>キャシュポ還元\n' +
                '<span class="notice">※予約確認画面でクーポン選択により適用されます。</span>\n' +
                '</p>\n' +
                '<p id="modal_detail" class="about_coupon">保有クーポンのご利用について\n' +
                '<span>※事前にお読みください</span>\n' +
                '</p>\n' +
                '</div>';
        }
        return '';
    }
    function buildCaseOnlyDirectCoupon (product_price, numberDiscount)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-numberDiscount));
        var showHTMLHaveDiscount = '';
        if(numberDiscount > 0) {
            showHTMLHaveDiscount = '<dl class="use_cashpo">\n' +
                '<dt>保有クーポンご利用で\n' +
                '<span>※予約確認画面でクーポン選択により適用されます。</span>\n' +
                '</dt>\n' +
                '<dd>－'+formatNumber(numberDiscount)+'円</dd>\n' +
                '</dl>\n';
        }
        return '<div class="price_box">\n' +
            '<div class="able_price">\n' +
            '<p>保有クーポンご利用で\n' +
            '<span class="c_red">\n' +
            '<span class="fz_big">'+priceAfterDiscount+'円</span>(税込)\n' +
            '</span>で予約できます。\n' +
            '</p>\n' +
            '<p class="btn_detail">詳細</p>\n' +
            '</div>\n' +
            '<div class="price_detail">\n' +
            '<dl>\n' +
            '<dt>通常価格</dt>\n' +
            '<dd>'+formatNumber(product_price)+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
                showHTMLHaveDiscount+
            '<dl class="total_price">\n' +
            '<dt>ご利用後の価格</dt>\n' +
            '<dd>'+priceAfterDiscount+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="coupon only">\n' +
            '<p id="modal_detail" class="about_coupon">保有クーポンのご利用について\n' +
            '<span>※事前にお読みください</span>\n' +
            '</p>\n' +
            '</div>';
    }
    function buildCaseCashpoAndCouponCashpo (product_price, numberDiscount, cashpo)
    {
        var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-cashpo));
        var showCashpo = (parseInt(cashpo) > parseInt(product_price)) ? parseInt(product_price) : formatNumber(cashpo);
        var htmlHaveNumberDiscount = '';
        if (numberDiscount > 0) {
            htmlHaveNumberDiscount = '<div class="coupon coupon_cashpo">\n' +
                '<p class="coupon_detail">保有クーポンご利用で\n' +
                '<br>\n' +
                '<span class="c_red">'+formatNumber(numberDiscount)+'円分</span>キャシュポ還元\n' +
                '<span class="notice">※予約確認画面でクーポン選択により適用されます。</span>\n' +
                '</p>\n' +
                '<p id="modal_detail" class="about_coupon">保有クーポンのご利用について\n' +
                '<span>※事前にお読みください</span>\n' +
                '</p>\n' +
                '</div>';
        }
        return '<div class="price_box">\n' +
            '<div class="able_price">\n' +
            '<p>保有キャシュポご利用で\n' +
            '<span class="c_red">\n' +
            '<span class="fz_big">'+priceAfterDiscount+'円</span>(税込)\n' +
            '</span>で予約できます。\n' +
            '</p>\n' +
            '<p class="btn_detail">詳細</p>\n' +
            '</div>\n' +
            '<div class="price_detail">\n' +
            '<dl>\n' +
            '<dt>通常価格</dt>\n' +
            '<dd>'+formatNumber(product_price)+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '<dl class="use_cashpo">\n' +
            '<dt>保有キャシュポご利用で\n' +
            '<span>※残額はクレジットカードでのお支払いとなります。</span>\n' +
            '</dt>\n' +
            '<dd>－'+formatNumber(showCashpo)+'円</dd>\n' +
            '</dl>\n' +
            '<dl class="total_price">\n' +
            '<dt>ご利用後の価格</dt>\n' +
            '<dd>'+priceAfterDiscount+'円\n' +
            '<span>(税込)</span>\n' +
            '</dd>\n' +
            '</dl>\n' +
            '</div>\n' +
            '</div>\n' +
            htmlHaveNumberDiscount;
    }
    function buildCaseCashpoAndDirectCoupon (product_price, numberDiscount, cashpo)
    {
      var priceAfterDiscount = formatNumber(checkValueMoreThanZero(product_price-numberDiscount-cashpo));
      var showCashpo =  ( parseInt(cashpo) > ( parseInt(product_price) - parseInt(numberDiscount) ) ) ? (parseInt(product_price) - parseInt(numberDiscount)) : parseInt(cashpo);
      var addHtml = '';
      var showHTMLHaveDiscount = '';
      if ( parseInt(product_price) > parseInt(numberDiscount) ) {
          addHtml = '<dl class="use_cashpo">\n' +
              '<dt>保有キャシュポご利用で\n' +
              '<span>※残額はクレジットカードでのお支払いとなります。</span>\n' +
              '</dt>\n' +
              '<dd>－'+formatNumber(showCashpo)+'円</dd>\n' +
              '</dl>\n';
      }
      if(numberDiscount > 0) {
          showHTMLHaveDiscount = '<dl class="use_cashpo">\n' +
              '<dt>保有クーポンご利用で\n' +
              '<span>※予約確認画面でクーポン選択により適用されます。</span>\n' +
              '</dt>\n' +
              '<dd>－'+formatNumber(numberDiscount)+'円</dd>\n' +
              '</dl>\n';
      }
      return '<div class="price_box">\n' +
          '<div class="able_price">\n' +
          '<p>保有クーポン・保有キャシュポご利用で\n' +
          '<span class="c_red">\n' +
          '<span class="fz_big">'+priceAfterDiscount+'円</span>(税込)\n' +
          '</span>で予約できます。\n' +
          '</p>\n' +
          '<p class="btn_detail">詳細</p>\n' +
          '</div>\n' +
          '<div class="price_detail" style="display: block;">\n' +
          '<dl>\n' +
          '<dt>通常価格</dt>\n' +
          '<dd>'+formatNumber(product_price)+'円\n' +
          '<span>(税込)</span>\n' +
          '</dd>\n' +
          '</dl>\n' +
          showHTMLHaveDiscount +
          addHtml +
          '<dl class="total_price">\n' +
          '<dt>ご利用後の価格</dt>\n' +
          '<dd>'+priceAfterDiscount+'円\n' +
          '<span>(税込)</span>\n' +
          '</dd>\n' +
          '</dl>\n' +
          '</div>\n' +
          '</div>\n' +
          '<div class="coupon only">\n' +
          '<p id="modal_detail" class="about_coupon">保有クーポンのご利用について\n' +
          '<span>※事前にお読みください</span>\n' +
          '</p>\n' +
          '</div>';
    }
    function noCouponNoCashpo() {
        return '<div class="child-price-net none"></div>';
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function checkValueMoreThanZero(value) {
        return value > 0 ? value : 0;
    }
    $( document ).ajaxStop(function() {
      $('.price_detail').hide();
      $('body .btn_detail').click(function () {
          $(this).toggleClass('open');
          $(this).parent().parent().find('.price_detail').slideToggle('normal');
      });
      $(function(){
          $('.coupon.coupon_cashpo .about_coupon').on('click',function(){
              $('body .product-detail').append('<div class="modal_bg"><div class="coupon__box"><dl><dt>保有クーポンのご利用について</dt><dd><ul><li>・クーポンが利用できるのはネット予約のみとなります。</li><li>・ご予約時のお値引ではございません。後日キャシュポにて還元いたします。<br>※キャシュポとは？<a target="_blank" href="https://cb.epark.jp/about">https://cb.epark.jp/about</a></li><li>・キャシュポは商品受取日の翌月末までに還元いたします。（申請不要）</li><li>・クーポンは1回のご予約で1種類のみご利用いただけます。</li><li>・EPARKクーポンコードとは併用いただけません。</li><li>・クーポンごとに設定された受取可能期間外に受取日を指定した場合、該当のクーポンは予約確認画面で表示されず選択できません。</li><li>・キャシュポ還元に条件がある場合がございます。（口コミ投稿など）</li><li>・クーポンによっては最低利用金額が設定されている場合がございます。</li></ul></dd></dl><p class="btn_close">閉じる</p></div></div>');
              $('body .product-detail').append('<div id="mask"></div>');
              $('.btn_close,.modal_bg').on('click',function(){
              $('.coupon__box,.modal_bg').remove();
              });
          });
      });

      $(function(){
          $('.coupon.only .about_coupon').on('click',function(){
              $('body .product-detail').append('<div class="modal_bg"><div class="coupon__box"><dl><dt>保有クーポンのご利用について</dt><dd><ul><li>・クーポンは1回のご予約で1種類のみご利用いただけます。</li><li>・EPARKクーポンコードとは併用いただけません。</li><li>・クーポンごとに設定された受取可能期間外に受取日を指定した場合、該当のクーポンは予約確認画面で表示されず選択できません。</li><li>・クーポンによっては最低利用金額が設定されている場合がございます。</li></ul></dd></dl><p class="btn_close">閉じる</p></div></div>');
              $('body .product-detail').append('<div id="mask"></div>');
              $('.btn_close,.modal_bg').on('click',function(){
              $('.coupon__box,.modal_bg').remove();
              });
          });
      });
    });
</script>
@stop
