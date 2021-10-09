@if(!empty($shopComments->items))
	@foreach($shopComments->items as $comment)
		<li>
			<a href="{{ route('shop.comment_detail', [$comment->target_id, $comment->comment_id]) }}" >
				@if(!empty($comment->image))
                    <img class="pro" src="{{ httpsUrl($comment->image) }}">
                @endif
				<div class="list-shop-info">
					<p class="list-shop-desc">{{ subString($comment->content_title, 25) }}</p>
					@if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                    @php
                        $bestPoints = (array) $comment->best_point_list;
                        $goodPoints = (array) $comment->good_point_list;

                        if (!empty($bestPoints)) {
                            $goodPoints = array_diff_key($goodPoints, $bestPoints);
                        }
                    @endphp
					<p class="p-yl mar-5-0">良かった点</p>
                    <ul class="listTab listTab-2">
                        @if (!empty($bestPoints))
                            @foreach($bestPoints as $point)
                            <li class="mar-bot-00 best-point"><span>{{ $point->evaluation_name_short }}</span></li>
                            @endforeach
                        @endif
                        @if (!empty($goodPoints))
                            @foreach($goodPoints as $point)
                            <li class="mar-bot-00"><span>{{ $point->evaluation_name_short }}</span></li>
                            @endforeach
                        @endif
                    </ul>
                    @endif
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
					<div style="clear:both; padding-top:5px">
						<p>{{ $comment->nickname }}<span>{{ dateFormat($comment->comment_date, 'yeah') }}/{{ dateFormat($comment->comment_date, 'mounth') }}/{{ dateFormat($comment->comment_date, 'day') }}</span></p>
					</div>
				</div>
			</a>
		</li>
	@endforeach
@endif
