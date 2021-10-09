@extends('layouts.shop-search')
@section('title', $titleDescriptionKeywordH1['title'])
@section('description', $titleDescriptionKeywordH1['description'])
@section('keywords', $titleDescriptionKeywordH1['keywords'])
@section('body.classes', 'shopsearch')
@section('content')
@include('partials.headers.mobile.breadcrumb')
@include('masters.sidebar-shop')
@php
$sort = request()->has('sort') ? request()->sort : '3';
$sortText = $sort == 0 ? '新着順' : ($sort == 3 ? 'おすすめ順' : ($sort == 2 ? '口コミ順' : ''));
$toPage = ((($paging['currentPage'] * 20) + 1) > $paging['numFound']) ? $paging['numFound'] : ($paging['currentPage'] * 20);
$startPage = 0;
if ((int) $paging['numFound'] > 0){
	$startPage = numberFormat(($paging['currentPage'] * 20) - 19);
}
$h1sub = '(' .$sortText . ')' . $startPage . '〜' .numberFormat($toPage) . '件を表示 | 全' . numberFormat($paging['numFound'] ) .'件';
@endphp
<div class="block-right">
	<div class="list-hdr">
		<p class="search-h1 shop">ケーキ屋さん・スイーツ店一覧</p>
		@php
		$sort = request()->has('sort') ? request()->sort : '3';
		@endphp
		<ul class="nav-order shop pull-right">
			<li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->fullUrlWithQuery($params) }}">新着順</a></li>
			<li><a @if($sort == 3) class="active" @endif @php $params['sort'] = 3 @endphp href="{{ request()->fullUrlWithQuery($params) }}">おすすめ順</a></li>
			<li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->fullUrlWithQuery($params) }}">口コミ順</a></li>
		</ul>
	</div>

	<div class="list-current list-current-ct">
		@if(!empty($titleDescriptionKeywordH1['h1Coupon']))<span>{{$titleDescriptionKeywordH1['h1Coupon']}}</span>@endif{{ empty($searchResult['genre']) ? '' : $searchResult['genre'] . 'の' }}<span>{{ $titleDescriptionKeywordH1['h1']}}{{ $h1sub }}</span>
	</div>
	@if(!empty($shops->items))
	<ul class="ul-list-shop-main">
		@foreach($shops->items as $shopId => $shop)
		<li class="shoplist-item">
            <div class="shop-name">
                <p class="name"><a href="{{ route('shop.index', $shopId) }}">{{ $shop->catalog_name }}</a></p>
				@include('layouts.icon-box', ['epark_payment_use_flag' => $shop->epark_payment_use_flag])
            </div>
			<div class="shop-image">
				@if(!empty($shop->images_url))
    				<a href="{{ route('shop.index', $shopId) }}" style="display: inline-block; width: 150px">
                        <span class="card-cover__wrapper">
                            <span class="card-cover__content" style="background-image: url({{ httpsUrl($shop->images_url[0], 180) }})"></span>
        					<img src="{{ httpsUrl($shop->images_url[0], 180) }}" alt="お店の写真" class="crop-150px">
                        </span>
    				</a>
				@endif
                @if(!empty($shop->main_image_s))
    				<a href="{{ route('shop.menu', $shopId) }}" style="display: inline-block; width: 150px">
                        <span class="card-cover__wrapper">
                            <span class="card-cover__content" style="background-image: url({{ httpsUrl($shop->main_image_s, 180) }})"></span>
        				    <img src="{{ httpsUrl($shop->main_image_s, 180) }}" alt="ケーキの写真" class="crop-150px">
                        </span>
    				</a>
                @endif
			</div>
			<div class="shop-comment">
				@if(!empty($shop->catch_copy))
				<p class="shop-catch-copy">{{ $shop->catch_copy }}</p>
				@endif
				<p class="info-shop-detail short">{{ subString($shop->list_comment, 77) }}<a href="{{ route('shop.index', $shopId) }}" class="btn-more">ショップ詳細を見る</a></p>
            </div>
			<div class="shop-review">
				@if($shop->comment_evaluate_total != "")
				<div class="review-rating">
					<div class="rate-group rate-top24 rate-top-r">
						<div class="rateit"
							data-rateit-readonly="true"
							data-rateit-resetable="false"
							data-rateit-starwidth="24"
							data-rateit-starheight="18"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-value="{{ $shop->comment_evaluate_total }}"
							data-rateit-step="0.1">
						</div>
						<span class="rate-np">{{ numberFormat($shop->comment_evaluate_total, 1) }}</span>
					</div>
				</div>
				@endif
				@if(!empty($shop->comment_num) && $shop->comment_num > 0)
					<dl class="review-number">
						<dt><a href="{{ route('shop.comments', $shopId) }}">口コミ</a></dt>
						<dd>{{ $shop->comment_num.'件'}}</dd>
					</dl>
				@endif
				</div>
				<div class="shop-data">
					<ul>
						<li class="address-shop-icon">
							<a href="{{ route('shop.map', $shopId) }}"><span>{{ $shop->prov_name.$shop->city.$shop->district.$shop->building_name }}</span></a>
						</li>
                        @if (!empty($shop->station1))
						<li class="shop-access">{!! showNearestStation($shop) !!}</li>
                        @endif
						<li class="shop-open-hour">
							@php $flg = 0; @endphp
							@foreach(worktime($shop) as $worktime)
					        @if($loop->first)
					        	@if(!empty($worktime["time"]))
					        		@php $flg++ @endphp
					        	@endif
					        <span>{{ $worktime["time"] }}</span>
					        @elseif(!empty($worktime["week"]) && !empty($worktime["time"]))
				        		@php $flg++ @endphp
					        <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
					        @endif
					        @endforeach
						</li>
						@if($flg)
							<li class="shop-closed">
							@foreach(time_off($shop) as $timeoff)
					        <span class="span-timeoff">{{$timeoff}}</span>
					        @endforeach
        					{!! nl2br($shop->calendar_comment) !!}
					        </li>
        				@endif
					</ul>
				</div>
				@if(!empty($shopCategories[$shopId]))
                <div class="shop-category">
                    <ul class="ul-lists-category">
                        @foreach($shopCategories[$shopId] as $shopCateId => $shopCategoryName)
                        <li data-id="{{ $shopCateId }}">
                            <a href="{{ route('shop.menu', $shopId) }}">{{ $shopCategoryName }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
				<div class="shop-menu shop-{{ $shopId }}" data-link="{{ route('shop.index', $shopId) }}">
					<p>
						@if($shop->contract_tp == "1")
						<p class="request_btn {{  $shopInfoRequestButton[$shopId]['userRequested'] ? 'request_btn_after' : '' }}"><a data-shop-id="{{ $shopId }}">掲載リクエスト<span class="count">{{ $shopInfoRequestButton[$shopId]['requestCount'] < 1000 ? str_pad($shopInfoRequestButton[$shopId]['requestCount'], 3, '0', STR_PAD_LEFT) : $shopInfoRequestButton[$shopId]['requestCount'] }}</span></a></p>
						@elseif($shop->contract_tp == "2" || $shop->contract_tp == "3")
							@if(empty($shop->shop_shopowner_id))
								<a href="{{ route('shop.index', $shopId) }}" class="shop-button">ショップ情報を見る</a>
							@else
								<a href="{{ route('shop.index', $shopId) }}" class="shop-button">ショップ情報を見る</a>
								<a href="{{ route('shop.menu', $shopId) }}" class="menu-button">メニューを見る</a>
							@endif
						@endif
					</p>
				</div>
			</li>
			@endforeach
		</ul>
		@else
		<p class="text-left" style="padding-left:15px;margin-top:20px;">検索結果がありません</p>
		@endif
		@include ('partials.search.shopsearch-control')
		@include ("partials.components.pagination", compact("paging"))
	</div>
<script type="text/javascript">
    $(document).ready(function(){
		$('.shop-category').each(function(index, el) {
			if($(el).find('li').length < 1){
				$(el).remove();
			}
		});

		$('.span-timeoff').each(function(index, el) {
			if($(el).html() == '-'){
				$(el).remove();
			}
		});

	});
    $(document).on('click','.request_btn a', function(e){
    	var _this = $(this);
    	var requesting = _this.parent().hasClass('request_btn_after') ? true : false;
    	var shopId = _this.attr('data-shop-id');
    	var url = window.location.origin + "/shop/" + shopId + "/requests";
        if (!requesting) {
            requesting = true;
            $.ajax({
                url: url,
                method: "POST",
            }).done(function (res) {
            	if(_this.parent().hasClass('request_btn_after')){
                	_this.parent().removeClass('request_btn_after', res.user_requested == false);
            	}else{
                	_this.parent().addClass('request_btn_after', res.user_requested == false);
            	}
                _this.parent().find('.count').html(res.request_count_pad);
                requesting = true;
            });
        }

    });
</script>
@stop
