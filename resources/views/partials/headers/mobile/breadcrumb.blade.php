@if($isLogin && \Route::currentRouteName() != 'index' && $isMobile)
    <script>setShopinfoLoader();</script>
@endif
@if (!empty($breadcrumb))
    <ul class="t-path pankuzu" style="margin-top:0;">
        @foreach ($breadcrumb as $item)
            @if ($loop->first)
                <li class="t-path-list"><a href="{{ $item['url'] }}" style="color:inherit">{{ $item['text'] }}</a></li>
            @elseif ($loop->last)

                @if( in_array($current_route_name, ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map']) )
                <li>
                 <span class="h1-inbl">{{ $item['text'] }}
                     @if(in_array($current_route_name, ['shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
                         @if(!request()->has('sort') || request()->sort == "3")
                             {{ "（ おすすめ順 ）" }}
                         @elseif(request()->sort == "0")
                             {{ "（ 新着順 ）" }}
                         @elseif(request()->sort == "2")
                             {{ "（ 口コミ順 ）" }}
                         @endif
                     @endif
                 </span>
                </li>
                @else
                <li><span class="h1-inbl">{{ $item['text'] }}
                    @if(in_array($current_route_name, ['shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
                        @if(!request()->has('sort') || request()->sort == "3")
                            {{ "（ おすすめ順 ）" }}
                        @elseif(request()->sort == "0")
                            {{ "（ 新着順 ）" }}
                        @elseif(request()->sort == "2")
                            {{ "（ 口コミ順 ）" }}
                        @endif
                    @endif
                </span></li>
                @endif

            @else
                @if (!empty($item['url']))
                    <li class="t-path-list"><span><a href="{{ $item['url'] }}" style="color:inherit">{{ $item['text'] }}</a></span></li>
                @else
                    <li><span>{{ $item['text'] }}</span></li>
                @endif
            @endif
        @endforeach
    </ul>
@endif
@if(in_array($current_route_name, ['noShopSearch']))
  <ul class="t-path pankuzu" style="margin-top:0;">
   <li class="t-path-list breadcrumb-style"><a href="{{ route('index') }}">EPARKスイーツガイド</a></li>
      <li><span>お探しの店舗の掲載は終了しました</span></li>
   </ul>
@endif
@if ($isMobile)
<script type="text/javascript">
    $(function () {
        var isOverflow = false;
        var MAX_HEIGHT = 56;
        var container  = $('.t-path.pankuzu');

        while (container.outerHeight() > MAX_HEIGHT) {
            isOverflow = true;
            var lastChild = container.children().last();
            var spanChild = lastChild.find('span');

            while (container.outerHeight() > MAX_HEIGHT && spanChild.text() != "") {
                var text = spanChild.text();
                spanChild.text(text.substr(0, text.length - 1));
            }

            var text = spanChild.text();
            if (text != '' && text.length > 2) {
                spanChild.text(text.substr(0, text.length - 2) + '...');
            } else {
                lastChild.remove();
            }
        }

        if (isOverflow) {
            var spanChild = container
                .children()
                .last()
                .find('span');

            if (spanChild.text() && spanChild.text().substr(-3) != '...') {
                spanChild.text(spanChild.text() + '...');
            }
        }
    });
</script>
@endif
