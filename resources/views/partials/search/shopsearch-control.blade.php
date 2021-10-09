<div class="list-hdr">
    <h1 class="search-h1 shop">ケーキ屋さん一覧</h1>
    <p class="pull-right"><a href="{{ $searchLink }}" class="product-search">ケーキを探す</a></p>
    @php
        $sort = request()->has('sort') ? request()->sort : '3';
    @endphp
    <ul class="nav-order shop pull-right">
        <li><a @if($sort == 0) class="active" @endif @php $params['sort'] = 0 @endphp href="{{ request()->fullUrlWithQuery($params) }}">新着順</a></li>
        <li><a @if($sort == 3) class="active" @endif @php $params['sort'] = 3 @endphp href="{{ request()->fullUrlWithQuery($params) }}">おすすめ順</a></li>
        <li><a @if($sort == 2) class="active" @endif @php $params['sort'] = 2 @endphp href="{{ request()->fullUrlWithQuery($params) }}">口コミ順</a></li>
    </ul>
</div>
