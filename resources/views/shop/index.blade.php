@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$imageOg  = isset($shop->item->sub_image1) ? $shop->item->sub_image1 : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? $shop->item->page_title : '';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@extends('layouts.index_child_2',['imageOg' => $imageOg])
@section('title', $title)
@section('description', $description)
@section("container.class", "css-new shop-detail")
@section('body.classes', 'shop-index')
@section('content')
<div class="pc-content">
	<ul class="t-path">
		<li class="t-path-list breadcrumb-style"><span><a href="{{ route('index') }}">EPARKスイーツガイド</a></span></li>
        @if(!empty($region))
            <li class="t-path-list breadcrumb-style"><span><a href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a></span></li>
            @if(!empty($subRegion))
                <li class="t-path-list breadcrumb-style"><span><a href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a></span></li>
            @endif
        @endif
		<li><span>{{ $shop->item->facility_name }}</span></li>
	</ul>
	@include ("shop.partials.shop-info", compact("shopId", "shop"))
    @include ("partials.shop.list-tab", compact("shopId", "shop"))
<div id="1" class="tab-content" @if(isset($_GET['comment_id'])) style="display: none" @endif>
    <ul class="shop-slide" id="shopMainSlide">
        @foreach (range(1, 8) as $number)
            @if (!empty($shop->item->{"sub_image$number"}))
                <li class="fix-image-slider"><img src="{{ httpsUrl($shop->item->{"sub_image$number"}, 675) }}"></li>
            @endif
        @endforeach
    </ul>
    <ul class="shop-slide-thumbs" id="shopSlideThumbs"></ul>

    <div class="shop-list-h3">
        @if(!empty($shop->item->catch_copy))
            <h2>{{ $shop->item->catch_copy }}</h2>
        @endif
    </div>
    <p style="text-align:left;">{!! nl2br($shop->item->list_comment) !!}</p>
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
    @if (isset($products) && count($products) > 0)
        <div class="cake-list-h3">
            <h2>{{ $shopName }}のメニュー</h2>
        </div>
        <ul id="listCakes" class="viewed-store viewed-store-2 cake-list image-list height-ul">
            @foreach ($products as $product)
                <li class="li-id-prod li-not-ok li-id-prod-{{ $product->product_id }}" data-product-id="{{ $product->product_id }}">
                    <a href="{{ route('product.detail', [$product->product_id]) }}">
                    <span class="card-contain__wrapper">
                        <span class="card-cover__content" style="background-image: url({{ httpsUrl($product->product_image1, 675) }})"></span>
    					<img src="{{ httpsUrl($product->product_image1, 675) }}" class="img-186">
                    </span>
                    </a>
                    <div class="div-des-ul-l-2">
                        <p class="p-tit-ch-ul2"><a href="{{ route('product.detail', [$product->product_id]) }}"></a></p>

                        <p class="cake-name"><span style="font-weight: 700">{{ $product->product_name }}</span></p>

                        @if(!empty($product->product_price_by_size))
                            <div class="ul-sizes clearfix">
                                @foreach($product->product_price_by_size as $k => $v)
                                    @if(!empty($v))
                                        <div class="ul-sizes-item">{{ convertCakeSize($k) }}</div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @php
                            $listProductPrice = (array)$product->product_price_by_size;
                            $listProductPrice['product_price'] = $product->product_price;
                            $listProductPrice = array_unique($listProductPrice);
                            $isMultiSize = 0;
                            if(!empty($listProductPrice)){
                                $isMultiSize = array_filter($listProductPrice, function($val){
                                    return !empty($val) && $val != "";
                                });
                                $minPrice = count($isMultiSize) ? min((array)$isMultiSize) : '';
                                $isMultiSize = count($isMultiSize);
                            }
                        @endphp
                        @if (!empty($minPrice))
                            <p class="p-ch-tt-2 item-price" style="font-weight: bold;">{{ numberFormat($minPrice) }}円<span>（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
                        @endif
                    </div>
                    @if($product->reservation_flg == "1")
                        <div class="text-center pos-ab-bot-0"><p class="p-button p-button-green new-p-button p-resv-red text-cent" style="height: 42px;width: 180px!important;font-size: 16px;"><a class="reservation-btn cursor-ponter" href="{{ route('product.detail', $product->product_id) }}"><span class="pa-l-20">予約可</span></a></p></div>
                    @endif
                </li>
            @endforeach
        </ul>
        <a href="{{ route('shop.menu', [$shopId]) }}" class="a-more mar-bot-50">{{ $shop->item->facility_name }}のメニューをもっと見る</a>
    @endif

    <div class="shop-list-h3">
        <h2>{{ $shop->item->facility_name }}の紹介</h2>
    </div>
    <p style="text-align:left;">{!! nl2br($shop->item->introdyctory_essay) !!}</p>

    @if (!empty($shop->item->subhead8))
        <div class="shop-list-h3">
            <h2>{{ $shop->item->subhead8 }}</h2>
        </div>
        <div class="shop-info img-right">
            <div class="card-contain__wrapper contain__wrapper_right" style="float: right; width: 470px">
                <div class="card-contain__content" style="background-image: url({{ httpsUrl($shop->item->sub_image8) }})"></div>
                <img src="{{ httpsUrl($shop->item->sub_image8) }}">
            </div>
            <p>{!! nl2br($shop->item->explanation8) !!}</p>
        </div>
    @endif
    @php
        $shop_news = (array) $shop->item->shop_news;
        $count = 0;
    @endphp
    @if(!empty($shop_news))
    @foreach ($shop_news as $name => $news)
        @if (!empty($news) && $news->display_flg == "1")
            @php $count++ @endphp
        @endif
    @endforeach
    @endif
    @if($count)
    <div class="shop-list-h3">
        <h2>ショップからのお知らせ</h2>
    </div>
    @endif
    <div class="shop-info">
        @foreach ($shop_news as $name => $news)
        @if (!empty($news) && $news->display_flg == "1")
            <h3>{{ $news->news_title }}</h3>
            <p style="text-align:left;">{!! nl2br($news->news_text) !!}</p>
        @endif
        @endforeach
    </div>

    <div class="shop-list-h3">
        <h2>ショップ情報</h2>
    </div>
    @foreach (range(1, 7) as $index => $number)
    @if (!empty($shop->item->{"sub_image$number"}) || !empty($shop->item->{"subhead$number"}) || !empty($shop->item->{"explanation$number"}))
    <div class="shop-info clearfix {{ ($number % 2 == 0) ? "img-right" : "img-left" }}">
        @if (!empty($shop->item->{"sub_image$number"}))
            <div class="card-contain__wrapper {{ ($index % 2 == 0) ? 'contain__wrapper_left' : 'contain__wrapper_right' }}" style="float: {{ ($number % 2 == 0) ? 'right' : 'left' }}; width: 470px;">
                <div class="card-contain__content" style="background-image: url({{ httpsUrl($shop->item->{"sub_image$number"}, 675) }})"></div>
                <img src="{{ httpsUrl($shop->item->{"sub_image$number"}, 675) }}" alt="">
            </div>
        @endif
        <h3>{{ $shop->item->{"subhead$number"} }}</h3>
        <p class="text-left">
            @if (mb_strlen($shop->item->{"explanation$number"}) <= 300)
                {!! nl2br($shop->item->{"explanation$number"}) !!}
            @else
                {!! nl2br(mb_substr($shop->item->{"explanation$number"}, 0, 300)) !!}<span style="display:none;">{!! nl2br(mb_substr($shop->item->{"explanation$number"}, 300)) !!}</span><a class="show-more" href="javascript:void(0);">＜文章をもっと見る＞</a>
            @endif
        </p>
    </div>
    @endif
    @endforeach
    @include('shop.partials.working-time')
    @if(!empty($shop->item->calendar_comment))
    <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
    @endif

    <div class="cake-list-h3">
        <h2>ご予約に関する注意事項</h2>
    </div>
    <div class="shop-info">
        <p class="text-left">{!! nl2br($shop->item->reservations_notes) !!}</p>
    </div>

    <div class="item-detil new-detil pList-icon">
        <h2>{{ $shop->item->facility_name }}の口コミ</h2>
        @if(!empty($comments->items))
            <a href="{!! $postReviewUrl !!}" class="post-button" rel="nofollow"><span>口コミ投稿</span></a>
        @endif
    </div>
    @if (!empty($comments->items))
        <ul class="item-comment-list">
            @foreach ($comments->items as $comment)
                <li class="item-comment">
                    @if ($comment->vote_mode != "2")
                        @if (!empty($comment->image))
                        <div class="evaluation">
                            <div class="evaluation-img"><img src="{{ httpsUrl($comment->image) }}" alt="" class="thumb-reviews-fix-255"></div>
                        </div>
                        @endif
                    @endif
                    <div class="reviews" style="{{ $comment->vote_mode == "2" || empty($comment->image) ? 'width:100%' : '' }}">
                        <a href="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}"><span class="item-name">{{ $comment->content_title }}</span></a>
                        @if($comment->service_id == 'sweetsshop' || $comment->service_id == 'sweetsproduct')
                        @if(!empty($comment->evaluate_star_total))
                        @if($comment->evaluate_star_total != '0')
                        @if($comment->vote_mode != "2")
                        @if($comment->target_type == '2')
                        <div class="summary summary-shop">
                            <ul>
                                <li class="total">
                                    @if ($comment->evaluate_star_total != "")
                                        <div class="rate-group rate-top28">
                                            <div class="rateit"
                                                data-rateit-readonly="true"
                                                data-rateit-resetable="false"
                                                data-rateit-starwidth="28"
                                                data-rateit-starheight="22"
                                                data-rateit-min="0"
                                                data-rateit-max="5"
                                                data-rateit-value="{{ $comment->evaluate_star_total }}"
                                                data-rateit-step="0.1">
                                            </div>
                                            <span class="rate-np">{{ numberFormat($comment->evaluate_star_total, 1) }}</span>
                                        </div>
                                        <span class="rate-detail">{{ rate_detail_string($comment->evaluate_star_list) }}</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        @endif
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
                        <div class="summary summary-shop">
                            <ul class="listTab listTab-2 list-point">
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
                        </div>
                        @endif

                        <div class="comment">
                            <span>{{ $comment->content }}</span>
                            <div>
                                <span class="comment-date pull-right">投稿日：{{ date('Y/m/d H:i:s', strtotime($comment->comment_date)) }}</span>
                                <span class="nickname pull-left">{{ $comment->nickname }}</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <a href="{{ route("shop.comments", $shopId) }}" class="a-more mar-bot-50">{{ $shop->item->facility_name }}の口コミを見る</a>
    @else
        <div class="no-comment">
            <span class="bold">口コミ・写真はまだ投稿されていません。</span>
            <p>このお店に訪れたことがある方は、<br/>最初の口コミ・投稿をしてみませんか？</p>
            <a href="{!! $postReviewUrl !!}" class="fff-link" rel="nofollow"><span>口コミ・写真投稿</span></a>
        </div>
    @endif

    <div class="camera-list-h3">
        <h2>{{ $shop->item->facility_name }}の投稿写真</h2>
        @php
            $fiveImages = array_slice($shopImages, 0, 5);
        @endphp
        @if (!empty($shopImages) && count($shopImages) > 0)
            <ul class="viewed-store viewed-store-2 image-list">
                @foreach($fiveImages as $image)
                <li class="wid-183">
                    <a data-lightbox="example-set" href="{{ $image }}" class="wp-img-183"><img src="{{ httpsUrl($image) }}" class="img-186 thumb-reviews-fix-183"></a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('shop.comments', ['id' => $shopId]) }}" class="a-more mar-bot-50">投稿写真をもっと見る</a>
        @else
            <p class="align-left">表示する投稿写真がありません</p>
        @endif
    </div>

    <div class="camera-list-h3">
        @if($shop->item->coupon_tab == 1)
        <h2>クーポン</h2>
            @foreach($shop->item->coupon_informations as $couponInfo)
                @if(!empty($couponInfo))
                <div class="coupon-container">
                    <div class="bg-kb6">
                        <a href="#"><img class="img120" src="{{ httpsUrl($shop->item->main_image, 180) }}"></a>
                        <div class="block-120">
                            <p class="p1-kb6">
                                <a href="#" class="link-t-path-border-2">{{ $shop->item->facility_name }}
                                </a>
                                <a class="sprint"><img src="/assets/pc/images/icon-kb6.png"></a>
                            </p>
                            <p class="p2-kb6">
                                <a href="#" class="link-t-path-border-2">{{ $couponInfo->coupon_name }}</a>
                            </p>
                            <div class="block-textare">
                                <a href="#" class="link-t-path-border-2">
                                    利用条件：{{ $couponInfo->coupon_use_cond }}<br>提示条件：{{ $couponInfo->coupon_presentation_cond }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        @endif
    </div>


    <div class="shop-detil">
        <h2>{{ $shop->item->facility_name }}の情報</h2>
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
                    @if ($shop->time_off()[0] != "-" && !empty($shop->worktime()))
                        @foreach($shop->time_off() as $timeoff)
                        <span>{{$timeoff}}</span>
                        @endforeach
                    @else
                        ー
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div class="reportBtn">
        <a href="{{env('APP_URL')}}/{{env('ENQUETEEDIT')}}">誤りのある情報の報告</a>
    </div>
    <div class="block-map-n">
        <div id="map" style="width:100%;height:290px" class="map-canvas"></div>
    </div>

    <div class="search-wrap">
        <div class="search-wrap-inner">
            <div class="item-search">
                <h2>市町村から探す</h2>
            </div>
            @if (!empty($citySiblings) && count($citySiblings) > 0)
                <ul class="search-cities">
                    @foreach($citySiblings as $i=>$v)
                    <li><a href="{{ route('product.index', ['region' => $region->slug, 'sub_region' => $v->slug]) }}">{{ $v->category_name }}</a></li>
                    @endforeach
                </ul>
            @endif

            <div class="item-search">
                <h2>都道府県から探す</h2>
            </div>
            @include ('partials.components.parent-regions')
        </div>
    </div>

    <div class="about-sweetsguide">
        <div class="h3">
            <h2>EPARKスイーツガイドとは？</h2>
        </div>
        <p class="what-sweets">「EPARKスイーツガイド」では、日本最大級の6,000点以上の商品情報から誕生日ケーキを予約できます。地域や路線、現在地情報をもとにお店を絞り込んだり、有名なパティスリーから地元密着型のケーキ屋さん、デパートや駅構内などのショッピングモールに入っているケーキ屋さんなど、自分にあった誕生日ケーキを探すことが可能です。様々な記念日やシーンにご利用を頂けるように、定番の生デコレーションケーキを始め、女子会や子供に人気なプリントケーキ、キャラクターケーキ、パーティーなどの結婚式二次会・イベント・サークルの打ち上げでおすすめな大型ケーキまで、幅広く品揃えをご用意しております。会員登録料や利用料、年会費、すべて無料！24時間予約可能な誕生日ケーキ情報が探せるので、お子様がいる主婦の方から、お仕事で忙しいお勤めの方まで幅広くご利用頂いております。</p>
    </div>
</div>
</div>
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
        $("#listCakes > li").each(function (index) {
            var self = $(this);
            maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
        });
        $("#listCakes > li").css("height", (maxHeight + $("#listCakes > li .mar-top10").height()) + "px");
        if (callback) callback();
    }
    $(document).ready(adjustCakeNameHeight(adjustCakeItemHeight));

	$(document).ready(function() {
		$('.sprint').click(function() {
			var mainContainer = $(this).closest('.coupon-container').clone();
			var printWindow = window.open('', 'PRINT', 'height=768,width=1024');
			mainContainer.find('.sprint').remove();
			printWindow.document.write('<html><head><title>Print it!</title>');
			printWindow.document.write('<style>');
			printWindow.document.write('a{color:inherit;text-decoration:none;float:left}');
			printWindow.document.write('.bg-kb6{height:140px;width:960px;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;padding:10px;text-align:left;margin:20px 0 50px 0}');
			printWindow.document.write('.block-120{display:block;overflow:hidden;text-align:left;width:790px}');
			printWindow.document.write('.img120{width:120px;height:120px}');
			printWindow.document.write('.block-120{display:block;overflow:hidden;text-align:left;float:left;margin-left:35px}');
			printWindow.document.write('.p1-kb6{display:block;color:#936945;position:relative;font-size:14px;font-weight:bold;height:24px;margin:0}');
			printWindow.document.write('.p1-kb6 span{display:inline-block;color:#c71319;margin-left:15px;font-size:12px}');
			printWindow.document.write('.p2-kb6{font-size:18px;display:block;padding-left:40px;color:#936945;padding-top:2px;margin:0}');
			printWindow.document.write('.block-textare{background:#ffffff;border:2px solid #936945;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;padding:8px 10px;font-size:12px;text-align:left;margin-top:11px;line-height:20px;display:inline-block;width:760px}');
			printWindow.document.write('.block-textare a{color:#333333}');
			printWindow.document.write('</style>');
			printWindow.document.write('</head><body><div style="width: 960px; height: 140px">');
			printWindow.document.write('<img style="position:absolute;top:20px;left:10px;z-index:-1" src="/assets/pc/images/bg-kb6.png">');
			printWindow.document.write('<img style="position:absolute;top:58px;left:170px" src="/assets/pc/images/icon-off.png">');
			printWindow.document.write(mainContainer.html());
			printWindow.document.write('</div></body></html>');
			printWindow.document.close();
			printWindow.focus();
			printWindow.print();
			printWindow.close();
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

		$('script').each(function(){
	        if($(this).attr('src') == '/assets/pc/js/jquery.dotdotdot.min.js'){
	            $('.three-lines').dotdotdot();
	        }
	    });

	});
	var _height_ul = $('.height-ul').height() + 45;
    $('.height-ul > li').css('height', _height_ul+'px');
    $(function () {
        $('#shopMainSlide').slick({
            autoplay: true,
            asNavFor: '#shopSlideThumbs',
            adaptiveHeight: true,
            dots: true,
        });
        $('#shopSlideThumbs').slick({
            slidesToShow: 8,
            asNavFor: '#shopMainSlide',
            focusOnSelect: true
        });
        $('.slick-dots').on('click', function() {
            $('#shopMainSlide').slick('setOption', 'autoplay', true, true);
        });
    });
    $(document).on("click", ".show-more", function (e) {
        e.preventDefault();
        $(this).prev().show();
        $(this).attr("class", "collapse-link").text("<閉じる>");
    });
    $(document).on("click", ".collapse-link", function (e) {
        e.preventDefault();
        $(this).prev().hide();
        $(this).attr("class", "show-more").text("＜文章をもっと見る＞");
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
