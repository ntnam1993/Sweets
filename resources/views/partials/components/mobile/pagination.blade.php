{{-- BEGIN .paging --}}
@php
    $params = request()->all();

    if (!empty($moreParams) && is_array($moreParams)) {
        $params = array_merge($params, $moreParams);
    }
@endphp
@if (!empty($list->items) || !empty($list->item))
    <div class="paging mar-top-20">
        <div class="controls">
            @php
                $toPage = ((($paging['currentPage'] * $paging["numCount"]) + 1) > $paging['numFound']) ? $paging['numFound'] : ($paging['currentPage'] * $paging["numCount"]);
                $startPage = 0;
                if((int)$paging['numFound'] > 0){
                    $startPage = numberFormat(($paging['currentPage'] * $paging["numCount"]) - ($paging["numCount"] - 1));
                }
            @endphp

            @php
                $prev = $paging['currentPage'] - 1;
                $queryStr = array_merge($params, ['page' => $prev]);
            @endphp
            <a class="prev dis-bl-mb {{ ($paging['currentPage'] <= 1) ? "invisible" : "" }}" href="{{ request()->fullUrlWithQuery($queryStr) }}">前へ</a>
            <p class="text-center"><strong>{{ numberFormat($paging['numFound'] ) }}件</strong>中<strong>{{ $startPage }}〜{{ numberFormat($toPage) }}件</strong>を表示</p>
            @php
                $next = $paging['currentPage'] + 1;
                $queryStr = array_merge($params, ['page' => $next]);
            @endphp
            <a class="next dis-bl-mb {{ ($paging['currentPage'] >= $paging['numPage'] ? "invisible" : "") }}" href="{{ request()->fullUrlWithQuery($queryStr) }}">次へ</a>
        </div>
        @if($paging['numPage'] > 1)
        <div class="paging">
        @if($paging['currentPage'] < 2 || $paging['currentPage'] >=  ($paging['numPage'] - 1))
            <ul>
                @if($paging['numPage'] > 2)
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                    @if($paging['currentPage'] <= $paging['numPage'] - 2)
                        @if($i <= 2)
                            <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                        @endif
                    @else
                        @if($i <= 1 && $paging["currentPage"] != 2)
                            <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                        @endif
                    @endif
                    @endfor
                    @if($paging['numPage'] >= 4 )
                    ･･･
                    @endif

                    <?php $preLast = $paging['numPage'] - 1;?>
                    @if($paging['currentPage'] < $paging['numPage'] && $paging['currentPage'] > 1)
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $preLast - 1])) }}" class="{{ ($paging['currentPage'] == $preLast - 1) ? 'active' : ''}}">{{ $preLast - 1 }}</a></li>
                    @endif
                    @if($preLast > 1 && $paging['currentPage'] > 1)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $preLast])) }}" class="{{ ($paging['currentPage'] == $preLast) ? 'active' : ''}}">{{ $preLast }}</a></li>
                    @endif
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $paging['numPage']])) }}" class="{{ ($paging['currentPage'] == $paging['numPage']) ? 'active' : ''}}">{{ $paging['numPage'] }}</a></li>
                @else
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                    @endfor
                @endif
            </ul>
        @else
            <ul>
                @if($paging['numPage'] > 2)
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        @if($i <= 1)
                            <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                        @else
                            @if($i == 2 && $paging['currentPage'] > 2 && $paging['currentPage'] > 3)
                                ･･･
                            @endif
                            @if($i == $paging['currentPage'] - 1)
                                <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                            @endif
                            @if($i == $paging['currentPage'])
                                <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                            @endif
                            @if($i == $paging['currentPage'] + 1 && $paging['currentPage'] < ($paging['numPage'] - 2))
                                <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                                @if($paging['currentPage'] < ($paging['numPage'] - 2))
                                ･･･
                                @endif
                            @endif
                        @endif
                    @endfor
                    <?php $preLast = $paging['numPage'] - 1;?>
                    @if(($paging['currentPage'] <= 2) || $paging['currentPage'] >= $paging['numPage'] - 2)
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $preLast])) }}" class="{{ ($paging['currentPage'] == $preLast) ? 'active' : ''}}">{{ $preLast }}</a></li>
                    @endif
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $paging['numPage']])) }}" class="{{ ($paging['currentPage'] == $paging['numPage']) ? 'active' : ''}}">{{ $paging['numPage'] }}</a></li>
                @else
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                    @endfor
                @endif
            </ul>

        @endif
        </div>
        @endif
    </div>
@endif
{{-- END .paging --}}
