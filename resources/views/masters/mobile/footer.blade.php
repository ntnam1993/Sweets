<?php $class = ('product.index' == $current_route_name) ? 'bor-footer-list-pro' : '';?>
<footer class="{{ $class }}">
    <span class="toppage"></span>
    <div class="ch-e-park">
        @if ($current_route_name == 'index')
            <p class="red-normal">EPARKスイーツガイド</p>
        @endif
        @if ($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a>
            @if(!empty($searchResult['region']) && $regionId != $parentRegion->id)
                ＞
                <a class="red-normal" href="{{ route('product.index', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], $canonicalParams)) }}" class="">{{ $regionName }}</a>
            @endif
            @if(!empty($searchResult['station']) && !empty($parentRegion))
                ＞
                <a class="red-normal" href="{{ route('product.index', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], $canonicalParams)) }}" class="">{{ $regionName }}</a>
            @endif
            @if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort))
                ＞{{ $titleDescriptionKeywordH1['h1'] }}
            @endif
            </p>
        @endif
        @if ($current_route_name == 'shop.index')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <span class="path-list-item">店舗詳細</span>
            </p>
        @endif
        @if ($current_route_name == 'shop.menu')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="red-normal path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item">メニュー</span>
            </p>
        @endif
        @if ($current_route_name == 'shop.photo')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="red-normal path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item">写真</span>
            </p>
        @endif
        @if (in_array($current_route_name, ['shop.comments', 'comments_shop', 'comments_product']))
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="red-normal path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item">口コミ</span>
            </p>
        @endif
        @if ($current_route_name == 'shop.coupon')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="red-normal path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item">クーポン</span>
            </p>
        @endif
        @if ($current_route_name == 'shop.map')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="red-normal path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item">地図</span>
            </p>
        @endif
        @if ($current_route_name == 'shop.comment_detail')
            <p class="p-path-list">
                <a class="red-normal path-list-item" href="/">EPARKスイーツガイド</a>
                @if(!empty($region))
                    <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug]) }}">{{$region->category_name}}</a>
                    @if(!empty($subRegion))
                        <a class="red-normal path-list-item" href="{{ route('shopsearch.region', [$region->slug, $subRegion->slug]) }}">{{$subRegion->category_name}}</a>
                    @endif
                @endif
                <a class="path-list-item" href="{{ route('shop.index', $shopId) }}">店舗詳細</a>
                <span class="path-list-item"><a href="{{ route('shop.comments', $shopId) }}">口コミ</a></span>
            </p>
            <h1 class="path-list-item breadcrumb-style">{{$comment->content_title }}</h1>
        @endif
        @if ($current_route_name == 'privacy')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > プライバシーポリシー</p>
        @endif
        @if ($current_route_name == 'about_us')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > 運営会社</p>
        @endif
        @if ($current_route_name == 'terms')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > 利用規約</p>
        @endif
        @if ($current_route_name == 'contact')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > お問い合わせ > 資料請求・お問い合わせ</p>
        @endif
        @if ($current_route_name == 'contact_confirm')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > お問い合わせ > お問い合わせ入力の確認</p>
        @endif
        @if ($current_route_name == 'contact_complete')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > お問い合わせ > お問い合わせの送信完了</p>
        @endif
        @if ($current_route_name == 'login')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > ログイン</p>
        @endif
        @if ($current_route_name == 'original-333')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > 新・入園入学キャンペーン</p>
        @endif
        @if ($current_route_name == 'shopsearch.all' || $current_route_name == 'shopsearch.station' || $current_route_name == 'shopsearch.region')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a>
            @if(!empty($searchResult['region']) && $regionId != $parentRegion->id)
                ＞
                <a class="red-normal" href="{{ route('shopsearch.region', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], [])) }}" class="">{{ $regionName }}</a>
            @endif
            @if(!empty($searchResult['station']) && !empty($parentRegion))
                ＞
                <a class="red-normal" href="{{ route('shopsearch.region', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], [])) }}" class="">{{ $searchResult['station'] }}</a>
            @endif
            @if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort))
                ＞{{ $titleDescriptionKeywordH1['h1'] }}
            @endif
            </p>
        @endif
        @if ($current_route_name == 'browsing_history')
            <p><a class="red-normal" href="/">EPARKスイーツガイド</a> > 閲覧履歴</p>
        @endif
    </div>
    <div class="main-foot">
        <div id="epark-global-footer-box"></div>
        <script type="text/javascript">$(function(){get_epark_portal_global_footer_html('sweetsguide');});</script>
        <ul class="ul-menu-foot">
            <li><a href="{{ route('privacy') }}"> プライバシーポリシー</a></li>
            <li><span> ｜ </span><a target="__blank" href="http://www.epark.jp/terms">会員規約</a></li>
            <li><span> ｜ </span><a href="{{ route('terms') }}">利用規約</a></li>
            <li><span> ｜ </span><a href="{{ route('contact') }}">お問い合わせ</a></li>
        </ul>
        <a href="http://owner.sweetsguide.jp/" target="_blank" class="a-link-foot">掲載ご希望のスイーツ店様はこちら</a>
        <p class="copyright">(c) 2007-2016 EPARK sweets, Inc.</p>
    </div>
</footer>
