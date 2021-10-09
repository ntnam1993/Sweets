@php
$comment_title = isset($comment->items[0]->content_title) ? $comment->items[0]->content_title : '';
$page_title = isset($shop->item->page_title) ? $shop->item->page_title : '';
@endphp
@extends('layouts.mobile.shop')
@section('title', '口コミ'.$comment_title.'｜'.$page_title)
@section('content')
<h3 class="h3-noTextR">
	<span>口コミ詳細</span>
</h3>
@php
$comment = $comment->items[0];
@endphp
<p class="p-title-top">{{ $comment->target_name }}</p>
<div class="info-cake">
	<p class="info-cake-titpe mar-bot-5px">{{ $comment->content_title }}</p>
    @if($comment->target_type == '2')
    <div class="rate-kb clearfix">
        <div class="start">
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
        @if(!empty($comment->evaluate_star_list) && $comment->target_type == '2')
        <span class="rate-np rate-np-l">
            @foreach($comment->evaluate_star_list as $evaluateStarList)
            {{ $evaluateStarList->evaluation_star_name.numberFormat($evaluateStarList->evaluation_star,1).'&nbsp;' }}
            @endforeach
        </span>
        @endif
        </div>
    </div>
    @endif

    @if (!empty($comment->good_point_list) || !empty($comment->good_point_list))
    @php
        $bestPoints = (array) $comment->best_point_list;
        $goodPoints = (array) $comment->good_point_list;

        if (!empty($bestPoints)) {
            $goodPoints = array_diff_key($goodPoints, $bestPoints);
        }
    @endphp
    <p class="p-yl">良かった点</p>
    <ul class="listTab listTab-2 mar-bot-5px">
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
  <p class="info-cake-content">{{ $comment->content }}</p>
  @if(isset($comment->image_list) && !empty($comment->image_list))
  <div class="img0mgr-0">
    @foreach($comment->image_list as $commentImg)
    <a data-lightbox="example-set" href="{{ $commentImg->image }}" class="a-fix-maxheight"><img src="{{ httpsUrl($commentImg->image) }}" style="margin-bottom:5px" class="col-3img"></a>
    @endforeach
  </div>
  @endif
</div>
<div class="list-shop-info mar-bot-5px">
  <div style="clear:both; padding-top:5px">
    <p>{{ $comment->nickname }}<span>{{ dateFormat($comment->comment_date, 'yeah') }}/{{ dateFormat($comment->comment_date, 'mounth') }}/{{ dateFormat($comment->comment_date, 'day') }}</span></p>
  </div>
</div>

<p class="p-button p-button-pink jsLike" data-service-id="{{ $comment->service_id }}">
  <span class="like-span">参考になった</span>
</p>
<?php $referenceCount = ('' != $comment->reference_count) ? $comment->reference_count : 0?>
<p class="like-cake"><span class="num-like">{{ $referenceCount }}</span>人が「参考になった」と言っています。</p>
</div>
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
      'showImageNumberLabel' :false,
      'alwaysShowNavOnTouchDevices': true
    })
</script>
<script src="/assets/dist/js/lightbox-plus-jquery.min.js"></script>
@stop
