@extends('layouts.index_child_2')
@php
$shopName = isset($shop->item->facility_name) ? strip_tags($shop->item->facility_name) : '';
$stationName = isset($shop->item->station1) ? strip_tags($shop->item->station1) : '';
$page = (request()->has('page') && (int) request()->page > 0) ? '（おすすめ順・' . request()->page . 'ページ目）' : '';
$pageForDescription = (request()->has('page') && (int) request()->page > 0) ? '('.request()->page.'ページ目)' : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = isset($shop->item->page_title) ? $shop->item->page_title : '';
$description = isset($shop->item->meta_description) ? $shop->item->meta_description : '';
@endphp
@section('title', '口コミ｜'.$title)
@section('description', $description)
@section('body.classes', 'shop-index')
@section('content')
@section("container.class", "css-new")
<div class="pc-content">
  <ul class="t-path">
        <li class="t-path-list"><span><a href="{{ route('index') }}" style="color: inherit;">EPARKスイーツガイド</a></span></li>
        @if(!empty($region))
            <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug]) }}">{{strip_tags($region->category_name)}}</a></span></li>
            @if(!empty($subRegion))
                <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{strip_tags($subRegion->category_name)}}</a></span></li>
            @endif
        @endif
        <li class="t-path-list"><span><a href="{{ route('shop.index', ['id' => $shopId]) }}" style="color: inherit;">{{ strip_tags($shop->item->facility_name) }}</a></span></li>
        <li><span>口コミ</span></li>
    </ul>
    @include ("shop.partials.shop-info", compact("shopId", "shop"))
    @include ("partials.shop.list-tab", compact("shopId"))
    <div class="tab-content">
        <div id="lists-comments">
            <div id="comments-overlay" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; background-color: rgba(255, 255, 255, 0.8); display: none;">
                <img src="/assets/pc/images/loading.gif" style="width: 50px; padding-top: 50px;">
            </div>
            @if($shopComments->num_found > 0)
            <div id="comments-panel">
                @foreach($shopComments->items as $comment)
                <div class="clearfix bor-bot-div-rev">
                    @if($comment->vote_mode != "2")
                        @if(!empty($comment->image))
                        <div class="wp-img-180">
                            <img class="thumb-reviews thumb-reviews-fix" src="{{ httpsUrl($comment->image) }}">
                        </div>
                        @endif
                    @endif

                    <div class="ovef-hidden">
                        <p class="p-title-52 p-title-52-top-0"><a class="" href="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}" data-comment-id="{{ $comment->comment_id }}" data-comment-url="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}">{{ $comment->content_title }}</a></p>
                        @if($comment->service_id == 'sweetsshop' || $comment->service_id == 'sweetsproduct')
                        @if(!empty($comment->evaluate_star_total))
                        @if($comment->evaluate_star_total != '0')
                        @if($comment->vote_mode != "2")
                        @if($comment->target_type == '2')
                        <div class="text-left">
                            <div class="rate-group rate-top24 rate-top-r">
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
                        <div class="text-left div-l-0">
                            <ul class="listTab">
                                <li>良かった点：</li>
                                @if (!empty($bestPoints))
                                    @foreach($bestPoints as $point)
                                        <li class="best-point"><a>{{ $point->evaluation_name_short }}</a></li>
                                    @endforeach
                                @endif
                                @if (!empty($goodPoints))
                                    @foreach($goodPoints as $point)
                                        <li><a>{{ $point->evaluation_name_short }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @endif

                        <p class="p-desc-52 mar-10-td">{!! str_replace(["\r", "\r\n"], '<br>', $comment->content) !!}</p>

                        <div class="block-as block-as-no-bor">
                            <div class="block-img-as">
                                {{ $comment->nickname }}
                            </div>
                            <p class="p-date dis-inline-bl">投稿日: {{ $comment->comment_date }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @include ("partials.components.pagination", compact("paging"))

            @endif
        </div>
        <div class="review-posting">
            <div class="review-posting-g left">
                <h2 class="no-BrdT">口コミ・投稿をする</h2>
                <p>「{{ $shop->item->facility_name }}」へ投稿しよう</p>
                <ul class="list-green">
                    <li class="comment"><a href="{!! $postReviewUrl !!}" rel="nofollow"><span>口コミ投稿</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop
