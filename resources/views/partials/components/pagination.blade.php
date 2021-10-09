@php
    $params = request()->all();

    if (!empty($moreParams) && is_array($moreParams)) {
        $params = array_merge($params, $moreParams);
    }
@endphp
@if($paging['numPage'] > 1)
    <div class="paging">
        @if($paging['currentPage'] < 6 || $paging['currentPage'] >=  ($paging['numPage'] - 1))
            @if($paging['currentPage'] > 1)
                @php
                    $prev = $paging['currentPage'] - 1;
                    $queryStr = array_merge($params, ['page' => $prev]);
                @endphp
                <a class="prev" href="{{ request()->fullUrlWithQuery($queryStr) }}"></a>
            @endif
            <ul>
                @if($paging['numPage'] > 5)
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        @if($i <= 5)
                            <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    @if(($paging['numPage'] >= 8 ))
                    ･･･
                    @endif

                    <?php $preLast = $paging['numPage'] - 1;?>
                    @if($preLast > 5)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $preLast])) }}" class="{{ ($paging['currentPage'] == $preLast) ? 'active' : ''}}">{{ $preLast }}</a></li>
                    @endif
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $paging['numPage']])) }}" class="{{ ($paging['currentPage'] == $paging['numPage']) ? 'active' : ''}}">{{ $paging['numPage'] }}</a></li>
                @else
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                    @endfor
                @endif
            </ul>
            @if($paging['currentPage'] < $paging['numPage'])
                @php
                    $next = $paging['currentPage'] + 1;
                    $queryStr = array_merge($params, ['page' => $next]);
                @endphp
                <a class="next" href="{{ request()->fullUrlWithQuery($queryStr) }}"></a>
            @endif
        @else
            @if($paging['currentPage'] > 1)
                @php
                    $prev = $paging['currentPage'] - 1;
                    $queryStr = array_merge($params, ['page' => $prev]);
                @endphp
                <a class="prev" href="{{ request()->fullUrlWithQuery($queryStr) }}"></a>
            @endif
            <ul>
                @if($paging['numPage'] > 5)
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        @if($i <= 2)
                            <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                        @else
                            @if($i == 3)
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
                                @if($paging['currentPage'] < ($paging['numPage'] - 3))
                                ･･･
                                @endif
                            @endif
                        @endif
                    @endfor
                    <?php $preLast = $paging['numPage'] - 1;?>
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $preLast])) }}" class="{{ ($paging['currentPage'] == $preLast) ? 'active' : ''}}">{{ $preLast }}</a></li>
                    <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $paging['numPage']])) }}" class="{{ ($paging['currentPage'] == $paging['numPage']) ? 'active' : ''}}">{{ $paging['numPage'] }}</a></li>
                @else
                    @for($i = 1; $i <= $paging['numPage']; $i++)
                        <li><a href="{{ request()->fullUrlWithQuery(array_merge($params, ['page' => $i])) }}" class="{{ ($paging['currentPage'] == $i) ? 'active' : ''}}">{{ $i }}</a></li>
                    @endfor
                @endif
            </ul>
            @if($paging['currentPage'] < $paging['numPage'])
                @php
                    $next = $paging['currentPage'] + 1;
                    $queryStr = array_merge($params, ['page' => $next]);
                @endphp
                <a class="next" href="{{ request()->fullUrlWithQuery($queryStr) }}"></a>
            @endif
        @endif
    </div>
@endif
