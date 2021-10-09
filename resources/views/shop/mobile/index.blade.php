@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$imageOg  = isset($shop->item->sub_image1) ? $shop->item->sub_image1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? $shop->item->page_title : '';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.mobile.shop',['imageOg' => $imageOg])
@section('title', $title)
@section('description', $description)
@section('body.classes', 'shop-detail')
@section('container.class', 'css-new')
@section('content')
@include('shop.mobile.partials.list-tab')
@include('shop.mobile.partials.shop-summary')
<!-- slider -->
<p class="bg-translate"></p>
<!--  -->
<div class="block2-sdetail1">
  @if(!empty($shop->item->sub_image1) || !empty($shop->item->sub_image2) || !empty($shop->item->sub_image3) || !empty($shop->item->sub_image4) || !empty($shop->item->sub_image5) || !empty($shop->item->sub_image6) || !empty($shop->item->sub_image7) || !empty($shop->item->sub_image8))
    <div class="shop-contents-unit">
        <ul class="shop-slide" id="shopMainSlide">
            @for($i = 1; $i <= 8; $i++)
            @php $sub_image = 'sub_image'.$i; @endphp
                @if(!empty($shop->item->$sub_image))
                <li class="fix-image-slide"><img src="{{ httpsUrl($shop->item->$sub_image, 675) }}"></li>
                @endif
            @endfor
        </ul>
    </div>
  @endif

  <div class="shop-contents-unit">
  @if(!empty($shop->item->catch_copy))
    <h2>{{ $shop->item->catch_copy }}</h2>
  @endif
  <p>{!! nl2br($shop->item->list_comment) !!}</p>
  </div>
  @if($listShop)
      <div class="shop-list-h3">
          <h2>予約のできる近隣のケーキ屋さん・スイーツ店</h2>
      </div>
      <ul class="item_box item_box_ct">
          @foreach ($listShop as $key => $value)
              <li class="item">
                  <a href="{{ route('shop.index', [$key]) }}">
                    @if(!empty($value->images_url[0]))
                        <span class="" style="background-image: url({{ httpsUrl($value->images_url[0], 675) }})"></span>
                    @elseif(!empty($value->main_image_s))
                        <span class="" style="background-image: url({{ httpsUrl($value->main_image_s, 675) }})"></span>
                    @endif
                  </a>
                  <div class="">
                      <p class="item_name text_look"><span>{{ subString($value->catalog_name,24) }}</span></p>
                      <p class="nedan"><span>{{ subString($value->prov_name.$value->city.$value->district, 24) }}</span></p>
                      <a class="yoyaku_btn" href="{{ route('shop.index', [$key]) }}">ショップ情報を見る</a>
                  </div>
              </li>
          @endforeach
      </ul>
  @endif
    @include('shop.mobile.shop-sp',compact('shopName','get4ProductReservable'))
<div class="shop-contents-unit">
    <h2>{{ $shop->item->facility_name }}の紹介</h2>
    @if($shop->item->introdyctory_essay != '')
    <p>{!! nl2br($shop->item->introdyctory_essay) !!}</p>
    @endif
</div>

@if(!empty($shop->item->subhead8))
<div class="shop-contents-unit">
    <h2>{{ $shop->item->subhead8 }}</h2>
    <img class="img" src="{{ httpsUrl($shop->item->sub_image8, 675) }}">
    <p>{!! nl2br($shop->item->explanation8) !!}</p>
</div>
@endif

<div class="shop-contents-unit">
    @php
        $count = 0;
    @endphp
    @if(!empty($shop->item->shop_news))
    @foreach ($shop->item->shop_news as $shopNew)
        @if (!empty($shopNew) && $shopNew->display_flg == "1")
            @php $count++ @endphp
        @endif
    @endforeach
    @endif
    @if($count)
    <h2>ショップからのお知らせ</h2>
    @endif
    @if(!empty($shop->item->shop_news))
      @foreach($shop->item->shop_news as $shopNew)
        @if(!empty($shopNew) && $shopNew->display_flg == "1")
        @if(!empty($shopNew->news_title))
        <h3>{{ $shopNew->news_title }}</h3>
        @endif
        <p>{{ $shopNew->news_text }}</p>
        @endif
      @endforeach
    @endif
</div>

<div class="shop-contents-unit">
    <h2>ショップ情報</h2>
    <?php $flag = 0;?>
    @for($i = 1; $i <= 7; $i++)
        @php
            $img = "sub_image" . $i;
            $explanation = "explanation" . $i;
            $subhead = "subhead" . $i;
        @endphp
        @if (!empty($shop->item->{"sub_image$i"}) || !empty($shop->item->{"subhead$i"}) || !empty($shop->item->{"explanation$i"}))
          <img class="img" src="{{ httpsUrl($shop->item->$img, 675) }}">
          @php
          $first150 = mb_substr($shop->item->$explanation, 0, 150);
          $remain = mb_substr($shop->item->$explanation, 150);
          @endphp
          @if(!empty($shop->item->$subhead))
          <h3>{{ $shop->item->$subhead }}</h3>
          @endif
          <p>{{ $first150 }}</p>
          <div class="more-contents">
            <p>{{ $remain }}</p>
          </div>
          @if(!empty($remain))
          <div class="more more-fix-css">
              <a href="#" class="red-sp-nnn">続きを読む</a>
          </div>
          @endif
        @endif
    @endfor
    @include('shop.partials.working-time')
    <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
</div>

<div class="shop-contents-unit">
    <h2>{{ $shop->item->facility_name }}の口コミ</h2>
    @if(!empty($comments->items))
    <a href="{!! $postReviewUrl !!}" class="post-button" rel="nofollow"><span>口コミ投稿</span></a>
    @endif
    <div class="list-shop">
    @if(!empty($comments->items))
    @php $i = 1; @endphp
      <ul>
        @foreach($comments->items as $comment)
          @if($i <= 3)
          <li>
              <a href="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}" >
                <div class="list-shop-info">
                  <p class="list-shop-desc">{{ subString($comment->content_title, 25) }}</p>
                  @if(!empty($comment->evaluate_star_total))
                  @if($comment->evaluate_star_total != '0')
                  @if($comment->vote_mode != "2")
                  @if($comment->target_type == '2')
                  <div class="rate-group rate-top24">
                    <div class="rateit"
                        data-rateit-readonly="true"
                        data-rateit-resetable="false"
                        data-rateit-starwidth="24"
                        data-rateit-starheight="18"
                        data-rateit-min="0"
                        data-rateit-max="5"
                        data-rateit-value="{{ $comment->evaluate_star_total }}"
                        data-rateit-step="0.1">
                    </div>
                    <span class="rate-np">{{ numberFormat($comment->evaluate_star_total, 1) }}</span>
                  </div>
                  @endif
                  @endif
                  @endif
                  @endif

                  @if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                  @php
                      $bestPoints = (array) $comment->best_point_list;
                      $goodPoints = (array) $comment->good_point_list;

                      if (!empty($bestPoints)) {
                          $goodPoints = array_diff_key($goodPoints, $bestPoints);
                      }
                  @endphp
                      <ul class="listTab listTab-2 list-point">
                          <p class="p-yl">良かった点</p>
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
              <span class="rate-detail">
                @if(!empty($comment->evaluate_star_list))
              ［
                @foreach ($comment->evaluate_star_list as $key => $childRate)
                  @if($childRate->display_flg)
                  {{ $childRate->evaluation_name_star_short.' '. numberFormat($childRate->evaluation_star, 1).' | ' }}
                  @endif
                @endforeach
                ］
                @endif
              </span>
              <div class="comment">
                <div class="comment-content">
                    @if (!empty($comment->image))
                        <img src="{{ httpsUrl($comment->image) }}">
                    @endif
                    <span>{{ $comment->content }}</span>
                </div>
                <p>{{ $comment->nickname }}</p>
                <span class="comment-date">投稿日：{{ dateFormat($comment->comment_date, '') }}</span>
              </div>
              </div>
            </a>
          </li>
          @endif
          @php $i++; @endphp
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
    @if(!empty($comments->items))
    <div class="more more-fix-css">
      <a href="{{ route('shop.comments',$shopId) }}" class="red-sp-nnn">{{ $shop->item->facility_name }}の口コミを見る</a>
    </div>
    @endif
</div>

<div class="shop-contents-unit">
    <h2>{{ $shop->item->facility_name }}の投稿写真</h2>
    @if(!empty($shopImages))
    <ul class="shop-information posts-photo clearfix">
        <?php $f = 0;?>
        @foreach($shopImages as $image)
            <?php $f++;?>
            @if($f <= 3)
                <li>
                    <img src="{{ httpsUrl($image) }}" class="wp-img-fix-sp">
                </li>
            @endif
        @endforeach
    </ul>
    @else
    <p>表示する投稿写真がありません</p>
    @endif
</div>

<div class="shop-contents-unit">
    @if($shop->item->coupon_tab == "1")
      <h2>クーポン</h2>
        <?php $f = 0;?>
        <p class="p-title-sdetail2" style="margin-top:30px;">クーポン</p>
        @foreach($shop->item->coupon_informations as $couponInformation)
            @if(!empty($couponInformation) && $f < 1)
                <?php $f++;?>
                <p class="off-sdetail">{{ $couponInformation->coupon_name }}</p>
                <div class="block-store-information">
                     利用条件：{{ $couponInformation->coupon_use_cond }}<br>提示条件：{{ $couponInformation->coupon_presentation_cond }}
                </div>
                <p style="font-weight: normal; margin-bottom:0px;" class="p-button p-button-whiteback p-button-lineH"><a href="{{ route('shop.coupon',$shopId) }}" class="arrow-down">すべてのクーポンを見る（{{ $numCoupon }}件）</a></p>
            @endif
        @endforeach
    @endif
</div>

<div class="shop-contents-unit">
    <h2>{{ $shopName }}の情報</h2>
    <table>
      <tr>
        <th style="width:30%;">店舗名</th>
        <td>{{ $shop->item->facility_name }}</td>
    </tr>
    <tr>
        <th>住所</th>
        <td>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</td>
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
          <a target="_blank" href="{{ $shop->item->site_url_pc }}" class="red-sp-nnn">{{ $shop->item->site_url_pc }}</a>
          @else
          ー
          @endif
        </td>
    </tr>
    <tr>
        <th>関連リンク</th>
        <td>
          <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url1 }}">{{$shop->item->related_links_title1}}</a>
          <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url2 }}">{{$shop->item->related_links_title2}}</a>
          <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url3 }}">{{$shop->item->related_links_title3}}</a>
          <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url4 }}">{{$shop->item->related_links_title4}}</a>
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
          @if ($shop->time_off()[0] != "-" && !empty($shop->worktime()))
            @foreach($shop->time_off() as $timeoff)
            {{$timeoff}}
            @endforeach
          @else
            ー
          @endif
        </td>
    </tr>
</table>
<div class="reportBtn">
  <a href="{{env('EPARK_CONTACT_NEW')}}">誤りのある情報の報告</a>
</div>
<div class="block-map-n">
    <div id="map" style="width:100%;height:200px" class="map-canvas"></div>
</div>
</div>

</div>
<script>
    $(document).ready(function(){
        if($('.shop-information .shop-info').outerHeight() <= 60){
            $('.shop-information .p-more').hide();
        }else{
            $('.shop-information .shop-info').addClass('short');
        }
    });

    $(document).on('click', '.shop-information .p-more', function(){
        $(this).siblings('.shop-information .shop-info').removeClass('short');
        $(this).addClass('p-less').removeClass('p-more').html('<i class="fa fa-angle-up up-down" aria-hidden="true"></i>もっと少なく読む');
    });

    $(document).on('click', '.shop-information .p-less', function(){
        $(this).siblings('.shop-information .shop-info').addClass('short');
        $(this).addClass('p-more').removeClass('p-less').html('<i class="fa fa-angle-down up-down" aria-hidden="true"></i>続きを読む');
    });

</script>
<style>
    .rate-top24 {
        display: inline-block;
        vertical-align: text-top;
        margin: 3px 0 -3px -1px;
    }
</style>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY', 'AIzaSyBY4tBJQ1ZdZpJhYGiDRAjxLSiGUjDR1Jo') }}&libraries=places&callback=initAutocomplete" async defer></script>
<script type="text/javascript">
    var map = null;
    function initAutocomplete() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: {{ $addr_latitude }}, lng: {{ $addr_longitude }} },
        zoom: 17,
        mapTypeId: 'roadmap'
    });

    function addMarker(feature) {
        var marker = new google.maps.Marker({
            position: feature.position,
            map: map,
            optimized:false
        });
    }

    var features = [
        {
            position: new google.maps.LatLng({{ $addr_latitude }},{{ $addr_longitude }}),
            type: 'image1'
          }
    ];

    for (var i = 0, feature; feature = features[i]; i++) {
        addMarker(feature);
    }
}
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

    $('#shopMainSlide').slick({
        dots: true, // スライダー下部に表示される、ドット状のページネーション
        infinite: true, // 無限ループ
        speed: 300, // 切り替わりのスピード
        autoplay: true, // オートプレイ
        autoplaySpeed: 4000, //オートプレイスピード4秒
        pauseOnFocus: false,
    });
    $('.slick-dots').on('click', function() {
        $('#shopMainSlide').slick('setOption', 'autoplay', true, true);
    });


  var now_offset;
  var menu_offset = $('.ul-menu-ch-mypage').offset().top;
  $(window).on('scroll', function () {
    now_offset = window.pageYOffset;
    $('body').toggleClass('menu_fixed', now_offset > menu_offset);
  })

});
$('.data-shop-id-'+{{$shopId}}).on('click', function() {
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
</script>
@stop
