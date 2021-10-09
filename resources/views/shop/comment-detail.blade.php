@php
$comment_title = isset($comment->items[0]->content_title) ? $comment->items[0]->content_title : '';
$page_title = isset($shop->item->page_title) ? $shop->item->page_title : '';
@endphp
@extends('layouts.index_child_2')
@section('title', '口コミ'.$comment_title.'｜'.$page_title)
@section('body.classes', 'shop-index')
@section('content')
<ul class="t-path">
    <li class="t-path-list"><span><a href="{{ route('index') }}" style="color: inherit;">EPARKスイーツガイド</a></span></li>
    @if(!empty($region))
        <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a></span></li>
        @if(!empty($subRegion))
            <li class="t-path-list"><span><a href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a></span></li>
        @endif
    @endif
    @if(!empty($shop->item))
        <li class="t-path-list"><span><a href="{{ route('shop.index', ['id' => $shopId]) }}" style="color: inherit;">{{ $shop->item->facility_name }}</a></span></li>
    @else
        <li class="t-path-list"><span>{{ $comment->items[0]->target_name }}</span></li>
    @endif
    <li class="t-path-list"><a href="{{ route('shop.comments', $shopId) }}"><span>口コミ</span></a></li>
    <li class="t-path-list"><h1><span></span>{{ $comment->items[0]->content_title }}</h1></li>
</ul>
@php
$comment = $comment->items[0];
@endphp
<h2 class="no-BrdT">{{ $comment->content_title }}</h2>
<div class="block-as w-800px pull-left no-bor-bot">
    @if($comment->service_id == 'sweetsshop' || $comment->service_id == 'sweetsproduct')
    @if($comment->target_type == '2')
    <table class="table-star">
        <tr>
            <td>総合</td>
            <td>
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
        </td>
    </tr>
    @foreach ($comment->evaluate_star_list as $rate)
    <tr>
        <td>
            <span>{{ $rate->evaluation_star_name }}</span>
        </td>
        <td>
            <div class="rate-group rate-top19">
                <div class="rateit"
                    data-rateit-readonly="true"
                    data-rateit-resetable="false"
                    data-rateit-starwidth="19"
                    data-rateit-starheight="15"
                    data-rateit-min="0"
                    data-rateit-max="5"
                    data-rateit-value="{{ $rate->evaluation_star }}"
                    data-rateit-step="0.1">
                </div>
                <span class="rate-np">{{ numberFormat($rate->evaluation_star, 1) }}</span>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@endif
@endif

</div>
@if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
@php
    $bestPoints = (array) $comment->best_point_list;
    $goodPoints = (array) $comment->good_point_list;

    if (!empty($bestPoints)) {
        $goodPoints = array_diff_key($goodPoints, $bestPoints);
    }
@endphp
<ul class="listTab w-800px" style="margin-top: 10px;float: left;margin-left: 0;">
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
@endif
<p class="right-2 pull-right mar-t-10px"><a class="jsLike" data-service-id="{{ $comment->service_id }}"><span>参考になった</span><strong class="num-like">{{ intval($comment->reference_count) }}</strong></a></p>
</div>
<div class="block-content bor-top-doted" style="width:960px;">
    <p>{!! str_replace(["\r", "\r\n"], '<br>', $comment->content) !!}</p>
    @if(isset($comment->image_list) && !empty($comment->image_list))
        @foreach($comment->image_list as $commentImg)
            <a data-lightbox="example-set" href="{{ $commentImg->image }}"><img src="{{ httpsUrl($commentImg->image) }}" style="margin-bottom:20px;" class="img-comment thumb-reviews-fix"></a>
        @endforeach
    @endif
    <div class="block-as block-as-no-bor clear-both">
        <div class="block-img-as">
            {{ $comment->nickname }}
        </div>
        <p class="p-date dis-inline-bl">投稿日: {{ $comment->comment_date }}</p>


    </div>
</div>
<p class="p-href bdT"><a href="{{ route('shop.comments',['id' => $shopId]) }}">一覧に戻る</a></p>
<script type="text/javascript">
    $(document).on('click', '.jsLike', function(){
        var data_service_id = $(this).attr('data-service-id');
        $.ajax({
            url: '{{ route("product.like_comment") }}',
            type: 'POST',
            dataType: 'JSON',
            data: {dataServiceId: data_service_id, commentId: '{{ $commentId }}', "_token": "{{ csrf_token() }}"},
        })
        .done(function(res) {
            if(res){
                $('.num-like').html(res);
            }
        });
        $(this).addClass('p-button-pink-active');

    });

    lightbox.option({
      'showImageNumberLabel' :false
    })
</script>
@stop
