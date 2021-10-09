@extends('layouts.mobile.shop-search')
@section('title', $titleDescriptionKeywordH1['title'])
@section('description', $titleDescriptionKeywordH1['description'])
@section('keywords', $titleDescriptionKeywordH1['keywords'])
@section('body.classes', 'shopsearch')
@section('content')
    @php
        $sort = request()->has('sort') ? request()->sort : '3';
        $pos = request()->has('pos') ? request()->pos : '';
        $sortText = $sort == 0 ? '新着順' : ($sort == 3 ? 'おすすめ順' : ($sort == 2 ? '口コミ順' : ''));
        $h1 = $titleDescriptionKeywordH1['h1'];
        $h1sub = 'の一覧 ' . numberFormat($paging['numFound'] ) . '件';
    @endphp

    <div id="fixed-control">
        @include('partials.search.mobile.shopsearch-control')
    </div>
	@if( $pos != '' )
		<div class="list-heading">
			<p>{{ $h1 }}</p>
		</div>
	@else
		<div class="list-heading list-heading-ct">
			@if(!empty($titleDescriptionKeywordH1['h1Coupon']))<span>{{$titleDescriptionKeywordH1['h1Coupon']}}</span>@endif{{ empty($searchResult['genre']) ? '' : $searchResult['genre'] . 'の' }}<h1>{{ $titleDescriptionKeywordH1['h1']}}</h1><span>{{ $h1sub }}</span>
		</div>
	@endif
	<div id="shoplist-list">
		@if(!empty($shops->items))
		<ul class="ul-list-shop-main">
			@foreach($shops->items as $shopId => $shop)
				<li class="shoplist-item">
					<h2 class="shop-name"><a href="{{ route('shop.index', $shopId) }}">{{ $shop->catalog_name }}</a></h2>
					@include('layouts.icon-box', ['epark_payment_use_flag' => $shop->epark_payment_use_flag])
					@if(!empty($shop->catch_copy))
					<div class="shop-comment">
						<p class="shop-catch-copy">{{ $shop->catch_copy }}</p>
					</div>
					@endif
					<div class="shop-information">
						@if(!empty($shop->images_url))
						<div class="shop-image">
							<a href="{{ route('shop.index', $shopId) }}">
								<img src="{{ httpsUrl($shop->images_url[0], 675) }}" alt="" class="crop-290px">
							</a>
						</div>
						@endif
                        @if(!empty($shop->main_image_s))
						<div class="cake-image">
							<a href="{{ route('shop.menu', $shopId) }}">
								<img src="{{ httpsUrl($shop->main_image_s, 675) }}" alt="" class="crop-290px">
							</a>
						</div>
                        @endif
						@if($shop->comment_evaluate_total != "" || (!empty($shop->comment_num) && $shop->comment_num > 0))
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
						@endif
					<p class="address-shop-icon"><a href="{{ route('shop.map', $shopId) }}"><span>{{ $shop->prov_name.$shop->city.$shop->district.$shop->building_name }}</span></a></p>
					@if (!empty($shop->station1))
					<p class="shop-access">{!! showNearestStation($shop) !!}</p>
					@endif
					@php $worktimeFlg = 0; @endphp
					@foreach(worktime($shop) as $worktime)
						@if(!empty($worktime["week"]) && !empty($worktime["time"]))
							@php $worktimeFlg++; @endphp
						@endif
					@endforeach
					@if($worktimeFlg > 0)
					<p class="shop-hour">
						@foreach(worktime($shop) as $worktime)
				        @if($loop->first)
				        <span>{{ $worktime["time"] }}</span>
				        @elseif(!empty($worktime["week"]) && !empty($worktime["time"]))
				        <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
				        @endif
				        @endforeach
					</p>
					@endif
					@if($worktimeFlg > 0)
						@if(time_off($shop)[0] != '-' || !empty($shop->calendar_comment))
						<p class="shop-holiday">
							@foreach(time_off($shop) as $timeoff)
					        <span class="span-timeoff">{{$timeoff}}</span>
					        @endforeach
					        {!! nl2br($shop->calendar_comment) !!}
					    </p>
					    @endif
					@endif
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
					<div class="itemBtn">
						@if($shop->contract_tp == "1")
						<p class="request_btn {{  $shopInfoRequestButton[$shopId]['userRequested'] ? 'request_btn_after' : '' }}"><a data-shop-id="{{ $shopId }}">掲載リクエスト<span class="count">{{ $shopInfoRequestButton[$shopId]['requestCount'] < 1000 ? str_pad($shopInfoRequestButton[$shopId]['requestCount'], 3, '0', STR_PAD_LEFT) : $shopInfoRequestButton[$shopId]['requestCount'] }}</span></a></p>
						@elseif($shop->contract_tp == "2" || $shop->contract_tp == "3")
							@if(empty($shop->shop_shopowner_id))
								<div class="favoriteBtn shopBtn"><a href="{{ route('shop.index', $shopId) }}">ショップ情報を見る</a></div>
							@else
								<div class="favoriteBtn shopBtn"><a href="{{ route('shop.index', $shopId) }}">ショップ情報を見る</a></div>
								<div class="reserveBtn menuBtn"><a href="{{ route('shop.menu', $shopId) }}">メニューを見る</a></div>
							@endif
						@endif
					</div>
				</li>
			@endforeach
		</ul>
		@else
		<p class="text-left" style="padding-left:15px;margin-top:20px;">検索結果がありません</p>
		@endif
        @include ("partials.components.mobile.pagination", ["list" => $shops, "paging" => $paging])
    </div>
    <script>
        $(function () {

            // display header when scroll on moblie
            if ($('#fixed-control').length) {
                var now_offset;
                var menu_offset = $('#fixed-control').offset().top;
                $(window).on('scroll', function () {
                    now_offset = window.pageYOffset;
                    $('body').toggleClass('control-fixed', now_offset > menu_offset);
                });
            }

        })
    </script>
    <script type="text/javascript">
		$(document).ready(function(){
            // $('.review-comment').each(function(index, el) {
            //     var shopId = $(el).attr('data-shop-id');
            //     $.ajax({
            //         url: '{{ route('shop.get_latest_review_of_shop') }}',
            //         type: 'post',
            //         data: {shopId: shopId},
            //     })
            //     .done(function(res) {
            //         if(res != ''){
            //             res = res.replace(/(?:\r\n|\r|\n)/g, '<br />');
            //             $(el).html(res);
            //         }else{
            //             $(el).parent('.div-wp-review').remove();
            //         }
            //     });
            // });

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

			$('.shop-image').each(function(index, el) {
				var width_img = $(el).find('img').width();
				$(el).find('img').css('height', width_img);
			});
			$('.cake-image').each(function(index, el) {
				var width_img = $(el).find('img').width();
				$(el).find('img').css('height', width_img);
			});

			$(window).resize(function(){
				$('.shop-image').each(function(index, el) {
					var width_img = $(el).find('img').width();
					$(el).find('img').css('height', width_img);
				});
				$('.cake-image').each(function(index, el) {
					var width_img = $(el).find('img').width();
					$(el).find('img').css('height', width_img);
				});
			});

		});
	</script>
<script type="text/javascript">
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
